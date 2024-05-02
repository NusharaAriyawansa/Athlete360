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

// Member ID
$member_id =  $_SESSION["user_id"];
$sessions_joined = "";
$session_price=2000;
$private_sessions_joined = "";
$total_for_private_bookings = "";
$amount_for_prev_month = "";
$paymentID="";

// SQL query
$query = "SELECT COUNT(*) as count FROM sessionmembers WHERE member_id = $member_id";

// Execute query
$result = $mysqli->query($query);

// Check if query executed successfully
if ($result) {
    // Fetch result
    $row = $result->fetch_assoc();
    
    // Output result
    $sessions_joined = $row['count'];
} else {
    echo "Error executing query: " . $mysqli->error;
}


// SQL query to count rows
$query = "SELECT COUNT(*) as count FROM members_duePayments_private WHERE memberID = $member_id";

// Execute query
$result = $mysqli->query($query);

// Check if query executed successfully
if ($result) {
    // Fetch result
    $row = $result->fetch_assoc();
    
    // Output result
    $private_sessions_joined = $row['count'];
} else {
    echo "Error executing query: " . $mysqli->error;
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

$current_month = date("F");

// Get the timestamp for the first day of the current month
$current_month_start = strtotime(date("Y-m-01"));

// Get the timestamp for the last day of the previous month
$previous_month_end = strtotime("-1 day", $current_month_start);

// Get the previous month
$previous_month = date("F", $previous_month_end);

// Close connection
//$mysqli->close();

// $query2 = "SELECT `id`, `member_id`, `amount`, `month`
//             FROM `due_membership_payment`
//             WHERE `member_id` = $member_id
//             AND `month` = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH));";

// $result2 = $mysqli->query($query2);

// // Check if query executed successfully
// if ($result2) {
//     // Fetch result
//     $row2 = $result2->fetch_assoc();
    
//     // Output result
//     $amount_for_prev_month = $row2['amount'];    
//     $paymentID = $row2['id'];


// } else {
//     echo "Error executing query: " . $mysqli->error;
// }

$query2 = "SELECT `id`, `member_id`, `amount`, `month`
            FROM `due_membership_payment`
            WHERE `member_id` = $member_id
            AND `month` = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH));";

$result2 = $mysqli->query($query2);

// Check if query executed successfully
if ($result2) {
    // Fetch result
    $row2 = $result2->fetch_assoc();

    // Check if row2 is not null
    if ($row2 !== null) {
        // Output result
        $amount_for_prev_month = $row2['amount'];
        $paymentID = $row2['id'];
    } else {
        // Handle the case where no results are returned
        $amount_for_prev_month = 0; // Or any default value you consider appropriate
        $paymentID = 0;
        //echo "No payment found for the previous month.";
    }
} else {
    echo "Error executing query: " . $mysqli->error;
}


// $curr_mon_amount="";
// // SQL query to calculate sum
// $query3 = "SELECT `id`, `member_id`, `amount`, `month` 
//             FROM `due_membership_payment` 
//             WHERE member_id=$member_id
//             AND month = MONTH(CURRENT_DATE());";

// $result3 = $mysqli->query($query3);

// // Check if query executed successfully
// if ($result3) {
//     // Fetch result
//     $row3 = $result3->fetch_assoc();
    
//     // Output result
//     $curr_mon_amount = $row3['amount'];
//     $order_id = $row3['id'];
// } else {
//     echo "Error executing query: " . $mysqli->error;
// }

$curr_mon_amount = 0; // Initialize to 0 assuming it's a numeric value
$order_id = null; // Initialize to null or appropriate default

// SQL query to calculate sum
$query3 = "SELECT `id`, `member_id`, `amount`, `month` 
            FROM `due_membership_payment` 
            WHERE member_id = $member_id
            AND month = MONTH(CURRENT_DATE());";

$result3 = $mysqli->query($query3);

// Check if query executed successfully
if ($result3) {
    // Fetch result
    $row3 = $result3->fetch_assoc();
    
    // Check if the query returned a result
    if ($row3) {
        // Output result
        $curr_mon_amount = $row3['amount'];
        $order_id = $row3['id'];
    } else {
        //echo "No dues found for this month.";
    }
} else {
    //echo "Error executing query: " . $mysqli->error;
}


