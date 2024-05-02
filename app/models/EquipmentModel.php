<?php

class EquipmentModel {

    use Database;

    public function getAllAvailableEquipment() {
        $query = "SELECT e.id, e.name, e.availability, e.last_maintained_date, e.price_for_hiring,
                         s.session_id, s.session_name, s.day, s.start_time, s.end_time
                  FROM equipments e
                  LEFT JOIN equipment_sessions es ON e.id = es.equipment_id
                  LEFT JOIN sessions s ON es.session_id = s.session_id
                  WHERE e.availability = 'Available'";
        $result = $this->query($query);
        $equipments = [];
        while ($row = $result->fetch_assoc()) {
            $equipId = $row['id'];
            if (!isset($equipments[$equipId])) {
                $equipments[$equipId] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'availability' => $row['availability'],
                    'last_maintained_date' => $row['last_maintained_date'],
                    'price_for_hiring' => $row['price_for_hiring'],
                    'sessions' => []
                ];
            }
            if ($row['session_id'] != null) { 
                $equipments[$equipId]['sessions'][] = [
                    'session_id' => $row['session_id'],
                    'session_name' => $row['session_name'],
                    'day' => $row['day'],
                    'start_time' => $row['start_time'],
                    'end_time' => $row['end_time']
                ];
            }
        }
        return $equipments;
    }
    

    public function getAllSessions() {
        $query = "SELECT * FROM Sessions";
        $result = $this->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMaintainingEquipment() {
        $query = "SELECT * FROM equipments WHERE availability = 'Unavailable'";
        return $this->query($query);
    }


    public function addEquipment($name, $availability, $price) {
        $con = $this->connect();
        $name = $con->real_escape_string($name);
        $availability = $con->real_escape_string($availability);
        $price = $con->real_escape_string($price);
    
        $sql = "INSERT INTO equipments (name, availability, last_maintained_date, price_for_hiring) VALUES ('$name', '$availability', CURDATE(), '$price')";
        $this->query($sql);
    }
    

    public function deleteEquipment($id) {
        $sql = "DELETE FROM equipments WHERE id = $id";
        $this->query($sql);
    }    


    public function setToMaintaining($equipmentId) {
        $equipmentId = intval($equipmentId);
        $sql = "UPDATE equipments SET availability = 'Unavailable' WHERE id = $equipmentId";
        return $this->query($sql);
    }
    

    public function doneMaintaining($id) {
        $sql = "UPDATE equipments SET availability = 'Available', last_maintained_date = CURDATE() WHERE id = $id";
        $this->query($sql);
    }
    

    public function addSessionToEquipment($equipmentId, $sessionId) {
        $con = $this->connect();
        $sessionQuery = "SELECT DATE(start_time) as day, start_time, end_time FROM Sessions WHERE session_id = ?";
        $sessionStmt = $con->prepare($sessionQuery);
        $sessionStmt->bind_param('i', $sessionId);
        $sessionStmt->execute();
        $sessionResult = $sessionStmt->get_result();
        $sessionInfo = $sessionResult->fetch_assoc();
    
        if (!$sessionInfo) {
            throw new Exception("No session found with the given ID.");
        }
    
        // Check for any equipment conflicts on the same day
        $conflictQuery = "SELECT se.session_id FROM equipment_sessions se
                          JOIN Sessions s ON se.session_id = s.session_id
                          WHERE se.equipment_id = ? AND DATE(s.start_time) = ? AND
                                ((s.start_time < ? AND s.end_time > ?) OR
                                 (s.start_time < ? AND s.end_time > ?) OR
                                 (s.start_time >= ? AND s.end_time <= ?))";
        $conflictStmt = $con->prepare($conflictQuery);
        $conflictStmt->bind_param('isssssss', $equipmentId, 
                                   $sessionInfo['day'], 
                                   $sessionInfo['start_time'], $sessionInfo['start_time'],
                                   $sessionInfo['end_time'], $sessionInfo['end_time'],
                                   $sessionInfo['start_time'], $sessionInfo['end_time']);
        $conflictStmt->execute();
        $conflictResult = $conflictStmt->get_result();
    
        if ($conflictResult->num_rows > 0) {
            throw new Exception("This equipment is already allocated to another session during the specified time on the same day.");
        }
    
        // If no conflicts, add equipment to session
        $insertQuery = "INSERT INTO equipment_sessions (session_id, equipment_id) VALUES (?, ?)";
        $insertStmt = $con->prepare($insertQuery);
        if (!$insertStmt) {
            throw new Exception("Failed to prepare the statement to add equipment to the session.");
        }
        $insertStmt->bind_param('ii', $sessionId, $equipmentId);
        if (!$insertStmt->execute()) {
            throw new Exception("Failed to add equipment to the session.");
        }
    
        return true;
    }
    
    
    public function deleteEquipmentSession($equipmentId, $sessionId) {
        $sql = "DELETE FROM equipment_sessions WHERE equipment_id = $equipmentId AND session_id = $sessionId";
        $this->query($sql);
    }
    









    public function getEquipmentDetails($equipmentId) {
        $equipmentId = $this->connect()->real_escape_string($equipmentId);
        $query = "SELECT id, name, availability, last_maintained_date, price_for_hiring 
                  FROM equipments 
                  WHERE id = '$equipmentId'";
        return $this->query($query)->fetch_assoc();  // Assuming this method returns the fetched data as an associative array
    }

    public function getSessionsForEquipment($equipmentId) {
        $equipmentId = $this->connect()->real_escape_string($equipmentId);
        $query = "SELECT s.session_id, s.session_name, s.day, s.start_time, s.end_time 
                  FROM sessions s
                  JOIN equipment_sessions es ON s.session_id = es.session_id
                  WHERE es.equipment_id = '$equipmentId'";
        $result = $this->query($query);
        $sessions = [];
        while ($row = $result->fetch_assoc()) {
            $sessions[] = $row;
        }
        return $sessions;
    }
    
}
