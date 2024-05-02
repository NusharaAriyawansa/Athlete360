<?php
//session_start();
require_once('C:\xampp\htdocs\Athlete360\app\controllers\M_Dashboard.php');
class Users{

    use Model;
   
    public $current_user=NULL;
    
    public function addMember($name, $email, $password, $nic, $contactNo, $gender, $address, $dob, $ageGroup, $school, $grade, $status, $regDate, $pName, $pRelationship, $pContactNo)
    {
        $year = date("Y");
        $month = date("m");
        $date = date("d");

        $hour = date("H");
        $min = date("i");
        $seconds = date("s");

        $userID = $month+$date+$hour+$min;

        $role = 'member'; 
        $status = 'active';
        $regDate = date('Y-m-d H:i:s'); 

        //age group 
        $currentDate = new DateTime();
        $birthDate = new DateTime($dob);
        $age = $currentDate->diff($birthDate)->y;

        if ($age <= 13) {
            $ageGroup = 'under 13';
        } 
        else if ($age <= 15) {
            $ageGroup = 'under 15';
        } 
        else if ($age <= 17) {
            $ageGroup = 'under 17';
        } 
        else {
            $ageGroup = 'under 19'; 
        }
        
        $sql1 = "INSERT INTO users (userID, name, email, role, password, nic, contactNo, gender, address, dob) VALUES ('$userID', '$name', '$email', '$role', '$password', '$nic', '$contactNo', '$gender', '$address', '$dob')";
        $sql2 = "INSERT INTO memberdetails (userID, ageGroup, school, grade, status, regDate, pName, pRelationship, pContactNo) VALUES ('$userID', '$ageGroup', '$school', '$grade', '$status', '$regDate', '$pName', '$pRelationship', '$pContactNo')";
        
        $this->insert($sql1);
        $this->insert($sql2);
    }

    public function auth($email,$password){
        $query="SELECT userID,role FROM users WHERE email='$email' AND password='$password'";
        $txt = $this->findAll($query);        

        if($txt->num_rows>0){
            echo '<script>alert("Log in successful")</script>'; 
            $row = $txt->fetch_assoc();
            $_SESSION['userID'] = $row['userID'];
                        
            if($row['role']=="member"){
                $_SESSION["note"]="null";
                $current_user="member";

                $userID=$row['userID'];
                $_SESSION["real_user_id"] = $row['userID'];
                
                $query_new="SELECT memberID,ageGroup,status FROM memberdetails WHERE userID= '$userID'";
                $result_new = $this->findAll($query_new);
                $row_new = $result_new->fetch_assoc();

                $_SESSION["user_id"] =$row_new['memberID'];  
                $_SESSION["Age_Grp"]=$row_new['ageGroup'];
                $_SESSION["user"] = $current_user;
                $status = $row_new['status'];
                if($status=="Active"){
                Header("Location: M_Dashboard");
                }
                else{
                    echo '<script>alert("Your membership is not active")</script>'; 
                    
                }
            }

            if($row['role']=="coach"){
                $_SESSION["note"]="null";
                $current_user="coach";

                $userID=$row['userID'];
                $_SESSION["real_user_id"] = $row['userID'];
                
                $query_new="SELECT coachID FROM coachdetails WHERE userID= '$userID'";
                $result_new = $this->findAll($query_new);
                $row_new = $result_new->fetch_assoc();

                $_SESSION["user_id"] =$row_new['coachID'];
                
                
                $_SESSION["user"] = $current_user;
                Header("Location: C_Dashboard");
            }

            if($row['role']=="headcoach"){

                $current_user="coach";
                $_SESSION["note"]="headcoach";

                $userID=$row['userID'];
                $_SESSION["real_user_id"] = $row['userID'];
                
                $query_new="SELECT coachID FROM coachdetails WHERE userID= '$userID'";
                $result_new = $this->findAll($query_new);
                $row_new = $result_new->fetch_assoc();

                $_SESSION["user_id"] =$row_new['coachID'];
                
                
                $_SESSION["user"] = $current_user;
                Header("Location: C_Dashboard");

            }

            if($row['role']=="admin"){
                $_SESSION["note"]="null";
                $current_user="admin";
                $_SESSION["user"] = $current_user;

                $_SESSION["user_id"] =$row['userID'];
                
                

                Header("Location: A_MemberManage");
            }

            if($row['role']=="paymentClark"){
                $_SESSION["note"]="null";
                $current_user="paymentClark";
                $_SESSION["user"] = $current_user;

                $_SESSION["user_id"] =$row['userID'];

                Header("Location: P_MemberPayments");
            }
        }
        else
        {
            echo '<script>alert("Login not successful")</script>'; 
        }
    }

    public function findMember() {
        $query="SELECT U.*, M.* FROM users U, memberdetails M WHERE U.userID=M.userID ORDER BY M.regDate DESC";
        
        $result=$this->findAll($query);

        if ($result->num_rows > 0) {
            $a=array();
            return $result;
          } else {
            echo "0 results";
          }
    }

    public function deleteMember($userID)
    {
        $query = "DELETE FROM users WHERE userID = $userID";

        return $this->delete($query);
    }

    public function updateMember($userID, $name, $email, $nic, $contactNo, $gender, $address, $dob, $ageGroup, $school, $grade, $status, $regDate, $pName, $pRelationship, $pContactNo)
    { 

        $sql1 = "UPDATE users 
            SET name='$name', email='$email', nic='$nic', contactNo='$contactNo', 
                gender='$gender', address='$address', dob='$dob'
            WHERE userID='$userID'";

    
        $sql2 = "UPDATE memberdetails
            SET ageGroup='$ageGroup', school='$school', grade='$grade', status='$status', regDate='$regDate', 
                pName='$pName', pRelationship='$pRelationship', pContactNo='$pContactNo'
            WHERE userID='$userID'";

        $this->delete($sql1);
        $this->delete($sql2);
    }

