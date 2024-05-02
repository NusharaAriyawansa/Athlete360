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
	$slot_id = $row['slot_id'];

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
    //to get nets list
    // Retrieve the last booking ID from the "bookings" table
    $query3 = "SELECT booking_id FROM bookings ORDER BY booking_id DESC LIMIT 1";
    $result3 = $mysqli->query($query3);

    if (!$result3) {
        die("Error retrieving booking ID: " . $mysqli->error);
    }

    $row = $result3->fetch_assoc();
    $lastBookingId = $row['booking_id'];

    // Retrieve comma-separated nets list for the last booking
    $query4 = "SELECT GROUP_CONCAT(nets.net_name SEPARATOR ', ') AS net_list
            FROM booked_nets
            INNER JOIN nets ON booked_nets.booked_net_id = nets.net_id
            WHERE booked_nets.bookingId = $lastBookingId";
    $result4 = $mysqli->query($query4);

    if (!$result4) {
        die("Error retrieving nets list: " . $mysqli->error);
    }

    $row = $result4->fetch_assoc();
    $netsList = $row['net_list'];

    //to get coach list

    // Retrieve comma-separated nets list for the last booking
    $query5 = "SELECT GROUP_CONCAT(coach.coach_name SEPARATOR ', ') AS coach_list
                FROM booked_coaches
                INNER JOIN coach ON booked_coaches.booked_coach_id = coach.coach_id
                WHERE booked_coaches.bookingId = $lastBookingId";
    $result5 = $mysqli->query($query5);

    if (!$result5) {
        die("Error retrieving nets list: " . $mysqli->error);
    }

    $row = $result5->fetch_assoc();
    $coachList = $row['coach_list'];

    //echo "Nets List for Last Booking: " . $netsList;

    $netPrice = 500;
    $coachPrice = 1000;
    $amount = $netPrice*$numOfNets + $coachPrice*$numOfCoaches;

	$query6 = "INSERT INTO `payments`(`booking_id`, `amount`) VALUES ('$booking_id','$amount')";
	$mysqli->query($query6);

	// Your SQL query
	$query7 = "SELECT coach.coach_id AS coach_list
				FROM booked_coaches
				INNER JOIN coach ON booked_coaches.booked_coach_id = coach.coach_id
				WHERE booked_coaches.bookingId = $lastBookingId";

	// Execute the query
	$result7 = $mysqli->query($query7);

	// Check if the query was successful
	if ($result7) {
		// Loop through the results
		while ($row7 = $result7->fetch_assoc()) {
		// Insert each coach_id into the salary_sessions table
		$coachID7 = $row7['coach_list'];
		$insertQuery7 = "INSERT INTO salary_sessions (coachID,`bookingID`,`date`) VALUES ('$coachID7','$booking_id', '$date')";

		// Execute the insert query
			if (!$mysqli->query($insertQuery7)) {
				echo "Error inserting coachID: " . $mysqli->error;
			}
		}
	} else {
		// Query was not successful
		echo "Error executing query: " . $mysqli->error;
	}

	$user = "94776218353";
	$password = "9278";
	$text = urlencode("Serandib Cricket Academy. Your Booking Confirmed on $date at $time_slot_name. Your booking Id= $booking_id Your nic number= $id_number");
	$to = "94" . $contact_number;

	$baseurl ="http://www.textit.biz/sendmsg";
	$url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
	$ret = file($url);

	$res= explode(":",$ret[0]);

	if (trim($res[0])=="OK")
	{
	echo "<script>alert(Message Sent - ID : ".$res[1].")</script>";
	}
	else
	{
	echo "<script>alert(Sent Failed - Error : ".$res[1].")</script>";
	}
// Print the current date
//echo "Today is: $today";
		// $date = $_REQUEST['date'];
		// $time_slot = $_REQUEST['time_slot'];
        // $time_slot = $_POST['time_1'];

// start - find and insert not booked nets
// $queries = [
//     "TRUNCATE TABLE book_net;",
//     "TRUNCATE TABLE book_net_inverse;",

// "    INSERT INTO book_net (net_id, net_name)
//     SELECT n.net_id, n.net_name
//     FROM nets n
//     LEFT JOIN booked_nets bn ON n.net_id = bn.booked_net_id
//     LEFT JOIN bookings b ON bn.bookingId = b.booking_id
//     WHERE b.date = '$date' AND b.slot_id = $time_slot;",

// "    INSERT INTO book_net_inverse (net_id, net_name)
//     SELECT n.net_id, n.net_name
//     FROM nets n
//     LEFT JOIN book_net nb ON n.net_id = nb.net_id
//     WHERE nb.net_id IS NULL;"
// ];

// Execute queries one by one
// foreach ($queries as $query) {
//     if ($mysqli->query($query) === TRUE) {
//         // Query executed successfully
//     } else {
//         // Query execution failed
//         echo "Error: " . $query . "<br>" . $mysqli->error;
//         // You may choose to exit or handle the error in another way
//     }
// }
//start - 26

// $queries1 = [
//   "TRUNCATE TABLE book_coach;",
//   "TRUNCATE TABLE book_coach_inverse;",
  
//   "INSERT INTO book_coach (coach_id, coach_name)
//     SELECT n.coach_id, n.coach_name
//     FROM coach n
//     LEFT JOIN booked_coaches bn ON n.coach_id = bn.booked_coach_id
//     LEFT JOIN bookings b ON bn.bookingId = b.booking_id
//     WHERE b.date = '$date' AND b.slot_id = $time_slot;",
  
