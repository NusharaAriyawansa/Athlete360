<?php
class payment_notification{
    use Model;
    public function sent_notification(){
        $currentYear = date("Y");
        $currentMonth = date("m");

        $sql="SELECT * FROM payment_notification WHERE Month = '$currentMonth' AND Year = '$currentYear' AND Sent = 1";
        $result = $this->findAll($sql);
       // $alertMessage = "This is an alert message from PHP!";

       
        if($result->num_rows == 0){
            
            $s="INSERT INTO payment_notification (ID, Month, Year, Sent, Des) VALUES (NULL, $currentMonth, $currentYear, 1, des)";
            $this->insert($s);

            $sql_tel = "SELECT pContactNo,memberID FROM memberdetails ";
            $result_tel = $this->findAll($sql_tel);

            if ($result_tel->num_rows > 0) {
                while($row = $result_tel->fetch_assoc()) {

                    $user = "94776218353";
                    $password = "9278";
                    $to = $row['pContactNo'];
                    $member_id = $row['memberID'];

                    $sql_session_count ="SELECT member_id, COUNT(*) AS session_count
                    FROM sessionmembers
                    WHERE member_id = $member_id 
                    GROUP BY member_id;";

                    $result_session_count = $this->findAll($sql_session_count);
                    $row_temp = $result_session_count->fetch_assoc();

                    $session_fee = 2000;
                    $amount = $row_temp['session_count']*$session_fee;

                    
                    

                    $sql = "INSERT INTO due_membership_payment (member_id, amount, month) VALUES ($member_id, $amount, $currentMonth);";
                    $this->insert($sql);

                  //  echo "<script type='text/javascript'>alert('$member_id');</script>";

                    $text = "Please pay your monthly membership fee";
                    $text = urlencode($text);

                    $sql = "SELECT COUNT(*) FROM due_membership_payment WHERE member_id = $member_id ; ";
                    $r=$this->findAll($sql);
                    
                    $r=$r->fetch_assoc();
                    $r = $r['COUNT(*)'];
                    $r=(int)$r;
                    
                    if($r>=2){
                        $sql="UPDATE memberdetails SET status = 'Inactive' WHERE memberdetails.memberID = $member_id;";
                       // echo "<script type='text/javascript'>alert('$r]');</script>";
                        $this->insert($sql);

                    }

                    $baseurl = "http://www.textit.biz/sendmsg";
                    $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";

                    $ret = @file($url);

                    if ($ret === false) {
                        echo "Failed to read from the file or URL.";

                        $alertMessage = "This is an alert message from PHP!";
                        echo "<script type='text/javascript'>alert('$url');</script>";

                    } else {
                        $res = explode(":", $ret[0]);
                        // Process $res as needed
                    }
                    //$ret = file($url);
                    //$res = explode(":", $ret[0]);

                }

            


            

        }

      
       


    }

    

}
public function insert_dues($member_id,$currentMonth){
    

}

}