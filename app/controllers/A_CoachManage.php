<?php

class A_CoachManage extends Controller{

    public function index() {
        $userModel = new Users();
        $data['coaches'] = $userModel->findCoach();
        $data['total_coaches'] = $userModel->totalCoaches();
        $data['active_coaches'] = $userModel->activeCoaches();
        $data['inactive_coaches'] = $userModel->inactiveCoaches();
        $data['new_coaches'] = $userModel->newCoaches();

        $this->view('admin/coachManage', 'admin',$data);
    }

    public function add(): void {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email=$_POST['email'];
            $nic = $_POST['nic']; 
            $contactNo = $_POST['contactNo']; 
            $gender = $_POST['gender']; 
            $address = $_POST['address']; 
            $dob = $_POST['dob'];
            
            $yearsOfExperience = $_POST['yearsOfExperience'];
            $qualifications = $_POST['qualifications'];

            $usersModel = new Users();
            $usersModel->addCoach($name, $email, $nic, $contactNo, $gender, $address, $dob, $yearsOfExperience, $qualifications);
            redirect('A_CoachManage');        
        }     
    }

    public function delete($userID): void
    {
        $ad = new Users();
        $ad->deleteCoach($userID);

        redirect('A_CoachManage'); 
    }

    public function update(): void {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userID = $_POST['updateID'];
            $name = $_POST['updateName'];
            $email=$_POST['updateEmail'];
            $nic = $_POST['updateNic']; 
            $contactNo = $_POST['updateContactNo']; 
            $gender = $_POST['updateGender']; 
            $address = $_POST['updateAddress']; 
            $dob = $_POST['updateDob']; 
            
            $yearsOfExperience = $_POST['updateYearsOfExperience'];
            $qualifications = $_POST['updateQualifications'];
            $salary = $_POST['updateSalary'];
            $status = $_POST['updateStatus'];

            $usersModel = new Users();
            $usersModel->updateCoach($userID, $name, $email, $nic, $contactNo, $gender, $address, $dob, $yearsOfExperience, $qualifications, $salary, $status);
            redirect('A_CoachManage');        
        }     
    }



    




}


   

    



    


    

