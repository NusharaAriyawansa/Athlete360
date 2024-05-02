<?php
class SessionModel {
    use Database;
    
    public function addSession($data) {
        $con = $this->connect();
        try {
            $con->begin_transaction();
    
            $sqlSession = "INSERT INTO Sessions (session_name, day, start_time, end_time, status) VALUES ('"
                . $con->real_escape_string($data['session_name']) . "', '"
                . $con->real_escape_string($data['day']) . "', '"
                . $con->real_escape_string($data['start_time']) . "', '"
                . $con->real_escape_string($data['end_time']) . "', '"
                . $con->real_escape_string($data['status']) . "')";
            $con->query($sqlSession);
            $sessionId = $con->insert_id;
    
            $sqlOccurrence = "INSERT INTO SessionOccurrences (session_id, session_date) VALUES (?, ?)";
            $stmtOccurrence = $con->prepare($sqlOccurrence);
            
            $today = new DateTime(); 
            $dayOfWeek = $today->format('l'); // Today's day of the week
            
            $nextSessionDate = new DateTime();
            if (strtolower($data['day']) == strtolower($dayOfWeek)) {
                $nextSessionDate = $today;
            } else {
                $nextSessionDate->modify('next ' . $data['day']);
            }
            
            for ($i = 0; $i < 5; $i++) {
                $stmtOccurrence->bind_param("is", $sessionId, $nextSessionDate->format('Y-m-d'));
                $stmtOccurrence->execute();
                $nextSessionDate->modify('+1 week');
            }
    
            $con->commit();
            return true;
        } catch (mysqli_sql_exception $e) {
            $con->rollback();
            error_log("Failed to insert session or its occurrences: " . $e->getMessage());
            return false;
        }
    }

