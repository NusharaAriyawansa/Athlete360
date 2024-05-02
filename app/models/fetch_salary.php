<?php
class fetch_salary{
    use Model;
public function findAllRecords($coachID)
{
    //$time = strtotime('17/04/2024');
   

    $query = "SELECT * FROM salary_sessions WHERE coachID = $coachID";
    $result=$this->findAll($query);

    $response = '';
    if ($result->num_rows > 0) {

      while ($row = $result->fetch_assoc()) {
        $response .= "Name: " . $row['bookingID'] . "<br>";
        $response .= "Description: " . $row['Salary'] . "<br>";
        $response .= "Description: " . $row['date'] . "<br>";
        
    }
      } else {
        echo "0 results";
      }
       
    
}







}
$dataFetcher = new fetch_salary();

if (isset($_GET['id'])) {
  $coachId = intval($_GET['id']);
  echo $dataFetcher->findAllRecords($coachId);
}