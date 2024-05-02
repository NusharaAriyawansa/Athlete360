<?php

class H_Register extends Controller{

    public function index(): void {
        $_SESSION["user"]=null;
        $data = [];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email=$_POST['email'];
            $password = $_POST['password']; 
            $nic = $_POST['nic']; 
            $contactNo = $_POST['contactNo']; 
            $gender = $_POST['gender']; 
            $address = $_POST['address']; 
            $dob = $_POST['dob']; 

            $ageGroup = $_POST['ageGroup']; 
            $school = $_POST['school'];
            $grade = $_POST['grade']; 
            $status = $_POST['status']; 
            $regDate = $_POST['regDate']; 
            $pName = $_POST['pName']; 
            $pRelationship = $_POST['pRelationship']; 
            $pContactNo = $_POST['pContactNo']; 
           
            $usersModel = new Users();
            $usersModel->addMember($name, $email, $password, $nic, $contactNo, $gender, $address, $dob, $ageGroup, $school, $grade, $status, $regDate, $pName, $pRelationship, $pContactNo);
            redirect('H_Login');
           
        }
        $this->view('home/register', $data); 
    }




   
   





    
}

