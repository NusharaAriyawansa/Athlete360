<?php

class A_MemberManage extends Controller{

    public function index() {
        $userModel = new Users();
        $data['members'] = $userModel->findMember();
        $data['total_members'] = $userModel->totalMembers();
        $data['active_members'] = $userModel->activeMembers();
        $data['inactive_members'] = $userModel->inactiveMembers();
        $data['new_members'] = $userModel->newMembers();

        $currentDate = date("d"); 
        if(false){

            echo '<script>alert("Hello, this is an alert from PHP!");</script>';

            $today =  date('Y-m-d');
            $from = date("Y-m-d", strtotime("-1 month"));
            
        $notifi = new payment_notification();
        $notifi->sent_notification();
        
        
        $obj_calculate_salary = new Coach_salary_club_sessions_admin();
        $obj_calculate_salary->calculate($from,$today);


        }

        $this->view('admin/memberManage', 'admin',$data);
    
    }

    public function delete($userID): void
    {
        $ad = new Users();
        $ad->deleteMember($userID);

        redirect('A_MemberManage'); 
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

            $ageGroup = $_POST['updateAgeGroup']; 
            $school = $_POST['updateSchool'];
            $grade = $_POST['updateGrade']; 
            $status = $_POST['updateStatus']; 
            $regDate = $_POST['updateRegDate']; 
            $pName = $_POST['updatePName']; 
            $pRelationship = $_POST['updatePRelationship']; 
            $pContactNo = $_POST['updatePContactNo']; 
           
            $usersModel = new Users();
            $usersModel->updateMember($userID, $name, $email, $nic, $contactNo, $gender, $address, $dob, $ageGroup, $school, $grade, $status, $regDate, $pName, $pRelationship, $pContactNo);

        }
        redirect('A_MemberManage');         
    }
 









}

   
    



    

   

    



    


    