//   "INSERT INTO book_coach_inverse (coach_id, coach_name)
//     SELECT n.coach_id, n.coach_name
//     FROM coach n
//     LEFT JOIN book_coach nb ON n.coach_id = nb.coach_id
//     WHERE nb.coach_id IS NULL;"
// ];

// Execute queries one by one
// foreach ($queries1 as $query) {
//   if ($mysqli->query($query) === TRUE) {
//       // Query executed successfully
//   } else {
//       // Query execution failed
//       echo "Error: " . $query . "<br>" . $mysqli->error;
//       // You may choose to exit or handle the error in another way
//   }
// }

// end - find and insert not booked coaches

// Fetch and display data
// $result = $mysqli->query("SELECT * FROM book_net_inverse;");
// $result1 = $mysqli->query("SELECT * FROM book_coach_inverse;");

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
						<span class="bold">Invoice</span>
						<span>#<?php echo $booking_id; ?></span>
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
			        <span>
                    <?php echo $contact_number; ?>
			        </span>
				</div>
				<div class="invoice_sec">
					<p class="invoice bold" style="font-size: 16px; text-align: center;">BOOKED</p>
					<p class="invoice_no">
						<span class="bold">Date:</span>
						<span><?php echo $date; ?></span>
					</p>
					<p class="date">
						<span class="bold">Time Slot:</span>
						<span><?php 
                    switch ($slot_id) {
                      case 1:
                        echo "9-10 AM";
                        break;
                        case 2:
                          echo "10-11 AM";
                          break;
                          case 3:
                            echo "11-12 AM";
                            break;
                            case 4:
                              echo "12-1 PM";
                              break;
                              case 5:
                                echo "1-2 PM";
                                break;
                                case 6:
                                  echo "2-3 PM";
                                  break;
                                  case 7:
                                    echo "3-4 PM";
                                    break;
                                    case 8:
                                      echo "4-5 PM";
                                      break;
                                      case 9:
                                        echo "5-6 PM";
                                        break;
                                        case 10:
                                          echo "6-7 PM";
                                          break;
                                          case 11:
                                            echo "7-8 PM";
                                            break;
                                            case 12:
                                              echo "8-9AM";
                                              break;
                        
                      default:
                      echo "wrong time slot";
                    }
                                    ?></span>
					</p>
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
						<div class="col col_price">PRICE</div>
						<div class="col col_qty">QTY</div>
						<div class="col col_total">TOTAL</div>
					</div>
				</div>
				<div class="table_body">
					<!-- <div class="row">
						<div class="col col_no">
							<p>01</p>
						</div>
						<div class="col col_des">
							<p class="bold">Web Design</p>
							<p>Lorem ipsum dolor sit.</p>
						</div>
						<div class="col col_price">
							<p>$350</p>
						</div>
						<div class="col col_qty">
							<p>2</p>
						</div>
						<div class="col col_total">
							<p>$700.00</p>
						</div>
					</div>
					<div class="row">
						<div class="col col_no">
							<p>02</p>
						</div>
						<div class="col col_des">
							<p class="bold">Web Development</p>
							<p>Lorem ipsum dolor sit.</p>
						</div>
						<div class="col col_price">
							<p>$350</p>
						</div>
						<div class="col col_qty">
							<p>2</p>
						</div>
						<div class="col col_total">
							<p>$700.00</p>
						</div>
					</div>
					<div class="row">
						<div class="col col_no">
							<p>03</p>
						</div>
						<div class="col col_des">
							<p class="bold">GitHub</p>
							<p>Lorem ipsum dolor sit.</p>
						</div>
						<div class="col col_price">
							<p>$120</p>
						</div>
						<div class="col col_qty">
							<p>1</p>
						</div>
						<div class="col col_total">
							<p>$700.00</p>
						</div>
					</div> -->
					<div class="row">
						<div class="col col_no">
							<p>01</p>
						</div>
						<div class="col col_des">
							<p class="bold">Nets</p>
							<p><?php echo $netsList; ?></p>
						</div>
						<div class="col col_price">
							<p>Rs.500.00</p>
						</div>
						<div class="col col_qty">
							<p><?php echo $numOfNets; ?></p>
						</div>
						<div class="col col_total">
							<p>Rs.<?php echo $numOfNets*500; ?>.00</p>
						</div>
					</div>
					<div class="row">
						<div class="col col_no">
							<p>02</p>
						</div>
						<div class="col col_des">
							<p class="bold">Coaches</p>
							<p><?php echo $coachList; ?></p>
						</div>
						<div class="col col_price">
							<p>Rs.1000.00</p>
						</div>
						<div class="col col_qty">
							<p><?php echo $numOfCoaches; ?></p>
						</div>
						<div class="col col_total">
							<p>Rs.<?php echo $numOfCoaches*1000; ?>.00</p>
						</div>
					</div>
				</div>
			</div>
			<div class="paymethod_grandtotal_wrap">
				<div class="paymethod_sec">
					<p><i>To Cancel the Booking</i></p>
					<p><b>Booking Id:</b> <?php echo $booking_id; ?></p>
					<p><b>NIC Number:</b> <?php echo $id_number; ?></p>
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
			            <span>-Rs.0.00</span>
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