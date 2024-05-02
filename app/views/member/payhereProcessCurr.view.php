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
$order_id = "";

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
$query2 = "SELECT `id`, `member_id`, `amount`, `month` 
            FROM `due_membership_payment` 
            WHERE member_id=$member_id
            AND month = MONTH(CURRENT_DATE());";

$result2 = $mysqli->query($query2);

// Check if query executed successfully
if ($result2) {
    // Fetch result
    $row2 = $result2->fetch_assoc();
    
    // Output result
    $amount = $row2['amount'];
    $order_id = $row2['id'];
} else {
    echo "Error executing query: " . $mysqli->error;
}

//$amount = $total_for_private_bookings*9/10;
$merchant_id = "1226531";
//$order_id = 111;
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