    public function totalMembers() {
        $query="SELECT COUNT(*) as total FROM memberdetails";
        $result=$this->query($query);    

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        } else {
            return 0; 
        }
    }
    public function activeMembers() {
        $query="SELECT COUNT(*) as active FROM memberdetails WHERE status = 'active'";
        $result=$this->query($query);

        if($result) {
            $row = $result->fetch_assoc();
            return $row['active'];
        }
        else {
            return 0; 
        }
    }

    public function inactiveMembers() {
        $query="SELECT COUNT(*) as inactive FROM memberdetails WHERE status = 'inactive'";
        $result=$this->query($query);

        if($result) {
            $row = $result->fetch_assoc();
            return $row['inactive'];
        }
        else {
            return 0; 
        }
    }

    public function newMembers() {
        $currentWeekNumber = date('W');
        $currentYear = date('Y');

        $query = "SELECT COUNT(*) as new FROM memberdetails WHERE YEAR(regDate) = $currentYear AND WEEK(regDate, 1) = $currentWeekNumber";
        $result=$this->query($query);

        if($result) {
            $row = $result->fetch_assoc();
            return $row['new'];
        }
        else {
            return 0; 
        }
    }

    //COACHES
    public function findCoach() {
        $query="SELECT U.*, C.* FROM users U, coachdetails C WHERE U.userID=C.userID ORDER BY C.hireDate DESC";
        
        $result=$this->findAll($query);

        if ($result->num_rows > 0) {
            $a=array();
            return $result;
          } else {
            echo "0 results";
          }
    }


    public function addCoach($name, $email, $nic, $contactNo, $gender, $address, $dob, $yearsOfExperience, $qualifications)
    {
        $year = date("Y");
        $month = date("m");
        $date = date("d");

        $hour = date("H");
        $min = date("i");
        $seconds = date("s");

        $userID = $month+$date+$hour+$min;
       
        $role = 'coach'; 
        $salary = 20000;
        $status = 'active';
        $hireDate = date('Y-m-d H:i:s'); 
        $password = '123';

        
        
        $sql1 = "INSERT INTO users (userID, name, email, role, password, nic, contactNo, gender, address, dob) VALUES ('$userID', '$name', '$email', '$role', '$password', '$nic', '$contactNo', '$gender', '$address', '$dob')";
        $sql2 = "INSERT INTO coachdetails (userID, coachID, status, hireDate, yearsOfExperience, qualifications, salary) VALUES ('$userID', '$userID','$status', '$hireDate', '$yearsOfExperience', '$qualifications', '$salary')";
        $sql3="INSERT INTO coach (coach_id, coach_name) VALUES ($userID, '$name')";

        $this->insert($sql1);
        $this->insert($sql3);
        $this->insert($sql2);
    }

    public function deleteCoach($userID)
    {
        $query = "DELETE FROM users WHERE userID = $userID";

        return $this->delete($query);
    }

    public function updateCoach($userID, $name, $email, $nic, $contactNo, $gender, $address, $dob, $yearsOfExperience, $qualifications, $salary, $status)
    { 

        $sql1 = "UPDATE users 
            SET name='$name', email='$email', nic='$nic', contactNo='$contactNo', 
                gender='$gender', address='$address', dob='$dob'
            WHERE userID='$userID'";

    
        $sql2 = "UPDATE coachdetails
            SET yearsOfExperience='$yearsOfExperience', qualifications='$qualifications',  salary='$salary', status='$status'
            WHERE userID='$userID'";

        $this->delete($sql1);
        $this->delete($sql2);
    }

    public function totalCoaches() {
        $query="SELECT COUNT(*) as total FROM coachdetails";
        $result=$this->query($query);    

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        } else {
            return 0; 
        }
    }

    public function activeCoaches() {
        $query="SELECT COUNT(*) as active FROM coachdetails WHERE status = 'active'";
        $result=$this->query($query);

        if($result) {
            $row = $result->fetch_assoc();
            return $row['active'];
        }
        else {
            return 0; 
        }
    }

    public function inactiveCoaches() {
        $query="SELECT COUNT(*) as inactive FROM coachdetails WHERE status = 'inactive'";
        $result=$this->query($query);

        if($result) {
            $row = $result->fetch_assoc();
            return $row['inactive'];
        }
        else {
            return 0; 
        }
    }

    public function newCoaches() {
        $currentWeekNumber = date('W');
        $currentYear = date('Y');

        $query = "SELECT COUNT(*) as new FROM coachdetails WHERE YEAR(hireDate) = $currentYear AND WEEK(hireDate, 1) = $currentWeekNumber";
        $result=$this->query($query);

        if($result) {
            $row = $result->fetch_assoc();
            return $row['new'];
        }
        else {
            return 0; 
        }
    }




    
   

/*
    public function validate($data){
        $this->errors = [];

        if(empty($data['email'])){
            $this->errors['email'] = "Email is required"; 
        }
        else{
            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $this->errors['email'] = "Email is not valid"; 
            }
        }

        if(empty($data['password'])){
            $this->errors['password'] = "Password is required"; 
        }
        
        if(empty($this->errors)){
            return true;
        }
        return false;
    }

    

*/



    
}