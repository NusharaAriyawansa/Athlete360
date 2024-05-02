<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "athlete360");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


            // SQL query to fetch data
            $sql = "SELECT 
            p.payment_id AS 'PAYMENT ID', 
            cb.booking_id AS 'BOOKING ID', 
            p.amount AS 'AMOUNT', 
            b.name AS 'NAME', 
            b.contact_number AS 'CONTACT NUMBER'
            FROM 
            cancelled_bookings cb
            JOIN 
            payments p ON cb.booking_id = p.booking_id
            JOIN 
            bookings b ON cb.booking_id = b.booking_id
            WHERE 
            cb.refund_done = 0;";
        
            $result = $conn->query($sql);
            $numofRowRes = $result->num_rows;

            $sql3 = "SELECT 
                        SUM(p.amount) AS 'TOTAL AMOUNT'
                    FROM 
                        cancelled_bookings cb
                    JOIN 
                        payments p ON cb.booking_id = p.booking_id
                    JOIN 
                        bookings b ON cb.booking_id = b.booking_id
                    WHERE 
                        cb.refund_done = 0;
                    ";
            $result3 = $conn->query($sql3);
            $row3 = $result3->fetch_assoc();
            $totalDue = $row3["TOTAL AMOUNT"];



                        // SQL query to fetch data
                        $sql2 = "SELECT 
                        p.payment_id AS 'PAYMENT ID', 
                        cb.booking_id AS 'BOOKING ID', 
                        p.amount AS 'AMOUNT', 
                        b.name AS 'NAME', 
                        b.contact_number AS 'CONTACT NUMBER'
                        FROM 
                        cancelled_bookings cb
                        JOIN 
                        payments p ON cb.booking_id = p.booking_id
                        JOIN 
                        bookings b ON cb.booking_id = b.booking_id
                        WHERE 
                        cb.refund_done = 1;";   
                        $result2 = $conn->query($sql2);


                       $sql4 =  "SELECT 
                                    SUM(p.amount) AS 'TOTAL AMOUNT'
                                FROM 
                                    cancelled_bookings cb
                                JOIN 
                                    payments p ON cb.booking_id = p.booking_id
                                JOIN 
                                    bookings b ON cb.booking_id = b.booking_id
                                WHERE 
                                    cb.refund_done = 1
                                    AND MONTH(p.payment_timestamp) = MONTH(CURRENT_DATE())
                                    AND YEAR(p.payment_timestamp) = YEAR(CURRENT_DATE());";
                        $result4 = $conn->query($sql4);
                        $row4 = $result4->fetch_assoc();
                        $refundThisMon = $row4["TOTAL AMOUNT"];

                        $sql5 =  "SELECT 
                                    SUM(p.amount) AS 'TOTAL AMOUNT'
                                FROM 
                                    cancelled_bookings cb
                                JOIN 
                                    payments p ON cb.booking_id = p.booking_id
                                JOIN 
                                    bookings b ON cb.booking_id = b.booking_id
                                WHERE 
                                    cb.refund_done = 1
                                    AND MONTH(p.payment_timestamp) = MONTH(CURRENT_DATE()) -1
                                    AND YEAR(p.payment_timestamp) = YEAR(CURRENT_DATE());";
                        $result5 = $conn->query($sql5);
                        $row5 = $result5->fetch_assoc();
                        $refundPrevMon = $row5["TOTAL AMOUNT"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if bookingId is provided
    if (isset($_POST['bookingId'])) {
        // Get the bookingId from the POST request
        $bookingId = $_POST['bookingId'];

        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "athlete360");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement to update the refund status
        $sql1 = "UPDATE cancelled_bookings SET refund_done = 1 WHERE booking_id = ?";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql1);
        $stmt->bind_param("i", $bookingId);

        // Execute the update statement
        if ($stmt->execute()) {
            echo "Refund status updated successfully";
                        // Reload the page to reflect the changes
                        header("Refresh:0");
                        exit();
        } else {
            echo "Error updating refund status: " . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
        //$conn->close();
    } else {
        echo "Booking ID not provided";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/payment-clark/refundForBookings.css">

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

        <h2 class="i-name">
            Due Refunds - For cancelled private bookings
        </h2>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3>Rs.<?php echo $totalDue; ?>.00</h3>
                    <span>Total Due Refunds</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3><?php echo $numofRowRes; ?> Payments</h3>
                    <span>No. of Due Refunds</span>
                </div>
            </div>
        </div>

        <div class="people">
                <table width="100%">
            <thead>
                <tr>
                    <th>Payment Id</th>
                    <th>Booking Id</th>
                    <th>Amount</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Refund Done?</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td> <h5>" . $row["PAYMENT ID"] . "</h5></td>";
                        echo "<td> <p>" . $row["BOOKING ID"] . "</p></td>";
                        echo "<td> <p> Rs." . $row["AMOUNT"] . ".00</p> </td>";
                        echo "<td><p>" . $row["NAME"] . "</p></td>";
                        echo "<td><p>" . $row["CONTACT NUMBER"] . "</p></td>";
                        echo "<td>";
                        echo "<form action='' method='post' onsubmit='return confirm(\"Are you sure you want to proceed?\");'>";
                       // echo "<form action='' method='post'>";
                        echo "<input type='hidden' name='bookingId' value='" . $row["BOOKING ID"] . "'>";
                        echo "<button type='submit' class='table_but'>&#x2713</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No payments found</td></tr>";
                }
            ?>
            </tbody>
        </table>

        </div>

        <h2 class="i2-name">
            Done Refunds - For cancelled private bookings
        </h2>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3>Rs.<?php echo $refundThisMon; ?>.00</h3>
                    <span>Total Refunds in this month</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3>Rs.<?php echo $refundPrevMon; ?>.00</h3>
                    <span>Total Refunds in previous month</span>
                </div>
            </div>
            
        </div>
        <div class="people">
            <table width="100%">
                <thead>
                    <tr>
                        <th>Payment Id</th>
                        <th>Booking Id</th>
                        <th>Amount</th>
                        <th>Name</th>
                        <th>Contact Number</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($result2->num_rows > 0) {
                        while($row = $result2->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["PAYMENT ID"] . "</td>";
                            echo "<td>" . $row["BOOKING ID"] . "</td>";
                            echo "<td> Rs." . $row["AMOUNT"] . ".00 </td>";
                            echo "<td>" . $row["NAME"] . "</td>";
                            echo "<td>" . $row["CONTACT NUMBER"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No payments found</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>


    
    </section>
    
</body>
</html>