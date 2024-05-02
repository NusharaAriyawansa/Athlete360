<?php
class MemberSessionViewModel{
    use model;
    
    public function load_sessions(){
        $member_id=$_SESSION["user_id"];;
        

        $sql = "SELECT * FROM sessions JOIN sessionmembers ON sessions.session_id = sessionmembers.session_id JOIN memberdetails ON sessionmembers.member_id = memberdetails.memberID where sessionmembers.member_id='$member_id'";
        return $this->findAll($sql);

    }

    public function load_Allsessions(){
        $member_id=1;
        $ageGrp = $_SESSION["Age_Grp"];

        $sql = "SELECT * FROM sessions where session_name='$ageGrp'";
        return $this->findAll($sql);

    }

public function updateSelection($session_id){
        $member_id=$_SESSION["user_id"];
        $ageGrp = $_SESSION["Age_Grp"];

        $sql = "INSERT INTO sessionmembers (session_id, member_id) VALUES ('$session_id', '$member_id')";
        return $this->delete($sql);

}

public function deleteSelections(){
    
    $id=$_SESSION["user_id"];
    $sql = "DELETE FROM sessionmembers WHERE member_id = '$id' ";
    return $this->delete($sql);


}

Public function view_private_booking($memberid){
    $today = date("Y-m-d");
    //$sql = "SELECT * FROM bookings WHERE date >= '$today' AND member_ID = $memberid";
    $sql="SELECT b.*, GROUP_CONCAT(u.name SEPARATOR',') AS coach_names
    FROM bookings b
    INNER JOIN booked_coaches bc ON b.booking_id = bc.bookingId
    INNER JOIN coachdetails cd ON bc.booked_coach_id = cd.coachID
    INNER JOIN users u ON cd.userID = u.userID
    WHERE b.date >= '$today' AND b.member_ID = $memberid
    GROUP BY b.booking_id";


    echo "<script>console.log('$sql')</script>";



    return $this->findAll($sql);
}

}