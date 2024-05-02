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

$member_id="";
$total_for_private_bookings="";

if(isset($_GET['memberID'])) {
    // Retrieve the member_id value
    $member_id = $_GET['memberID'];
    
    // Now you can use $member_id in your PHP script
    //echo "Member ID: " . $member_id;
} else {
    // If member_id parameter is not set in the URL
    //echo "Member ID is not set";
}


// SQL query to calculate sum
$query1 = "SELECT SUM(amount) as total_amount FROM members_duePayments_private WHERE memberID = $member_id";

// Execute query
$result1 = $mysqli->query($query1);

// Check if query executed successfully
if ($result1) {
    // Fetch result
    $row1 = $result1->fetch_assoc();
    
    // Output result
    $total_for_private_bookings = $row1['total_amount'];
} else {
    echo "Error executing query: " . $mysqli->error;
}

$amount = $total_for_private_bookings*9/10;
$merchant_id = "1226531";
$order_id = 111;
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