<?php

class Queries{

    use Model;

    public function find_replied($userID)
    {
        $query="SELECT * from queries WHERE userID = $userID AND reply IS NOT NULL ORDER BY DateTime DESC;";
        $result=$this->findAll($query);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }   
    }

    public function addQuery($type,$description)
    {        
        $userID=$_SESSION["real_user_id"];
        $dateTime = date('Y-m-d H:i:s');
        $sql="INSERT INTO queries (dateTime, type, description, userID) VALUES ('$dateTime', '$type', '$description', '$userID')";

        return $this->insert($sql);
    }

    public function deleteQuery($queryID)
    {
        $query = "DELETE FROM queries WHERE queryID = $queryID";

        return $this->delete($query);
    }

    public function updateQuery($queryID,$reply)
    {
        $sql = "UPDATE queries SET reply = '$reply' WHERE queryID = '$queryID'";
        return $this->delete($sql);
    }


    public function find_queries_by_coaches()
    {
        $query="SELECT * 
            FROM queries q 
            JOIN users u ON u.userID = q.userID 
            WHERE (u.role = 'headcoach' OR u.role = 'coach') 
                AND q.reply IS NULL
                AND YEAR(q.dateTime) = YEAR(CURRENT_DATE()) 
                AND MONTH(q.dateTime) = MONTH(CURRENT_DATE())
            ORDER BY q.dateTime DESC;";

        $result=$this->findAll($query);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }   
    }

    public function find_queries_by_members()
    {
        $query="SELECT * 
            FROM queries q 
            JOIN users u ON u.userID = q.userID 
            WHERE u.role = 'member' 
                AND q.reply IS NULL
                AND YEAR(q.dateTime) = YEAR(CURRENT_DATE()) 
                AND MONTH(q.dateTime) = MONTH(CURRENT_DATE())
            ORDER BY q.dateTime DESC;";

        $result=$this->findAll($query);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }   
    }

    public function coaches_total() {
        $query="SELECT COUNT(*) AS count 
            FROM queries q 
            JOIN users u ON u.userID = q.userID 
            WHERE (u.role = 'headcoach' OR u.role = 'coach') 
                AND YEAR(q.dateTime) = YEAR(CURRENT_DATE()) 
                AND MONTH(q.dateTime) = MONTH(CURRENT_DATE())
            ORDER BY q.dateTime DESC;";

        $result = $this->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return 0; 
        }
    }

    public function coaches_reviewed() {
        $query="SELECT COUNT(*) AS count 
            FROM queries q 
            JOIN users u ON u.userID = q.userID 
            WHERE (u.role = 'headcoach' OR u.role = 'coach') 
                AND q.reply IS NOT NULL
                AND YEAR(q.dateTime) = YEAR(CURRENT_DATE()) 
                AND MONTH(q.dateTime) = MONTH(CURRENT_DATE())
            ORDER BY q.dateTime DESC;";

        $result = $this->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return 0; 
        }
    }

    public function coaches_to_be_reviewed() {
        $query="SELECT COUNT(*) AS count 
            FROM queries q 
            JOIN users u ON u.userID = q.userID 
            WHERE (u.role = 'headcoach' OR u.role = 'coach') 
                AND q.reply IS NULL
                AND YEAR(q.dateTime) = YEAR(CURRENT_DATE()) 
                AND MONTH(q.dateTime) = MONTH(CURRENT_DATE())
            ORDER BY q.dateTime DESC;";

        $result = $this->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return 0; 
        }

    }


    public function members_total() {
        $query="SELECT COUNT(*) AS count 
            FROM queries q 
            JOIN users u ON u.userID = q.userID 
            WHERE u.role = 'member'
                AND YEAR(q.dateTime) = YEAR(CURRENT_DATE()) 
                AND MONTH(q.dateTime) = MONTH(CURRENT_DATE())
            ORDER BY q.dateTime DESC;";

        $result = $this->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return 0; 
        }
    }

    public function members_reviewed() {
        $query="SELECT COUNT(*) AS count 
            FROM queries q 
            JOIN users u ON u.userID = q.userID 
            WHERE u.role = 'member'
                AND q.reply IS NOT NULL
                AND YEAR(q.dateTime) = YEAR(CURRENT_DATE()) 
                AND MONTH(q.dateTime) = MONTH(CURRENT_DATE())
            ORDER BY q.dateTime DESC;";

        $result = $this->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return 0; 
        }
    }

    public function members_to_be_reviewed() {
        $query="SELECT COUNT(*) AS count 
            FROM queries q 
            JOIN users u ON u.userID = q.userID 
            WHERE u.role = 'member'
                AND q.reply IS NULL
                AND YEAR(q.dateTime) = YEAR(CURRENT_DATE()) 
                AND MONTH(q.dateTime) = MONTH(CURRENT_DATE())
            ORDER BY q.dateTime DESC;";

        $result = $this->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return 0; 
        }

    }


















    
    

}