<?php

class Resources{

    use Model;
    
    protected $table = 'resources'; 
    protected $allowedColumns = [
        'resourceID',
        'name',
        'description',
        'status'
    ];

    public function addResource($name, $description, $status)
    {
        $sql="INSERT INTO resources (resourceID, name, description, status) VALUES (NULL, $name, $description, $status)";

        return $this->insert($sql);
    }

    public function findResource()
    {
        $query="select id,title,description from advertisements";
        $result=$this->findAll($query);
    
    if ($result->num_rows > 0) {
        $a=array();   
        return $result;
        } else {
            echo "0 results";
        }
    }

public function deleteResource($resourceID)
    {
        $query = "DELETE FROM resources WHERE id = '$resourceID'";

        return $this->delete($query);
    }
    
}