// if ($amount_for_prev_month == 0) {
//     $disable_button = 'disabled'; // If $amount_for_prev_month is null, set the disabled attribute
// } else {
//     $disable_button = ''; // If $amount_for_prev_month is not null, do not disable the button
// }

// if ($curr_mon_amount == 0) {
//     $disable_button1 = 'disabled'; // If $amount_for_prev_month is null, set the disabled attribute
// } else {
//     $disable_button1 = ''; // If $amount_for_prev_month is not null, do not disable the button
// }

// if($amount_for_prev_month >0){
//     $disable_button1 =  'disabled'; 
// }else{
//     $disable_button1 = '';
// }

$amount_for_prev_month = isset($row2['amount']) ? $row2['amount'] : 0;
$paymentID = isset($row2['id']) ? $row2['id'] : 0;


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/member/payments.css">
    <style>
        h1 {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            font-size: 15px;
            color: #fff;
            background-color: #563EC4;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #573ec4db;
        }

        .pay_details{
            margin-left: 30px;
            margin-top: 30px;
        }

        .values1{
            margin-top: -30px;
        }

        .prev_month {
        border: 2px solid red;
        padding-bottom: 30px ;
        margin-left: 30px;
        margin-right: 30px;
        padding: 30px;
        margin-top: 1450px;
        /* padding-top: 1450px; */
        }

        .i-name{
            color: #6a0602;
        }

        #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
        }

        #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        #customers tr:nth-child(odd){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
        }

        /* Style the tab */
        .tab {
        position: fixed;
        margin-top: 75px;
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #dfdfdf;
        width:100%;
        margin-bottom: 130px;
        color: #666666;
        }

        /* Style the buttons inside the tab */
        .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
        border-radius: 0px;
        width: 380px ;
        color: #666666;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
        background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
        background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
        margin-top: 120px;
        }

        .tab-title{
            margin-top: 0px;
        }

        button[disabled] {
        opacity: 0.5; /* Reduced opacity to visually indicate it's disabled */
        cursor: not-allowed; /* Change cursor to not-allowed */
    }
    </style>
</head>


