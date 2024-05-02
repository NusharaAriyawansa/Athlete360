<?php
$user = 'root';
$password = '';
$database = 'athlete360';
$servername='localhost';
$mysqli = new mysqli($servername, $user, $password, $database);
 
// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}

// Set the time zone to UTC+5:30
date_default_timezone_set('Asia/Kolkata');

// Get the current date and time
$today = date('Y-m-d');

// Query to get the last row from the bookings table
$query = "SELECT * FROM bookings ORDER BY booking_id DESC LIMIT 1";
$result = $mysqli->query($query);

$query1 = "SELECT b.booking_id, COUNT(bn.bookingId) AS num_rows
			FROM bookings b
			LEFT JOIN booked_nets bn ON b.booking_id = bn.bookingId
			WHERE b.booking_id = (SELECT MAX(booking_id) FROM bookings)
			GROUP BY b.booking_id;";
$result1 = $mysqli->query($query1);

$query2 = "SELECT b.booking_id, COUNT(bc.bookingId) AS num_rows 
            FROM bookings b 
            LEFT JOIN booked_coaches bc ON b.booking_id = bc.bookingId 
            WHERE b.booking_id = (SELECT MAX(booking_id) FROM bookings) 
            GROUP BY b.booking_id;";
$result2 = $mysqli->query($query2);


// Check if there is a row
if ($result->num_rows > 0) {
    // Fetch the last row as an associative array
    $row = $result->fetch_assoc();

    // Store column values in variables
    $booking_id = $row['booking_id'];
    $name = $row['name'];
    $id_number = $row['id_number'];
    $contact_number = $row['contact_number'];
    $date = $row['date'];

}

if ($result1->num_rows > 0) {
    // Fetch the last row as an associative array
    $row1 = $result1->fetch_assoc();

    // Store column values in variables
    $numOfNets = $row1['num_rows'];
}

if ($result2->num_rows > 0) {
    // Fetch the last row as an associative array
    $row2 = $result2->fetch_assoc();

    // Store column values in variables
    $numOfCoaches = $row2['num_rows'];
}

$netPrice = 500;
$coachPrice = 1000;
$amount = $netPrice*$numOfNets + $coachPrice*$numOfCoaches;


//$amount = 3000;
$merchant_id = "1226531";
$order_id = $booking_id;
$merchant_secret = "MzUzNTc1ODUwODI5NTUzNzA3OTcxOTQ4OTU2MTUxMjkwNTIzNjY4Mg==";
$currency = "LKR";

$hash = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        number_format($amount, 2, '.', '') . 
        $currency .  
        strtoupper(md5($merchant_secret)) 
    ) 
);

$array = [];

$array["amount"] = $amount;
$array["merchant_id"] = $merchant_id;
$array["order_id"] = $order_id;
$array["amount"] = $amount;
$array["currency"] = $currency;
$array["hash"] = $hash;

$jsonObj = json_encode($array);

echo $jsonObj;


?>