    public function getAllSessions() {
        $query = "SELECT * FROM Sessions ORDER BY session_name ASC";
        $result = $this->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSessionById($session_id) {
        $session_id = intval($session_id);
        $query = "SELECT * FROM Sessions WHERE session_id = $session_id";
        $result = $this->query($query);
        return $result ? $result->fetch_assoc() : [];
    }

    public function updateSession($session_id, $data) {
        $con = $this->connect(); 
        $query = "UPDATE Sessions SET session_name = ?, day = ?, start_time = ?, end_time = ?, status = ? WHERE session_id = ?";
        $stmt = $con->prepare($query);
    
        if (!$stmt) {
            return false;
        }
    
        $stmt->bind_param('sssssi', $data['session_name'], $data['day'], $data['start_time'], $data['end_time'], $data['status'], $session_id);
    
        if (!$stmt->execute()) {
            return false;
        }
    
        return $this->updateSessionOccurrences($session_id, $data['day']);
    }
    

    private function updateSessionOccurrences($session_id, $newDay) {
        $con = $this->connect(); 
    
        $today = new DateTime();
        $today->setTime(0, 0, 0); 
        $formattedToday = $today->format('Y-m-d');
    
        $deleteQuery = "DELETE FROM SessionOccurrences WHERE session_id = ? AND session_date >= ?";
        $deleteStmt = $con->prepare($deleteQuery);
        if (!$deleteStmt) {
            return false; 
        }
        $deleteStmt->bind_param('is', $session_id, $formattedToday);
        if (!$deleteStmt->execute()) {
            return false;
        }
    
        $nextSessionDate = new DateTime();
        $nextSessionDate->modify('next ' . $newDay);
        if ($nextSessionDate < $today) {
            $nextSessionDate->modify('+1 week');
        }
    
        $insertQuery = "INSERT INTO SessionOccurrences (session_id, session_date) VALUES (?, ?)";
        $insertStmt = $con->prepare($insertQuery);
        if (!$insertStmt) {
            return false; 
        }
    
        while ($nextSessionDate->format('Y') === $today->format('Y')) { 
            $sessionDateString = $nextSessionDate->format('Y-m-d');
            $insertStmt->bind_param('is', $session_id, $sessionDateString);
            if (!$insertStmt->execute()) {
                return false; 
            }
            $nextSessionDate->modify('+1 week');
        }
    
        return true;
    }
    

    public function deleteSession($session_id) {
        $session_id = intval($session_id);
        $query = "DELETE FROM Sessions WHERE session_id = $session_id";
        return $this->query($query);
    }

    public function getSessionOccurrences($sessionId) {
        $sessionId = intval($sessionId);  // Ensure that session ID is an integer to prevent SQL injection
        $query = "SELECT * FROM SessionOccurrences WHERE session_id = $sessionId ORDER BY session_date";
        $result = $this->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function addMemberToSession($sessionId, $memberID) {
        $sessionId = intval($sessionId);
        $memberID = intval($memberID);
        $query = "INSERT INTO SessionMembers (session_id, member_id) VALUES ($sessionId, $memberID)";
        return $this->query($query);
    }

    public function removeMemberFromSession($userId, $sessionId) {
        $sessionId = intval($sessionId);
        $userId = intval($userId);
        $query = "DELETE FROM SessionMembers WHERE member_id = $userId AND session_id = $sessionId";
        return $this->query($query);
    }

    public function getSessionMembers($sessionId) {
        $sessionId = intval($sessionId);
        $query = "SELECT m.memberID, u.name, sm.member_id FROM memberdetails m
                JOIN users u ON m.userID = u.userID
                JOIN SessionMembers sm ON m.memberID = sm.member_id
                WHERE sm.session_id = $sessionId";
        $result = $this->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function addCoachToSession($sessionId, $userId) {
        $sessionId = intval($sessionId);
        $userId = intval($userId);
        $query = "INSERT INTO SessionCoaches (session_id, coach_id) VALUES ($sessionId, $userId)";
        return $this->query($query);
    }

    public function removeCoachFromSession($userId, $sessionId) {
        $sessionId = intval($sessionId);
        $userId = intval($userId);
        $query = "DELETE FROM SessionCoaches WHERE session_id = $sessionId AND coach_id = $userId";
        return $this->query($query);
    }

    public function getSessionCoaches($sessionId) {
        $sessionId = intval($sessionId);
        $query ="SELECT c.coachID, u.name, sc.coach_id FROM coachdetails c
                  JOIN users u ON c.userID = u.userID
                  JOIN SessionCoaches sc ON c.coachID = sc.coach_id
                  WHERE sc.session_id = $sessionId";
        $result = $this->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function updateAttendance($sessionId, $userId, $attended, $occurrenceId) {
        $sessionId = intval($sessionId);
        $userId = intval($userId);
        $attended = $attended ? 1 : 0;
        $occurrenceId = intval($occurrenceId);
        $query = "UPDATE SessionMember SET attendance = $attended WHERE session_id = $sessionId AND user_id = $userId AND occurrence_id = $occurrenceId";
        return $this->query($query);
    }

    public function getAttendanceByOccurrence($sessionId, $occurrenceId) {
        $sessionId = intval($sessionId);
        $occurrenceId = intval($occurrenceId);
        $query = "SELECT u.userID, u.name, sm.attendance FROM SessionMember sm
                  JOIN Users u ON sm.user_id = u.userID
                  WHERE sm.session_id = $sessionId AND sm.occurrence_id = $occurrenceId";
        $result = $this->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function searchMembersByName($name) {
        $safeName = $this->connect()->real_escape_string("%$name%");
        $query = "SELECT m.memberID, u.name 
                FROM Users u 
                JOIN memberdetails m ON m.userID = u.userID 
                WHERE u.name LIKE '%$safeName%' AND u.role = 'Member'";
        $result = $this->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function searchCoachesByName($name) {
        $safeName = $this->connect()->real_escape_string("%$name%");
        $query = "SELECT m.coachID, u.name 
                FROM Users u 
                JOIN coachdetails m ON m.userID = u.userID  
                WHERE u.name LIKE '$safeName' AND (u.role = 'Coach' OR u.role = 'headcoach')";
        $result = $this->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getEquipmentForSession($session_id) {
        $con = $this->connect(); 
        $sql = "SELECT e.* FROM equipments e 
                INNER JOIN equipment_sessions es ON e.id = es.equipment_id 
                WHERE es.session_id = ? AND e.availability = 'availabile'";
        
        $stmt = $con->prepare($sql);
        if (!$stmt) {
            return false;
        }
    
        $stmt->bind_param('i', $session_id); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); 
        } else {
            return []; 
        }
    }

    public function sessionNameExists($sessionName) {
        $con = $this->connect();
        $query = "SELECT COUNT(*) as count FROM Sessions WHERE session_name = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $sessionName);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
    
}