<body>
    <section id="menu"> 
        <div class="logo">
            <img src="<?php echo URLROOT?>/images/logo.png" alt="">
            <!-- <h2>ATHLETE' 360</h2> -->
        </div>

        <div class="items">
            <li><i class="fa fa-user"></i></i><a href="<?php echo URLROOT?>/M_Dashboard">Dashboard</a></li>
            <li><i class="fa fa-th-large"></i><a href="<?php echo URLROOT?>/M_Sessions">Session Management</a></li>
            <li><i class="fa fa-money"></i><a href="<?php echo URLROOT?>/M_Payments">Payments</a></li>
            <li><i class="fa fa-file"></i><a href="<?php echo URLROOT?>/M_Performance">Performance Evaluation</a></li>
            <li><i class="fa fa-thumbs-up"></i><a href="<?php echo URLROOT?>/M_Attendance">Attendance Evaluation</a></li>
            <li><i class="fa fa-check-circle"></i><a href="<?php echo URLROOT?>/M_Profile">My Profile</a></li>
        </div>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class="logout">
                <a href="<?php echo URLROOT; ?>/logout.php" class="logout-icon">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
            <div class="profile">
                <img src="<?php echo URLROOT?>/images/person.png" alt="">
            </div>
        </div>

        <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'London')">Due Payments (in Previous Month)</button>
            <button class="tablinks" onclick="openCity(event, 'Paris')">Payments for this month</button>
            <button class="tablinks" onclick="openCity(event, 'Tokyo')">Payments for Private bookings</button>
        </div>
        
        <div id="London" class="tabcontent">
            <h3 class="i-name tab-title">
                <u>Payment for Group Sessions</u>
            </h3>
            <div style="margin-top: 30px;" class="prev_month">

            
                <div class="pay_details">
                        <h1 style="color: red;">Due Payment for Previous month - <?php echo $previous_month;?></h1>
                </div>

                <div class="values">
                    <div class="val-box">
                        <i class="fa fa-users"></i>
                        <div>
                            <h3><?php echo $amount_for_prev_month/$session_price;?> Sessions</h3>
                            <span>Number of Group sessions</span>
                        </div>
                    </div>
                    <div class="val-box">
                        <i class="fa fa-user-plus"></i>
                        <div>
                            <h3 style="color: red;">Rs.<?php echo $amount_for_prev_month;?>.00</h3>
                            <span>Total amout to pay <br> (For Private Sessions) </span>
                        </div>
                    </div>            
                </div>

                    <div class="pay_details">
                    
                    <table id="customers">
                        <tr>
                            <td><p><b>Number of sessions attended</b></p></td>
                            <td><p><?php echo $amount_for_prev_month/$session_price;?> Sessions</p></td>
                        </tr>
                        <tr>
                            <td><p><b>Amount Per session</b></p></td>
                            <td><p>Rs.2000.00</p></td>
                        </tr>
                        <tr>
                            <td><p><b>Total Amount to pay:</b></p></td>
                            <td><p>Rs.<?php echo $amount_for_prev_month;?>.00</p></td>
                        </tr>

                    </table>
                    

                    <button onclick="paymentGatewayPrev(<?php echo $member_id; ?>);">Make this Payment</button>
                    </div>

                    <p style="margin-top: 10px; margin-left:30px; font-size: 12px; color:red;">
                        **If you will not make this payment <u>before end of <?php echo $current_month;?> month</u> your membership will be canceled <br>
                        **If you haven't due payments(Total Amount to pay = Rs.0.00) here ignore above note
                    </p>
            </div>
        </div>



        <div id="Paris" class="tabcontent">

                <h3 class="i-name tab-title">
                    <u>Payment for Group Sessions</u>
                </h3>

                <div class="pay_details">
                    <h1>Make a Payment for this month - <?php echo $current_month;?></h1>
                </div>

                

            <div class="values values1">
                <div class="val-box">
                    <i class="fa fa-users"></i>
                    <div>
                        <h3><?php echo $sessions_joined;?> Sessions</h3>
                        <span>Number of Sessions per week <br> (In current month)</span>
                    </div>
                </div>
                <div class="val-box">
                    <i class="fa fa-user-plus"></i>
                    <div>
                        <h3>Rs.<?php echo $curr_mon_amount;?>.00</h3>
                        <span>Total amout to pay <br> (For Group Practice Sessions) </span>
                    </div>
                </div>            
            </div>

            <div class="pay_details">


                    <table id="customers">
                        <tr>
                            <td><p><b>Number of sessions attended</b></p></td>
                            <td><p><?php echo $sessions_joined;?> Sessions</p></td>
                        </tr>
                        <tr>
                            <td><p><b>Amount Per session</b></p></td>
                            <td><p>Rs.2000.00</p></td>
                        </tr>
                        <tr>
                            <td><p><b>Total Amount to pay:</b></p></td>
                            <td><p>Rs.<?php echo $curr_mon_amount;?>.00</p></td>
                        </tr>

                    </table>

                <button onclick="paymentGatewayCurr(<?php echo $member_id; ?>);" >Make this Payment</button>
            </div>
        </div>

    <div id="Tokyo" class="tabcontent">
        <div class="i-name tab-title" style="font-size: 1.2em;">
            <h3><u>Payments for Private bookings</u></h3>
        </div>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $private_sessions_joined;?> Sessions</h3>
                    <span>Number of Private sessions (Not paid)</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-user-plus"></i>
                <div>
                    <h3>Rs.<?php echo $total_for_private_bookings*9/10;?>.00</h3>
                    <span>Total amout to pay <br> (For Private Sessions) </span>
                </div>
            </div>            
        </div>

        <div class="pay_details">
            <h1>Make a Payment for all private bookings</h1>

                <table id="customers">
                    <tr>
                        <td><p><b>Number of sessions attended</b></p></td>
                        <td><p><?php echo $private_sessions_joined;?> Sessions</p></td>
                    </tr>
                    <tr>
                        <td><p><b>Discount Added to members</b></p></td>
                        <td><p>10%</p></td>
                    </tr>
                    <tr>
                        <td><p><b>Total Amount to pay:</b></p></td>
                        <td><p>Rs.<?php echo $total_for_private_bookings*9/10;?>.00</p></td>
                    </tr>

                </table>
