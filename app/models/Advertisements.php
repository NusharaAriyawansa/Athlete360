<?php

class Advertisements{

    use Model;

    public function find()
    {
        $query="select id,title,description, DATE_FORMAT(timestamp, '%Y-%m-%d') AS dateOnly from advertisements ORDER BY timestamp DESC";
        $result=$this->findAll($query);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }   
    }

    public function addAd($title,$description)
    {        
        $author='admin';        // author by default is set to admin 
        $timestamp = date('Y-m-d H:i:s');  // to format the date 
        $sql="INSERT INTO advertisements (id, title, author, description, timestamp) VALUES (NULL, '$title', '$author', '$description', '$timestamp')";

        return $this->insert($sql);
    }

    public function deleteAd($id)
    {
        $query = "DELETE FROM advertisements WHERE id = $id";

        return $this->delete($query);
    }

    public function updateAd($id,$timestamp, $title,$description)
    {
        $timestamp = date('Y-m-d H:i:s'); 
        $sql = "UPDATE advertisements SET title = '$title' , description='$description', timestamp = '$timestamp' WHERE advertisements.id = '$id'";
        return $this->delete($sql);
    }

    public function totalAds() {
        $query = "SELECT COUNT(*) as total FROM advertisements";
        $result = $this->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        } else {
            return 0; 
        }
    }

    public function weeklyAds() {
        $query = "SELECT COUNT(*) AS weekly_ads FROM advertisements WHERE WEEK(timestamp) = WEEK(CURDATE()) AND YEAR(timestamp) = YEAR(CURDATE())";
        $result = $this->query($query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['weekly_ads'];
        } else {
            return 0; 
        }        
    }

    public function load_announcement_top4(){
        $sql="SELECT * FROM advertisements ORDER BY id LIMIT 4";
        $data = $this->findAll($sql);
        return $data;
    }
    

}
