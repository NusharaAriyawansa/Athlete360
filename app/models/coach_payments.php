<?php

class coach_payments{
use Model;

public function findAllCoaches()
{
    $date1 = strtotime('2024-04-17');
    $from = date('Y-m-d H:i:s', $date1);

    $date2 = strtotime('2024-04-18');
    $to = date('Y-m-d H:i:s', $date2);

    $query = "SELECT * FROM  coach ";
    $result=$this->findAll($query);
    if ($result->num_rows > 0) {
        $a=array();
    
       
        return $result;
      } else {
        echo "0 results";
      }
}

public function findAllRecords($coachID)
{
    $query = "SELECT * FROM salary_sessions WHERE coachID = $coachID";
    $result=$this->findAll($query);

    return $result;
}

public function findAllPaidRecords($coachID)
{
    $query = "SELECT * FROM salary_sessions WHERE coachID = $coachID AND paid = 1";
    $result=$this->findAll($query);

    return $result;
}

public function findAllNotPaidRecords($coachID) 
{
  $query = "SELECT * FROM salary_sessions WHERE coachID = $coachID AND paid = 0";
  $result = $this->findAll($query);
  return $result;
}

public function findAllDueCoaches() 
{
  $query = "SELECT * FROM salary_sessions WHERE paid = 0";
  $result = $this->findAll($query);
  return $result;
}

public function findAllSalaries() 
{
  $query = "SELECT * FROM salary_sessions";
  $result = $this->findAll($query);
  return $result;
}
public function countDueCoaches() {
  $query = "SELECT COUNT(DISTINCT subquery.coachID) AS unique_coach_count
    FROM (
        SELECT c.coachID
        FROM coachdetails c
        JOIN users u ON c.userID = u.userID
        LEFT JOIN coach_payments_attendance p ON c.coachID = p.coach_id
        GROUP BY c.coachID, u.name, u.email
    ) AS subquery;";
  $result = $this->findAll($query);
  if ($row = mysqli_fetch_assoc($result)) {
      return $row['unique_coach_count'];
  }
  return 0;  
}

public function totalDuePayments() {
  $query = "SELECT SUM(amount) as total FROM coach_totsl";
  $result = $this->findAll($query);
  if ($row = mysqli_fetch_assoc($result)) {
      return $row['total'];
  }
  return 0;  
}

public function perCoachTotal($coachID) {
  $query = "SELECT SUM(Salary) as total FROM salary_sessions WHERE coachID = $coachID";
  $result = $this->findAll($query);
  if ($row = mysqli_fetch_assoc($result)) {
      return $row['total'];
  }
  return 0;  
}

public function perCoachPaid($coachID) {
  $query = "SELECT SUM(Salary) as paid FROM salary_sessions WHERE coachID = $coachID AND paid = 1";
  $result = $this->findAll($query);
  if ($row = mysqli_fetch_assoc($result)) {
      return $row['paid'];
  }
  return 0;  
}

public function perCoachUnpaid($coachID) {
  $query = "SELECT SUM(Salary) as unpaid FROM salary_sessions WHERE coachID = $coachID AND paid = 0";
  $result = $this->findAll($query);
  if ($row = mysqli_fetch_assoc($result)) {
      return $row['unpaid'];
  }
  return 0;  
}


public function retrive_coaches_unpaid_club_session_sum(){

  $sql="SELECT * FROM coach_totsl";
  $result_coaches_unpaid_club_session_sum = $this->findAll($sql);
  return $result_coaches_unpaid_club_session_sum;

}





}