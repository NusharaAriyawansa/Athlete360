<?php

class AttendanceModel {

    use Database;
    use Model;

    public function getSessionOccurrences($sessionId) {
        $db = $this->connect();
    
        if (!$db->ping()) {
            $db = $this->connect();  // Reconnect or handle error
            if (!$db->ping()) {
                throw new Exception("Unable to connect to the database.");
            }
        }
    
        $query = "SELECT session_id, session_date FROM SessionOccurrences WHERE session_id = ?";
        $stmt = $db->prepare($query);
        if (!$stmt) {
            // Error preparing the statement
            error_log("Prepare failed: " . $db->error);
            throw new Exception("Error preparing statement: " . $db->error);
        }
    
        $stmt->bind_param('i', $sessionId);
        if (!$stmt->execute()) {
            // Error executing the statement
            error_log("Execute failed: " . $stmt->error);
            throw new Exception("Error executing statement: " . $stmt->error);
        }
    
        $result = $stmt->get_result();
        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $data;
        } else {
            // Error in getting result
            error_log("Getting result failed: " . $stmt->error);
            throw new Exception("Error getting results: " . $stmt->error);
        }
    }


    public function getPastAttendance($sessionId, $date) {
        $sql = "SELECT u.name, a.attendance_status, 'member' as type
                FROM users u
                JOIN attendance a ON u.userID = a.user_id
                JOIN SessionMembers sm ON sm.member_id = u.userID
                WHERE a.session_id = ? AND a.attendance_date = ?
                UNION
                SELECT u.name, a.attendance_status, 'coach' as type
                FROM users u
                JOIN attendance a ON u.userID = a.user_id
                JOIN SessionCoaches sc ON sc.coach_id = u.userID
                WHERE a.session_id = ? AND a.attendance_date = ?
                ORDER BY type, name ASC";
    
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Unable to prepare the statement: " . $conn->error);
        }
        $stmt->bind_param('isis', $sessionId, $date, $sessionId, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    
    
    public function getMembersForSession($sessionId, $date) {
        $sql = "SELECT m.memberID, u.name, COALESCE(a.attendance_status, 'Absent') AS attendance_status
                FROM users u
                JOIN memberdetails m ON m.userID = u.userID
                JOIN SessionMembers sm ON sm.member_id = m.memberID
                LEFT JOIN attendance a ON a.user_id = m.memberID AND a.session_id = sm.session_id AND a.attendance_date = '$date'
                WHERE sm.session_id = $sessionId";
        $stmt = $this->query($sql);
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }


    public function getCoachesForSession($sessionId, $date) {
        $sql = "SELECT c.coachID, u.name, COALESCE(a.attendance_status, 'Absent') AS attendance_status
                FROM users u
                JOIN coachdetails c ON c.userID = u.userID
                JOIN SessionCoaches sc ON sc.coach_id = c.coachID
                LEFT JOIN attendance a ON a.user_id = c.coachID AND a.session_id = sc.session_id AND a.attendance_date = '$date'
                WHERE sc.session_id = $sessionId";
        $stmt = $this->query($sql);
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    
    // Mark attendance for a session on a particular day
    public function markAttendance($sessionId, $attendanceData, $date) {
        
       

        $con = $this->connect();
        $con->begin_transaction();

       

        try {
            $sql = "INSERT INTO Attendance (occurrence_id,session_id, user_id, attendance_status, attendance_date,coach_id)
                    VALUES (?,?, ?, ?, ?,?) ON DUPLICATE KEY UPDATE attendance_status = VALUES(attendance_status)";
            $stmt = $con->prepare($sql);
            foreach ($attendanceData as $memberId => $status) {
                
                $stmt->bind_param('iiissi',$occ_id, $sessionId, $memberId, $status, $date,$coach_id);
                if(!$stmt->execute()) {
                    throw new Exception("Failed to execute attendance update for member ID $memberId: " . $stmt->error);
                }
            }
          $con->commit();

          
            return true;
        } catch (Exception $e) {
            $con->rollback();
            error_log('Transaction failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        } finally {
            $con->close();
        }
    }
    
    
    
    public function getMemberAttendanceByStatus($memberId) {
        $conn = $this->connect();
        $sql = "SELECT a.session_id, s.session_name, a.attendance_status, a.attendance_date
                FROM attendance a
                JOIN sessions s ON a.session_id = s.session_id
                WHERE a.user_id = ?
                ORDER BY a.attendance_date DESC";
    
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Unable to prepare statement: " . $conn->error);
        }
        $stmt->bind_param('i', $memberId);
        if (!$stmt->execute()) {
            throw new Exception("Error executing statement: " . $stmt->error);
        }
        $result = $stmt->get_result();
        $attended = [];
        $absent = [];
        while ($row = $result->fetch_assoc()) {
            if ($row['attendance_status'] === 'Present') {
                $attended[] = $row;
            } else {
                $absent[] = $row;
            }
        }
        return ['attended' => $attended, 'absent' => $absent];
    }
    

    public function getUpcomingSessionsByUserId($userId) {
        $db = $this->connect();
        $sql = "SELECT s.session_name, so.session_date, s.start_time, s.end_time
                FROM sessions s
                JOIN sessionoccurrences so ON s.session_id = so.session_id
                JOIN sessionmembers sm ON sm.session_id = s.session_id
                WHERE sm.member_id = ? AND so.session_date >= CURDATE()
                ORDER BY so.session_date ASC";

        $stmt = $db->prepare($sql);
        if (!$stmt) {
            throw new Exception("Unable to prepare statement: " . $db->error);
        }
        $stmt->bind_param('i', $userId);
        if (!$stmt->execute()) {
            throw new Exception("Error executing statement: " . $stmt->error);
        }
        $result = $stmt->get_result();
        $sessions = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $sessions;
    }



    function getUserAttendance($userId, $status) {
        $con = $this->connect(); 
        $sql = "SELECT a.session_id, s.session_name, a.attendance_date, a.attendance_status
                FROM Attendance a
                JOIN Sessions s ON a.session_id = s.session_id
                WHERE a.user_id = ? AND a.attendance_status = ?
                ORDER BY a.attendance_date DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$userId, $status]);
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    function getMonthlyAttendanceForLastSixMonths($userId) {
        $db = $this->connect();
    
        $query = "SELECT 
                    DATE_FORMAT(attendance_date, '%Y-%m') AS month,
                    attendance_status, 
                    COUNT(*) AS count 
                  FROM Attendance 
                  WHERE user_id = ? 
                    AND attendance_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                    AND attendance_date <= CURDATE()  
                  GROUP BY month, attendance_status
                  ORDER BY month DESC";  
        $stmt = $db->prepare($query);
        if (!$stmt) {
            die('MySQL prepare error: ' . $db->error);
        }
    
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $attendanceData = [];
        while ($row = $result->fetch_assoc()) {
            if (!isset($attendanceData[$row['month']])) {
                $attendanceData[$row['month']] = [];
            }
            $attendanceData[$row['month']][$row['attendance_status']] = $row['count'];
        }
        $stmt->close();
    
        return $attendanceData;
    }
    

    function getSessionAttendanceData($userId) {
        $db = $this->connect(); 
        
        $query = "SELECT DATE_FORMAT(attendance_date, '%Y-%m') AS session_date, attendance_status, COUNT(*) AS count
                FROM Attendance
                WHERE user_id = ?
                GROUP BY session_date, attendance_status
                ORDER BY session_date ASC;
            ";
    
        $stmt = $db->prepare($query);
        if (!$stmt) {
            die('MySQL prepare error: ' . $db->error);
        }
    
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $attendanceData = [];
        while ($row = $result->fetch_assoc()) {
            $date = $row['session_date'];
            if (!isset($attendanceData[$date])) {
                $attendanceData[$date] = ['Present' => 0, 'Absent' => 0];
            }
            $attendanceData[$date][$row['attendance_status']] = (int)$row['count'];
        }
        $stmt->close();
    
        $formattedData = [];
        foreach ($attendanceData as $date => $counts) {
            $total = $counts['Present'] + $counts['Absent'];
            $present = $counts['Present'];
            $formattedData['dates'][] = $date;
            $formattedData['totals'][] = $total;
            $formattedData['present'][] = $present;
        }
    
        return $formattedData;
    }
    
    

    
}