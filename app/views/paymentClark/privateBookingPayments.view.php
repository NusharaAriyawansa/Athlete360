<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "athlete360");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Non-members
$sql = "SELECT 
            p.payment_id AS payment_id,
            p.booking_id AS booking_id,
            p.amount AS amount,
            b.name AS name,
            b.contact_number AS contact_number,
            b.date AS booking_date,
            b.id_number AS nic_number,
            p.payment_timestamp AS paid_date
        FROM payments p
        JOIN bookings b ON p.booking_id = b.booking_id
        WHERE b.name != 'coach' 
            AND b.member_ID = 1
            AND MONTH(b.date) = MONTH(CURRENT_DATE())  
            AND YEAR(b.date) = YEAR(CURRENT_DATE());";

$result = $conn->query($sql);

$numRows = $result->num_rows;


$currentMonth = date('m');
$currentYear = date('Y');

$sql1 = "SELECT SUM(p.amount) AS total_amount
        FROM payments p
        JOIN bookings b ON p.booking_id = b.booking_id
        WHERE b.name != 'coach' 
            AND b.member_ID = 1
            AND MONTH(b.date) = MONTH(CURRENT_DATE())  
            AND YEAR(b.date) = YEAR(CURRENT_DATE());";

$result1 = $conn->query($sql1);



// Members - paid 
$sql_non = "SELECT 
            p.payment_id AS payment_id,
            p.booking_id AS booking_id,
            p.amount AS amount,
            b.name AS name,
            b.contact_number AS contact_number,
            b.date AS booking_date,
            b.id_number AS nic_number,
            p.payment_timestamp AS paid_date
        FROM payments p
        JOIN bookings b ON p.booking_id = b.booking_id
        WHERE b.name != 'coach' 
            AND b.member_ID != 1
            AND MONTH(b.date) = MONTH(CURRENT_DATE())  
            AND YEAR(b.date) = YEAR(CURRENT_DATE());";

$result_non = $conn->query($sql_non);

$numRows_non = $result_non->num_rows;





// Members - due 
$sql_due = "SELECT 
                SUM(mdp.amount) AS total,
                mdp.memberID as memberID,
                u.name AS name,
                COUNT(DISTINCT mdp.booking_id) AS booking_count
            FROM users u
            JOIN memberdetails m ON u.userID = m.userID
            JOIN members_duepayments_private mdp ON m.memberID = mdp.memberID
            GROUP BY mdp.memberID, u.name;";

$result_due = $conn->query($sql_due);

$numRows_due = $result_due->num_rows;

$sql_due1 = "SELECT SUM(amount) AS total_amount  FROM members_duepayments_private;";

$result_due1 = $conn->query($sql_due1);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private Booking Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/payment-clark/privateBooking.css">

    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>  <!-- jQuery ready function -->
</head>


<body>
    <section id="menu"> 
        <div class="logo">
            <img src="<?php echo URLROOT?>/images/logo.png" alt="">
        </div>

        <div class="items">
        <li><i class="fa fa-user"></i><a href="<?php echo URLROOT?>/P_MemberPayments">Member Payments</a></li>
            <li><i class="fa fa-user-circle-o"></i><a href="<?php echo URLROOT?>/P_CoachPayments">Coach Salaries</a></li>
            <li><i class="fa-solid fa-clock"></i><a href="<?php echo URLROOT?>/P_PrivateBookingPayments">Private Booking Payments</a></li>
            <li><i class="fa-solid fa-money-bill-transfer"></i><a href="<?php echo URLROOT?>/P_RefundForBookings">Refunding Payments</a></li>
            <li><i class="fa fa-money"></i><a href="<?php echo URLROOT?>/P_PettyCashPayments">Petty Cash Payments</a></li>
            <li><i class="fa fa-check-circle"></i><a href="<?php echo URLROOT?>/P_Profile">My Profile</a></li>
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

        <h3 class="i-name">
            Due Payments - Members 
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $numRows_due?> Private Bookings</h3>
                    <span>No. of private bookings</span>
                </div>
            </div>
            
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3>Rs.<?php
                    if ($result_due1->num_rows > 0) {
                        $row = $result_due1->fetch_assoc();
                        $totalAmount = $row["total_amount"];
                        echo $totalAmount;
                    } else {
                        echo "No payments found for current month";
                    }
                    ?>.00</h3>
                    <span>Total Amount to be Received</span>
                </div>
            </div>            
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>Member Name</th>
                        <th>No. of private bookings</th>
                        <th>Total Amount</th>
                       
                       
                    </tr>
                </thead>
                <tbody>

                    <?php if ($result_due->num_rows > 0) : ?>
                        <?php while($row = $result_due->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo $row['memberID']; ?></td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["booking_count"]; ?></td>
                                    <td>Rs. <?php echo $row["total"]; ?>.00</td>  
                                          
                                </tr>
                        <?php endwhile;?>
                    <?php endif;?>  

                </tbody>
            </table>
        </div>



                    <?php if ($result_non->num_rows > 0) : ?>
                        <?php while($row = $result_non->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo $row['payment_id']; ?></td>
                                    <td><?php echo $row["booking_id"]; ?></td>
                                    <td>Rs. <?php echo $row["amount"]; ?>.00</td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["contact_number"]; ?></td>
                                    <td><?php echo $row["booking_date"]; ?></td>
                                    <td><?php echo $row["nic_number"]; ?></td>
                                    <td><?php echo $row["paid_date"]; ?></td>          
                                </tr>
                        <?php endwhile;?>
                    <?php endif;?>  

                </tbody>
            </table>
        </div>






        <h3 class="i2-name">
            Paid Payments - Non-Members
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $numRows?> Private Bookings</h3>
                    <span>No. of private bookings</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3>Rs.<?php
                    if ($result1->num_rows > 0) {
                        $row = $result1->fetch_assoc();
                        $totalAmount = $row["total_amount"];
                        echo $totalAmount;
                    } else {
                        echo "No payments found for current month";
                    }
                    ?>.00</h3>
                    <span>Total earnings</span>
                </div>
            </div>            
        </div>


        <div class="people">
            <table width="100%">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Booking ID</th>
                        <th>Amount</th>
                        <th>Name</th>
                        <th>Contact No.</th>
                        <th>Booking Date</th>
                        <th>NIC Number</th>
                        <th>Paid Date/ Time</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if ($result->num_rows > 0) : ?>
                        <?php while($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo $row['payment_id']; ?></td>
                                    <td><?php echo $row["booking_id"]; ?></td>
                                    <td>Rs. <?php echo $row["amount"]; ?>.00</td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["contact_number"]; ?></td>
                                    <td><?php echo $row["booking_date"]; ?></td>
                                    <td><?php echo $row["nic_number"]; ?></td>
                                    <td><?php echo $row["paid_date"]; ?></td>          
                                </tr>
                        <?php endwhile;?>
                    <?php endif;?>  

                </tbody>
            </table>
        </div>

    </section>
    
</body>

<style>

</style>
</html>