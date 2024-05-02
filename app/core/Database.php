<?php

trait Database{
   
    private function connect(){
        //$con = new mysqli("localhost", "root", "","athlete360"); 
        $con = new mysqli(DBHOST, DBUSER, "", DBNAME); 
        return $con;
    }

    public function query($query){
        $con = $this->connect();
        $result = $con->query($query);

        return $result;
    }

    //read only one record
   /* public function get_row($query, $data=[]){

        $con = $this->connect();
        $stm = $con->prepare($query);        

        $check = $stm->execute($data);     
        if($check){
            $result = $stm->fetchAll(PDO::FETCH_OBJ); 
            if(is_array($result) && count($result)){
                return $result[0]; 
            }
        }
        return false;        
    }*/

    
   /* public function query_new($sql){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "athlete360";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
    }

     
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
       
    }*/







//}



//trait Database{
/*
    protected $db;

    public function __construct() {
        $this->db = $this->connect(); // Ensure this correctly initializes the $db property
    }
    
    private function connect(){
        // Corrected DSN format: replaced "hostname" with "host"
        $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4";
        try {
            $conn = new PDO($string, DBUSER, DBPASS);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            // Consider logging the error and/or displaying a user-friendly message
            die("Connection failed: " . $e->getMessage());
        }
    }
    

    //read records from the table
    public function query($query, $data=[]){

        $conn = $this->connect();
        $stm = $conn->prepare($query);       //prepare the query 

        $check = $stm->execute($data);     //check whether it works (apply any data if available)
        if($check){
            $result = $stm->fetchAll(PDO::FETCH_OBJ); 
            if(is_array($result) && count($result)){
                return $result; 
            }
        }
        return false;        //for update and delete (not returning anything)
    }

    //read only one record
    public function get_row($query, $data=[]){

        $conn = $this->connect();
        $stm = $conn->prepare($query);        

        $check = $stm->execute($data);     
        if($check){
            $result = $stm->fetchAll(PDO::FETCH_OBJ); 
            if(is_array($result) && count($result)){
                return $result[0]; 
            }
        }
        return false;        
    }

    





*/
}







