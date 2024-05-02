<?php

class ProfileModel {
    use Database;

    public function getMemberDetails($userId) {
        $db = $this->connect();
        $stmt = $db->prepare("SELECT md.*, u.name, u.email, u.NIC, u.contactNo, u.gender, u.address, u.dob FROM memberdetails md JOIN users u ON md.userID = u.userID WHERE md.userID = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    

    public function updateMemberDetails($userId, $data) {
        $db = $this->connect();
        $sql = "UPDATE memberdetails SET school=?, pName=?, pContactNo=?, pRelationship=? WHERE userID=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssssi", $data['school'], $data['pName'], $data['pContactNo'], $data['pRelationship'], $userId);
        return $stmt->execute();
    }


    public function updateUser($userId, $data) {
        $db = $this->connect();
        $sql = "UPDATE users SET name=?, email=?, contactNo=?, NIC=?, gender=?, address=?, dob=? WHERE userID=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssssssi", $data['name'], $data['email'], $data['contactNo'], $data['nic'], $data['gender'], $data['address'], $data['dob'], $userId);
        return $stmt->execute();
    }


    public function getCoachDetails($userId) {
        $db = $this->connect();
        $stmt = $db->prepare("SELECT cd.*, u.name, u.email, u.NIC, u.contactNo, u.gender, u.address, u.dob FROM coachdetails cd JOIN users u ON cd.userID = u.userID WHERE cd.userID = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    

    public function updateCoachDetails($userId, $data) {
        $db = $this->connect();
        $sql = "UPDATE coachdetails SET qualifications=? WHERE userID=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("si", $data['qualifications'], $userId);
        return $stmt->execute();
    }


    public function checkPassword($userId, $oldPassword) {
        $db = $this->connect();
        $stmt = $db->prepare("SELECT password FROM users WHERE userID = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result && password_verify($oldPassword, $result['password'])) {
            return true;
        }
        return false;
    }

    public function updatePassword($userId, $newPasswordHash) {
        $db = $this->connect();
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE userID = ?");
        $stmt->bind_param("si", $newPasswordHash, $userId);
        return $stmt->execute();
    }

}
