<?php

class Profile_Admin{
    
    use Model;

    public function find($userID) {
        $query = "SELECT * FROM users WHERE userID= '$userID'";
        $result = $this->findAll($query);
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); 
        } else {
            echo "0 results";
            return null;
        }
    }
    


}