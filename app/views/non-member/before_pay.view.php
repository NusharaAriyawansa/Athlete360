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

    // echo $jsonObj;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered member ID and email
    $memberID = $_POST['memberID'];
    $email = $_POST['email'];
    
    // Query to get userID from memberdetails table based on memberID
    $sql = "SELECT userID FROM memberdetails WHERE memberId = '$memberID'";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
        // Fetch userID
        $row = $result->fetch_assoc();
        $userID = $row['userID'];
        
        // Query to get email from users table based on userID
        $sql = "SELECT email FROM users WHERE userID = '$userID'";
        $result = $mysqli->query($sql);
        
        if ($result->num_rows > 0) {
            // Fetch email
            $row = $result->fetch_assoc();
            $storedEmail = $row['email'];
            
            // Check if entered email matches the stored email
            if ($email === $storedEmail) {
                // Update the bookings table
                $sql = "UPDATE bookings SET member_id = '$memberID' WHERE booking_id = $booking_id";
                if ($mysqli->query($sql) === TRUE) {
                    $sql1 = "INSERT INTO `members_duePayments_private`(`memberID`, `booking_id`, `amount`) VALUES ($memberID,$booking_id,$amount)";
                    $mysqli->query($sql1);
                    echo "<script>alert('Booking added to your dashboard!');</script>";
                    echo "<script>window.location.href = 'N_Calendar';</script>";
                } else {
                    echo "Error updating booking: " . $mysqli->error;
                }
            } else {
                echo "<script>alert('Entered email does not match the email associated with this member ID. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('No email found for this user!');</script>";
        }
    } else {
        echo "<script>alert('No user found for this member ID.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- <link rel="stylesheet" href="<?php echo URLROOT?>/css/headCoach/teams.css"> -->
        <link rel="stylesheet" href="<?php echo URLROOT?>/css/non-member/before_pay.css">
</head>
<body>
    <!-- <h1>Order Id</h1> -->
    <!-- <p>Order Id -> <?php echo $booking_id; ?></p>
    <p>Name -><?php echo $name; ?></p>
    <p>Id number -><?php echo $id_number; ?></p>
    <p>Contact Number -><?php echo $contact_number; ?></p>
    <p>Date of booking -> <?php echo $today; ?></p>
    <p>Number of nets -> <?php echo $numOfNets; ?></p>
    <p>Number of Coaches -> <?php echo $numOfCoaches; ?></p>
    <p>Full amount to pay(net per hr=500.. coach per hr=1000..) -> <?php echo $amount; ?></p>

    <button onclick="paymentGateway();">Proceed to Pay</button> -->

    <!-- body -->
    <div class = "invoice-wrapper" id = "print-area">
            <div class = "invoice">
                <div class = "invoice-container">
                    <div class = "invoice-head">
                        <div class = "invoice-head-top">
                            <!-- <div class = "invoice-head-top-left text-start">
                                <img src = "images/logo.png">
                            </div> -->
                            <div class = "invoice-head-top-right text-end">
                                <h3>Make a Payment</h3>
                            </div>
                        </div>
                        <div class = "hr"></div>
                        <div class = "invoice-head-middle">
                            <div class = "invoice-head-middle-left text-start">
                                <p><span class = "text-bold">Date</span>: <?php echo date("Y-m-d"); ?></p>
                            </div>
                            <div class = "invoice-head-middle-right text-end">
                                <p><spanf class = "text-bold">Booking Id:</span><?php echo $booking_id; ?></p>
                            </div>
                        </div>
                        <div class = "hr"></div>
                        <div class = "invoice-head-bottom">
                            <div class = "invoice-head-bottom-left">
                                <ul>
                                    <li><b>Name:</b> <?php echo $name; ?></li>
                                </ul>
                                <br>
                            </div>

                            
                            <div class = "invoice-head-bottom-right">
                                <ul class = "text-end">
                                    <li><b>NIC Number: </b> <?php echo $id_number; ?></li>
                                </ul>
                                <br>
                            </div>

                            <div class = "invoice-head-bottom-left">
                                <ul>
                                    <li><b>Contact number: </b><?php echo $contact_number; ?></li>
                                </ul>
                                <br>
                            </div>

                            
                            <div class = "invoice-head-bottom-right">
                                <ul class = "text-end">
                                    <li><b>Booking Date: </b><?php echo $date; ?></li>
                                </ul>
                                <br>
                            </div>

                        </div>
                    </div>
                    <div class = "overflow-view">
                        <div class = "invoice-body">
                            <table>
                                <thead>
                                    <tr>
                                        <td class = "text-bold">Service</td>
                                        <td class = "text-bold">Description</td>
                                        <td class = "text-bold">Rate(Per Hour)</td>
                                        <td class = "text-bold">QTY</td>
                                        <td class = "text-bold">Amount</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nets</td>
                                        <td><?php echo $netsList; ?></td>
                                        <td>Rs.500.00</td>
                                        <td><?php echo $numOfNets; ?></td>
                                        <td class = "text-end">Rs.<?php echo $numOfNets*500; ?>.00</td>
                                    </tr>
                                    <tr>
                                        <td>Coaches</td>
                                        <td><?php echo $coachList; ?></td>
                                        <td>Rs.1000.00</td>
                                        <td><?php echo $numOfCoaches; ?></td>
                                        <td class = "text-end">Rs.<?php echo $numOfCoaches*1000; ?>.00</td>
                                    </tr>
                                    <!-- <tr>
                                        <td>Machine nets</td>
                                        <td>Machine Net1</td>
                                        <td>Rs.1000.00</td>
                                        <td>1</td>
                                        <td class = "text-end">Rs.1000.00</td>
                                    </tr> -->
                                    <!-- <tr>
                                        <td colspan="4">10</td>
                                        <td>$500.00</td>
                                    </tr> -->
                                </tbody>
                            </table>
                            <div class = "invoice-body-bottom">
                                <div class = "invoice-body-info-item border-bottom">
                                    <div class = "info-item-td text-end text-bold">Sub Total:</div>
                                    <div class = "info-item-td text-end">Rs.<?php echo $amount; ?>.00</div>
                                </div>
                                <div class = "invoice-body-info-item border-bottom">
                                    <div class = "info-item-td text-end text-bold">Tax:</div>
                                    <div class = "info-item-td text-end">Rs.0.00</div>
                                </div>
                                <div class = "invoice-body-info-item">
                                    <div class = "info-item-td text-end text-bold">Total:</div>
                                    <div class = "info-item-td text-end">Rs.<?php echo $amount; ?>.00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "invoice-foot text-center">
                        

                        <div class = "invoice-btns">
                            <!-- <button type = "button" class = "invoice-btn" onclick="printInvoice()">
                                <span>
                                    <i class="fa-solid fa-print"></i>
                                </span>
                                <span>Print</span>
                            </button> -->

                            <button onclick="openPopup1()" type = "button" class = "invoice-btn mem">
                                <p>(For Members)</p>
                                <span>
                                    <i class="fa-solid fa-pay"></i>
                                </span>
                                <span>Add payment to Dashboard</span>
                            </button>
                            
                            <button onclick="paymentGateway();" type = "button" class = "invoice-btn non">
                                <p>(For Non Members)</p>
                                <span>
                                    <i class="fa-solid fa-pay"></i>
                                </span>
                                <span>Proceed to Pay</span>
                            </button>
                        </div>
                        <br><br>
                        <p><span class = "text-bold text-center">NOTE:&nbsp;</span>This is computer generated receipt and does not require physical signature.</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal" id="update-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close" onclick="closePopup1()">&times;</span>
                    <h3 class="i3-name">Confirm Your Membership</h3>
                </div>

                <br>

              <div class="modal-body">
                  <form method="post" action="">
                  
                  <div class="update-form1">
                      <div class="update-form2">
                      <label for="memberID">Member ID:</label>  
                      <input type="text" id="memberID" name="memberID" class="input1" placeholder="Your Member ID" required>
                      </div>
                  </div>

            
                  <div class="update-form1">
                      <div class="update-form2">
                      <label for="email">Email:</label>  
                      <input type="email" id="email" name="email" class="input1" placeholder="Your Email" required> 
                      </div>  
                  </div>

              </div>
            
              <div class="update-form5">
                <button type="submit" class="btn btn-update">Add payment to my dashboard</button>
              </div>

            </div>
        </div>


    <!-- body -->

    <script src="<?php echo URLROOT?>/js/non-member/before_pay.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    <script>
            // Function to open the popup
            function openPopup() {
                document.getElementById("popup").style.display = "block";
            }
            function openPopup1() {
                document.getElementsByClassName("modal")[0].style.display = "block";
            }
            function openPopup2() {
                document.getElementsByClassName("modal")[1].style.display = "block";
            }
            // Function to close the popup
            function closePopup() {
                document.getElementById("popup").style.display = "none";
            }

            function closePopup1() {
                document.getElementsByClassName("modal")[0].style.display = "none";
            }
            function closePopup2() {
                document.getElementsByClassName("modal")[1].style.display = "none";
            }
            
            function confirmDelete() {
                // Display a confirmation dialog
                if (confirm("Are you sure you want to delete this team?")) {
                    return true; // Proceed with form submission
                } else {
                    return false; // Cancel form submission
                }
            }

        </script>
</body>
</html>