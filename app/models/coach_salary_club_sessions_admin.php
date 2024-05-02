<?php

class Coach_salary_club_sessions_admin{
    use Model;

    public function retrive_coaches(){
        //$query1 = "SELECT * FROM coachdetails";
       
        
        $query1 = "SELECT coachdetails.coachID , users.contactNo FROM coachdetails INNER JOIN users ON coachdetails.userID = users.userID  ";
       
        $result=$this->findAll($query1);
       // echo "<script type='text/javascript'>alert('$result');</script>";


        return $result;

    }


    public function calculate_salary_sum($from,$today,$coach_id){
        
        //$from="2024-03-27";
       
        $coach_id_safe = intval($coach_id);

       // SELECT * FROM `attendance` WHERE `coach_id` = 500
       

        $query = "SELECT attendance_status FROM attendance WHERE attendance.attendance_date >= '$from' AND attendance.attendance_date <= '$today' AND attendance.coach_id={$coach_id_safe} AND attendance.attendance_status = 'Present' ;";
       
        //echo "<script type='text/javascript'>alert('$query');</script>";
        $result4 =$this->findAll($query);
        return $result4;

    }

    public function calculate($from,$today){

        //$today = date('Y-m-d');
        //$lastMonth = "2024-03-27";

        $result = $this->retrive_coaches();
       
        while($row=$result->fetch_assoc()){

            $earnings= 0;

            $sample0 = $row['coachID'];
            $tel = $row['contactNo'];

            
            $keys = array_keys($row);
        print_r($keys);

            echo "<script type='text/javascript'>alert('$sample0');</script>";
            echo "<script type='text/javascript'>alert('$tel');</script>";

            $result1=$this->calculate_salary_sum($from,$today,$row['coachID']);
            
            if($result1!=null){
            while($row_new=$result1->fetch_assoc()){

                $sample = $row_new['attendance_status'];
                $earnings = $earnings+500;
                echo "<script type='text/javascript'>alert('$sample');</script>";

            }
            $text_earnings = "Total " .$earnings;

            $this->send_sms($tel,$text_earnings);
        }
 }
    }
}