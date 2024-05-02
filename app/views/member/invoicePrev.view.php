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
$member_id = "";
$paymentID = "";
$name = "";
$email = "";
$contactNo = "";
$nic = "";
$total_for_private_bookings="";
$total_payment = "";
$payment_id = "";
$amount = "";

if(isset($_GET['member_id'])) {
    $member_id = $_GET['member_id'];
    $payment_id = $_GET['payment_id'];
    //echo "Member ID: " . $member_id;
} else {
    echo "No member ID found in the URL.";
}

$query1 = "SELECT `memberID`, `booking_id`, `amount`
			FROM `members_duePayments_private`
			WHERE `memberID` = $member_id
			LIMIT 1;";

$result1 = $mysqli->query($query1);

if ($result1->num_rows > 0) {
    // Fetch the last row as an associative array
    $row1 = $result1->fetch_assoc();

    // Store column values in variables
    $paymentID = $row1['booking_id'];
}

$query2 = "SELECT u.`name`, u.`email`,u.`contactNo`,u.`nic`
			FROM `memberdetails` md
			JOIN `users` u ON md.`userID` = u.`userID`
			WHERE md.`memberID` = $member_id;";

$result2 = $mysqli->query($query2);

if ($result2->num_rows > 0) {
    // Fetch the last row as an associative array
    $row2 = $result2->fetch_assoc();

    // Store column values in variables
    $name = $row2['name'];
	$email = $row2['email'];
	$contactNo = $row2['contactNo'];
	$nic = $row2['nic'];
}

// SQL query to calculate sum
$query3 = "SELECT `id`, `member_id`, `amount`, `month`
            FROM `due_membership_payment`
            WHERE `member_id` = $member_id
            AND `month` = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH));";

$result3 = $mysqli->query($query3);

// Check if query executed successfully
if ($result3) {
    // Fetch result
    $row3 = $result3->fetch_assoc();
    
    // Output result
    $amount = $row3['amount'];
    $order_id = $row3['id'];
} else {
    echo "Error executing query: " . $mysqli->error;
}

// Get the timestamp for the first day of the current month
$current_month_start = strtotime('first day of this month');

// Get the timestamp for the first day of the previous month
$previous_month_start = strtotime('first day of last month', $current_month_start);

// Format the previous month as a string
$previous_month = date('F', $previous_month_start);

// Echo the previous month
$prev_month = $previous_month;

//delete from table
$query4 = "DELETE FROM `due_membership_payment` WHERE id=$payment_id";
if(!$mysqli->query($query4)){
    echo "Error executing query: " . $mysqli->error;
}

$query5 = "INSERT INTO `member_payments`(`payment_id`, `member_id`, `amount`, `item`, `note`) VALUES ($payment_id,$member_id,$amount,' ',' ')";
if(!$mysqli->query($query5)){
    echo "Error executing query: " . $mysqli->error;
}


?>

<!-- HTML code to display data in tabular format -->


<!DOCTYPE html>
<html>
<head>
	<title>Invoice for Booking</title>
	<link rel="stylesheet" type="text/css" href="<?php echo URLROOT?>/css/non-member/invoice.css">
</head>
<body>

<div class="wrapper">
	<div class="invoice_wrapper">
		<div class="header">
			<div class="logo_invoice_wrap">
				<div class="logo_sec">
					<!-- <img src="codingboss.png" alt="code logo"> -->
					<div class="title_wrap">
						<p class="title bold">Serandib Cricket Academy</p>
						<p class="sub_title">Privite Limited</p>
					</div>
				</div>
				<div class="invoice_sec">
					<p class="invoice bold">INVOICE</p>
					<p class="invoice_no">
						<span class="bold">Payment ID</span>
						<span>#<?php echo $payment_id; ?></span>
					</p>
					<p class="date">
						<span class="bold">Date</span>
						<span><?php echo $today; ?></span>
					</p>
				</div>
			</div>
			<div class="bill_total_wrap">
				<div class="bill_sec">
					<p>Bill To</p> 
	          			<p class="bold name"><?php echo $name; ?></p>
					  	<p class="name" style="font-size: 14px; color:black;"><?php echo $email; ?></p>
			        <span>
                    <?php echo $contactNo; ?>
			        </span>
				</div>

				<div class="total_wrap">
					<p>Total Payment</p>
	          		<p class="bold price">Rs.<?php echo $amount; ?>.00</p>
				</div>

			</div>
		</div>
		<div class="body">
			<div class="main_table">
				<div class="table_header">
					<div class="row">
						<div class="col col_no">NO.</div>
						<div class="col col_des">ITEM DESCRIPTION</div>
						<div class="col col_price"></div>
						<div class="col col_qty"></div>
						<div class="col col_total">TOTAL</div>
					</div>
				</div>
				<div class="table_body">

					<div class="row">
						<div class="col col_no">
							<p>01</p>
						</div>
						<div class="col col_des">
							<p class="bold">For Group Sessions Due Payment</p>
							<p>(Payment for month of -  <?php echo $prev_month ?>)</p>
						</div>
						<div class="col col_price">
							<p></p>
						</div>
						<div class="col col_qty">
							<p></p>
						</div>
						<div class="col col_total">
							<p>Rs.<?php echo $amount; ?>.00</p>
						</div>
					</div>

				</div>
			</div>
			<div class="paymethod_grandtotal_wrap">
				<div class="paymethod_sec">

				</div>
				<div class="grandtotal_sec">
			        <p class="bold">
			            <span>SUB TOTAL</span>
			            <span>Rs.<?php echo $amount; ?>.00</span>
			        </p>
			        <p>
			            <span>Tax Vat 0%</span>
			            <span>Rs.0.00</span>
			        </p>
			        <p>
			            <span>Discount 0%</span>
			            <span>Rs.0.00</span>
			        </p>
			       	<p class="bold">
			            <span>Grand Total</span>
			            <span>Rs.<?php echo $amount; ?>.00</span>
			        </p>
				</div>
			</div>
		</div>
		<div class="footer">
			<p>Thank you and Best Wishes</p>
			<div class="terms">
		        <p class="tc bold">Terms & Coditions</p>
		        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit non praesentium doloribus. Quaerat vero iure itaque odio numquam, debitis illo quasi consequuntur velit, explicabo esse nesciunt error aliquid quis eius!</p>
		    </div>
		</div>
	</div>
</div>

<script src="<?php echo URLROOT?>/js/non-member/invoice.js"></script>
</body>
</html>