<?php
class salary_coach{
use Model;

public function income_club_session($coach_id){

    $sql = "SELECT a.occurrence_id, a.attendance_date, s.session_name, s.day, COUNT(a.user_id) AS number_of_students 
            FROM attendance a, sessions s 
            WHERE coach_id = '$coach_id' 
                AND s.session_id=a.session_id 
                AND YEAR(attendance_date) = YEAR(CURRENT_DATE()) 
                AND MONTH(attendance_date) = MONTH(CURRENT_DATE()) 
            GROUP BY occurrence_id ORDER BY attendance_date ASC;";

    $result = $this->findAll($sql);
    return $result; 
}

public function count_income_club_session($coach_id){

    $sql = "SELECT COUNT( DISTINCT occurrence_id) AS total 
    FROM attendance 
    WHERE coach_id = '$coach_id' 
        AND YEAR(attendance_date) = YEAR(CURRENT_DATE()) 
        AND MONTH(attendance_date) = MONTH(CURRENT_DATE());"; 
    
    $result = $this->query($sql);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        } else {
            return 0; 
        }   
}
















public function income_private_booking_member($coach_id){
    $sql="SELECT * 
	FROM salary_sessions s, bookings b
    WHERE s.coachID='$coach_id' AND paid=0 AND s.bookingID=b.booking_id AND b.member_ID IS NOT NULL
    AND MONTH(s.date) = MONTH(CURDATE())
    AND YEAR(s.date) = YEAR(CURDATE())
    ORDER BY s.date DESC; ";

    $data = $this->findAll($sql);
    return $data;
}

public function count_income_private_members($coach_id){
    $sql = "SELECT COUNT(s.Salary) AS count 
	        FROM salary_sessions s, bookings b
            WHERE s.coachID='$coach_id' AND paid=0 AND s.bookingID=b.booking_id AND b.member_ID IS NOT NULL
                AND MONTH(s.date) = MONTH(CURDATE())
                AND YEAR(s.date) = YEAR(CURDATE())
            ORDER BY s.date DESC;";
    
    $result = $this->findAll($sql);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['count'];
    }
    return 0; 
}
public function total_income_private_members($coach_id){
    $sql = "SELECT SUM(s.Salary) AS total 
	        FROM salary_sessions s, bookings b
            WHERE s.coachID='$coach_id' AND paid=0 AND s.bookingID=b.booking_id AND b.member_ID IS NOT NULL
                AND MONTH(s.date) = MONTH(CURDATE())
                AND YEAR(s.date) = YEAR(CURDATE())
            ORDER BY s.date DESC;";
    
    $result = $this->findAll($sql);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['total'];
    }
    return 0; 
}

public function income_private_booking_non_member($coach_id){
    $sql="SELECT * 
	FROM salary_sessions s, bookings b
    WHERE s.coachID='$coach_id' AND s.bookingID=b.booking_id AND b.member_ID IS NULL
    AND MONTH(s.date) = MONTH(CURDATE())
    AND YEAR(s.date) = YEAR(CURDATE())
    ORDER BY s.date DESC; ";

    $data = $this->findAll($sql);
    return $data;
}

public function count_income_private_non_members($coach_id){
    $sql = "SELECT COUNT(s.Salary) AS count 
	        FROM salary_sessions s, bookings b
            WHERE s.coachID='$coach_id' AND s.bookingID=b.booking_id AND b.member_ID IS NULL
                AND MONTH(s.date) = MONTH(CURDATE())
                AND YEAR(s.date) = YEAR(CURDATE())
            ORDER BY s.date DESC;";
    
    $result = $this->findAll($sql);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['count'];
    }
    return 0; 
}

public function total_income_private_non_members($coach_id){
    $sql = "SELECT SUM(s.Salary) AS total 
	        FROM salary_sessions s, bookings b
            WHERE s.coachID='$coach_id' AND s.bookingID=b.booking_id AND b.member_ID IS NULL
                AND MONTH(s.date) = MONTH(CURDATE())
                AND YEAR(s.date) = YEAR(CURDATE())
            ORDER BY s.date DESC;";
    
    $result = $this->findAll($sql);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['total'];
    }
    return 0; 
}

















}