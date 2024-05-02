<?php
class Model_new{
    private function connect(){
       // $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new mysqli("localhost", "lakruwan", "123","athlete360"); 
        return $con;
    }

    //read records from the table
    public function query($query){

        $con = $this->connect();
       // $result=$con->query($query);
       $result = $con->query($query);

       
        return $result;
        
          
    }
   /* public function findAll($data){

        
        
       
            $sql=strval($data);

            if($sql!=NULL){
                 $result=$this->query($sql);
                
                 
        
       
            }
            return $result;
        }   
    
*/
    //get multiple records  
   /* public function where($data, $data_not = []){   

        $keys = array_keys($data); 
        $keys_not = array_keys($data_not); 
        $query = "select * from $this->table where "; 

        foreach($keys as $key){
            $query .=$key . " = :". $key . "&& ";
        }

        foreach($keys_not as $key){
            $query .=$key . " != :". $key . "&& ";
        }

        $query = trim($query, " && "); 

        $query .= " order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);
        return $this->query($query, $data);        
    }*/

    //get one record  
    /*public function first($data, $data_not = []){

        $keys = array_keys($data); 
        $keys_not = array_keys($data_not); 
        $query = "select * from $this->table where "; 

        foreach($keys as $key){
            $query .=$key . " = :". $key . "&& ";
        }

        foreach($keys_not as $key){
            $query .=$key . " != :". $key . "&& ";
        }

        $query = trim($query, " && "); 

        $query .= " limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);

        $result = $this->query($query, $data);     
        if($result){
            return $result[0];
        }
        return false;   
    }
*/
    //insert records
    public function insert($data){
        
        /*$sql="INSERT INTO booked_nets (bookingId, booked_net_id) VALUES (114, 1)";
        $conn->query($sql);*/
       
        $sql=strval($data);
        //$sql="INSERT INTO booked_nets (bookingId, booked_net_id) VALUES ('234', '8')";
        if($sql!=NULL){
            return $this->query($sql);
    }
    }

/*

    //update records
    public function update($id, $data, $id_column = 'id'){

        //remove unwanted data 
        if(!empty($this-> allowedColumns)){
            foreach($data as $key => $value){
                if(!in_array($key, $this->allowedColumns)){
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data); 
        $query = "update $this->table set "; 

        foreach($keys as $key){
            $query .=$key . " = :". $key . ", ";
        }

        $query = trim($query, ", "); 

        $query .= " where $id_column = :$id_column ";
        $data[$id_column] = $id; 

        $this->query($query, $data);
        return false;   
    }

    //delete records
    public function delete($query){
       

        $this->query($query);
        return false;
    }

    






*/



}