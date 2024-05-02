<?php
class member_payments{
use Model;
public function find_all_members(){
    $sql="SELECT memberdetails.memberID , users.name
    FROM memberdetails
    INNER JOIN users ON memberdetails.userID = users.userID;
    ";
    $data = $this->findAll($sql);
    return $data;
}

public function load_all_payments(){
    $sql="SELECT * FROM member_payments ";
    $data = $this->findAll($sql);
    return $data;
}

public function load_all_due_payments(){
    $sql = "SELECT * FROM due_membership_payment";
    $data = $this->findAll($sql);
    return $data;

}

public function count_load_all_due_payments(){
    $sql = "SELECT COUNT(*) AS count FROM due_membership_payment";
    $result = $this->query($sql);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return 0; 
        }  
}

public function sum_load_all_due_payments(){
    $sql = "SELECT SUM(amount) AS sum FROM due_membership_payment";
    $result = $this->query($sql);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['sum'];
        } else {
            return 0; 
        }  
}






public function member_all_payments($member_id){
    $sql = "SELECT member_id, amount, 'month' as status FROM member_payments WHERE member_id = $member_id
    UNION ALL
    SELECT member_id, amount, 'month' as date, 'unpaid' as status FROM due_membership_payment WHERE member_id = $member_id";
    $data = $this->findAll($sql);
    return $data;
}

public function member_paid_payments($member_id){
    $sql="SELECT * FROM member_payments WHERE member_id = $member_id";
    $data = $this->findAll($sql);
    return $data;
}

public function member_unpaid_payments($member_id){
    $sql="SELECT 
    dmp.member_id, 
    dmp.amount,
    dmp.month, 
    COUNT(atd.attendance_id) AS sessions_attended
FROM 
    due_membership_payment dmp
JOIN 
    attendance atd 
ON 
    dmp.member_id = atd.user_id
WHERE 
    dmp.member_id = $member_id 
    AND MONTH(atd.attendance_date) = dmp.month
    
GROUP BY 
    dmp.member_id, dmp.month;
";
    $data = $this->findAll($sql);
    return $data;
}








}