<!-- 
            <p><b>Number of sessions attended:</b> <?php echo $private_sessions_joined;?> Sessions</p>
            <p><b>Discount Added to members:</b> 10%</p>
            <p><b>Total Amount to pay:</b> Rs.<?php echo $total_for_private_bookings*9/10;?>.00</p> -->
            

            <button onclick="paymentGateway(<?php echo $member_id; ?>);">Make this Payment</button>

            <div class="i-name" style="font-size: 1.2em;">
                <h3>Not paid Private bookings</h3>
            </div>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                    <tr>
                        <td>Booking ID</td>
                        <td>Amount</td>
                        <td>Booking Date</td>
                        <td>Number of Nets</td>
                        <td>Number of Nets</td>
                        <!-- <td>Booking Maked date</td> -->
                    </tr>
                </thead>
                <?php
                    // Retrieve data from the database
                    $member_ID = $member_id;

                    // Select booking_id from bookings table where member_ID is 203
                    $sql = "SELECT booking_id, date FROM bookings WHERE member_ID = $member_ID";
                    $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {
                        // echo "<table>
                        //         <thead>
                        //             <tr>
                        //                 <td>Booking ID</td>
                        //                 <td>Amount</td>
                        //                 <td>Booking Date</td>
                        //                 <td>Number of Nets</td>
                        //                 <td>Number of Coaches</td>
                        //             </tr>
                        //         </thead>
                        //         <tbody>";

                        while($row = $result->fetch_assoc()) {
                            $booking_id = $row['booking_id'];

                            // Check if there is an entry in members_duePayments_private for this booking_id
                            $check_payment_sql = "SELECT * FROM members_duePayments_private WHERE booking_id = $booking_id";
                            $check_payment_result = $mysqli->query($check_payment_sql);

                            if ($check_payment_result->num_rows > 0) {
                                // Get amount from members_duePayments_private table
                                $amount_sql = "SELECT amount FROM members_duePayments_private WHERE booking_id = $booking_id";
                                $amount_result = $mysqli->query($amount_sql);
                                $amount_row = $amount_result->fetch_assoc();
                                $amount = isset($amount_row['amount']) ? $amount_row['amount'] : 0;

                                // Count number of nets
                                $nets_sql = "SELECT COUNT(*) AS num_nets FROM booked_nets WHERE bookingId = $booking_id";
                                $nets_result = $mysqli->query($nets_sql);
                                $nets_row = $nets_result->fetch_assoc();
                                $num_nets = isset($nets_row['num_nets']) ? $nets_row['num_nets'] : 0;

                                // Count number of coaches
                                $coaches_sql = "SELECT COUNT(*) AS num_coaches FROM booked_coaches WHERE bookingId = $booking_id";
                                $coaches_result = $mysqli->query($coaches_sql);
                                $coaches_row = $coaches_result->fetch_assoc();
                                $num_coaches = isset($coaches_row['num_coaches']) ? $coaches_row['num_coaches'] : 0;

                                // Display the data in table rows
                                echo "<tr>
                                        <td><h5>$booking_id</h5></td>
                                        <td><p>$amount</p></td>
                                        <td><p>{$row['date']}</p></td>
                                        <td><p>$num_nets</p></td>
                                        <td><p>$num_coaches</p></td>
                                    </tr>";
                            }
                        }

                        echo "</tbody></table>";
                    } else {
                        echo "No bookings found for member with ID $member_ID";
                    }

                    // Close the connection
                    $mysqli->close();
                    ?>

                <!-- <tbody>
                    <tr>
                        <td><h5>2023080102</h5></td>
                        <td><p>Rs.7000/=</p></td>
                        <td><p>One to One</p></td>
                        <td><p>Augest</p></td>
                        <td class="active"><p>Payment Confirmed</p></td>
                        <td><p>2023/07/30</p></td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td><h5>2023080101</h5></td>
                        <td><p>Rs.5000/=</p></td>
                        <td><p>Group Session</p></td>
                        <td><p>Augest</p></td>
                        <td class="active"><p>Payment Confirmed</p></td>
                        <td><p>2023/07/30</p></td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td><h5>2023070101</h5></td>
                        <td><p>Rs.2000/=</p></td>
                        <td><p>Private Booking</p></td>
                        <td><p>July</p></td>
                        <td class="active"><p>Payment Confirmed</p></td>
                        <td><p>2023/06/15</p></td>
                    </tr>
                </tbody>
            </table> -->
        </div>


        </div>



 



    
    
    </section>

    <script src="<?php echo URLROOT?>/js/member/payhere.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    <script>

        window.onload = function() {
        document.querySelector('.tablinks:nth-child(1)').click();
        }

        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
    
</body>
</html>