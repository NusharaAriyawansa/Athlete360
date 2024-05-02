<?php

class session_coach{
    use model;

    public function upcoming_member_sessions($coachID){
        
        $sql = "SELECT so.occurrence_id, so.session_id, so.session_date, s.session_name, s.start_time, s.end_time 
                FROM sessionoccurrences so 
                JOIN sessions s ON so.session_id = s.session_id 
                JOIN sessioncoaches sc ON s.session_id = sc.session_id 
                WHERE sc.coach_id = '$coachID'     
                    AND (
                    (so.session_date > CURDATE() AND MONTH(so.session_date) = MONTH(CURDATE()) AND YEAR(so.session_date) = YEAR(CURDATE()))
                    OR
                    (MONTH(so.session_date) = MONTH(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(so.session_date) = YEAR(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)))
                    )
                ORDER BY so.session_date ASC;";
        
        $result = $this->findAll($sql);
        return $result;
    }

    public function upcoming_member_private_sessions($coachID){

        $sql = "SELECT * FROM bookings b, booked_coaches bc 
                WHERE b.booking_id = bc.bookingId 
                    AND bc.booked_coach_id = '$coachID' 
                    AND b.member_ID != 1
                    AND b.id_number != 1
                    AND (
                    (b.date > CURDATE() AND MONTH(b.date) = MONTH(CURDATE()) AND YEAR(b.date) = YEAR(CURDATE()))
                    OR
                    (MONTH(b.date) = MONTH(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(b.date) = YEAR(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)))
                    )
                ORDER BY b.date ASC;";
        
        $result = $this->findAll($sql);
        return $result;

    }

    public function upcoming_non_member_private_sessions($coachID){

        $sql = "SELECT * FROM bookings b, booked_coaches bc 
                WHERE b.booking_id = bc.bookingId 
                    AND bc.booked_coach_id = '$coachID' 
                    AND b.member_ID = 1
                    AND b.id_number != 1
                    AND (
                    (b.date > CURDATE() AND MONTH(b.date) = MONTH(CURDATE()) AND YEAR(b.date) = YEAR(CURDATE()))
                    OR
                    (MONTH(b.date) = MONTH(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(b.date) = YEAR(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)))
                    )
                ORDER BY b.date ASC;";
        
        $result = $this->findAll($sql);
        return $result;

    }

    //counts for each age group - club sessions
    public function count_upcoming_u13_sessions($coachID){
        $sql = "SELECT COUNT(*) AS session_count
        FROM sessionoccurrences so 
        JOIN sessions s ON so.session_id = s.session_id 
        JOIN sessioncoaches sc ON s.session_id = sc.session_id 
        WHERE sc.coach_id = '$coachID'
            AND s.session_name = 'under 13'    
            AND (
                (so.session_date > CURDATE() AND MONTH(so.session_date) = MONTH(CURDATE()) AND YEAR(so.session_date) = YEAR(CURDATE()))
                OR
                (MONTH(so.session_date) = MONTH(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(so.session_date) = YEAR(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)))
            );";
        
        $result = $this->query($sql);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['session_count'];
        } else {
            return 0; 
        }        
    }

    public function count_upcoming_u15_sessions($coachID){
        $sql = "SELECT COUNT(*) AS session_count
        FROM sessionoccurrences so 
        JOIN sessions s ON so.session_id = s.session_id 
        JOIN sessioncoaches sc ON s.session_id = sc.session_id 
        WHERE sc.coach_id = '$coachID'
            AND s.session_name = 'under 15'    
            AND (
                (so.session_date > CURDATE() AND MONTH(so.session_date) = MONTH(CURDATE()) AND YEAR(so.session_date) = YEAR(CURDATE()))
                OR
                (MONTH(so.session_date) = MONTH(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(so.session_date) = YEAR(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)))
            );";
        
        $result = $this->query($sql);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['session_count'];
        } else {
            return 0; 
        }        
    }

    public function count_upcoming_u17_sessions($coachID){
        $sql = "SELECT COUNT(*) AS session_count
        FROM sessionoccurrences so 
        JOIN sessions s ON so.session_id = s.session_id 
        JOIN sessioncoaches sc ON s.session_id = sc.session_id 
        WHERE sc.coach_id = '$coachID'
            AND s.session_name = 'under 17'    
            AND (
                (so.session_date > CURDATE() AND MONTH(so.session_date) = MONTH(CURDATE()) AND YEAR(so.session_date) = YEAR(CURDATE()))
                OR
                (MONTH(so.session_date) = MONTH(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(so.session_date) = YEAR(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)))
            );";
        
        $result = $this->query($sql);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['session_count'];
        } else {
            return 0; 
        }        
    }

    public function count_upcoming_u19_sessions($coachID){
        $sql = "SELECT COUNT(*) AS session_count
        FROM sessionoccurrences so 
        JOIN sessions s ON so.session_id = s.session_id 
        JOIN sessioncoaches sc ON s.session_id = sc.session_id 
        WHERE sc.coach_id = '$coachID'
            AND s.session_name = 'under 19'    
            AND (
                (so.session_date > CURDATE() AND MONTH(so.session_date) = MONTH(CURDATE()) AND YEAR(so.session_date) = YEAR(CURDATE()))
                OR
                (MONTH(so.session_date) = MONTH(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(so.session_date) = YEAR(DATE_ADD(CURDATE(), INTERVAL 1 MONTH)))
            );";
        
        $result = $this->query($sql);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['session_count'];
        } else {
            return 0; 
        }        
    }





    

}