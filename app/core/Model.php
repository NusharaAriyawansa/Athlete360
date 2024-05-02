<?php

trait Model {

    use Database;   

    //find all records 
    public function findAll($data){
        $sql=strval($data);

        if($sql!=NULL){
            $result=$this->query($sql);
        }
        return $result;
    }   

    //insert records
    public function insert($data){
        $sql=strval($data);
        if($sql!=NULL){
            $this->query($sql);
        }
    }

    //delete records
    public function delete($query){
        $this->query($query);
        return false;
    }

    public function send_sms($to,$text){
        $user = "94776218353";
        $password = "9278";

       // $text = "This is some text that we want to encode!";

        $encodedText = urlencode($text);

        
        $baseurl = "http://www.textit.biz/sendmsg";
        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$encodedText";

        $ret = @file($url);

        if ($ret === false) {
            echo "Failed to read from the file or URL.";

            $alertMessage = "This is an alert message from PHP!";
            echo "<script type='text/javascript'>alert('$url');</script>";

        } else {
            $res = explode(":", $ret[0]);
            // Process $res as needed
        }

}





    
    /*private function connect(){
        $string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new mysqli("localhost", "root", "","athlete360"); 
        return $con;
    }

    public function query($query){
       $con = $this->connect();
       $result = $con->query($query);
        return $result;         
    }*/


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
    



    //update records
    /*public function update($id, $data, $id_column = 'id'){

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
    }*/

    

    










}

