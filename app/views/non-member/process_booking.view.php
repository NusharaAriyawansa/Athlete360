<?php
    require_once('Sample.php');
    echo "hiii";
    $conn = new mysqli("localhost", "root", "", "athlete360");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $date = $_POST['datea'];
        $namea = $_POST['namea'];
        $contact_number = $_POST['contactNumber'];
        $selected_nets = $_POST['selected_nets'];
        $selected_coaches = $_POST['selected_coaches'];
        $idNumber = $_POST['idNumber'];
        $time_slot = $_POST['time_1'];

        //echo $time_slot;
    
        // // Insert booking information
        $sql_booking = "INSERT INTO bookings (date, name, id_number, contact_number, slot_id, net_id, coach_id, member_ID) VALUES ('$date', '$namea', $idNumber, $contact_number, $time_slot,1,1,1)";
        $sql_booked_nets = "INSERT INTO booked_nets (bookingId, booked_net_id) VALUES ('$bookingId', '$net_id')";
        $sql_booked_coaches = "INSERT INTO booked_coaches (bookingId, booked_coach_id) VALUES ('$bookingId', '$coach_id')";
        //$conn->query($sql_booking);
        //$this -> lakruwan_insert($sql_booking);
        //$bookingId = $conn->insert_id;  // Get the ID of the last inserted booking
        $obj = new Sample();
        $obj -> lakruwan_insert($sql_booking, $sql_booked_nets, $sql_booked_coaches, $selected_nets, $selected_coaches);
        
        // // Insert booked nets information
        /*foreach ($selected_nets as $net_id) {
            //echo $net_id;
            $sql_booked_nets = "INSERT INTO booked_nets (bookingId, booked_net_id) VALUES ('$bookingId', '$net_id')";
            $conn->query($sql_booked_nets);
        }

        // // Insert booked coaches information
        foreach ($selected_coaches as $coach_id) {
            //echo $coach_id;
            $sql_booked_coaches = "INSERT INTO booked_coaches (bookingId, booked_coach_id) VALUES ('$bookingId', '$coach_id')";
            $conn->query($sql_booked_coaches);
        }

        $conn->close();*/
        
        // Redirect to a confirmation page or any other page as needed
         header("Location:http://localhost/athlete360/public/N_BeforePayment");
        // exit();

    }
?>

