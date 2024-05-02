<?php

class MemberSessionsModel {

    use Database;

    // Add a session to a member's selections
    public function addMemberSession($member_id, $session_id) {
        $sql = 'INSERT INTO Member_Sessions (member_id, session_id) VALUES (:member_id, :session_id)';
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $stmt->bindValue(':session_id', $session_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get all sessions selected by a member
    public function getMemberSessions($member_id) {
        $sql = 'SELECT Sessions.* FROM Sessions JOIN Member_Sessions ON Sessions.session_id = Member_Sessions.session_id WHERE Member_Sessions.member_id = :member_id';
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':member_id', $member_id, PDO::PARAM_INT);
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log('Add Session Error: ' . $e->getMessage());
            return false;
        }
        
    }

    // Remove a session from a member's selections
    public function removeMemberSession($member_id, $session_id) {
        $sql = 'DELETE FROM Member_Sessions WHERE member_id = :member_id AND session_id = :session_id';
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $stmt->bindValue(':session_id', $session_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
