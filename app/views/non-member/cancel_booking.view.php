<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <link rel="stylesheet" href="<?php echo URLROOT?>/css/non-member/cancel_booking.css" /> -->
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/headCoach/teams.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
    <style>
        .modal{
            display: block;
        }
        .modal-content{
            height: 580px;
        }
        .but-container{
            text-align: center;
        }
        .back{
            position: fixed;
            margin-right: 10px;
            margin-left: -110px;
        }
    </style>
    <script>
        function confirmAction() {
            return confirm("Are you sure you want to perform this action?");
        }
    </script>
</head>
<body>

<?php
$user = 'root';
$password = '';
$database = 'athlete360';
$servername = 'localhost';
$mysqli = new mysqli($servername, $user, $password, $database);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$order_id="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form1_submit'])){
        $booking_id = $_POST['booking_id'];
        $nic_number = $_POST['nic_number'];
    
        // $sql = "SELECT b.booking_id, b.name, b.contact_number, b.date, b.slot_id, GROUP_CONCAT(DISTINCT bc.booked_coach_id) AS coaches, GROUP_CONCAT(DISTINCT bn.booked_net_id) AS nets
        //         FROM bookings b
        //         INNER JOIN booked_coaches bc ON b.booking_id = bc.bookingId
        //         INNER JOIN booked_nets bn ON b.booking_id = bn.bookingId
        //         WHERE b.booking_id = $booking_id AND b.id_number = $nic_number
        //         GROUP BY b.booking_id";

        $sql2 = "SELECT 
                    b.booking_id, 
                    b.name, 
                    b.contact_number, 
                    b.date, 
                    b.slot_id, 
                    COUNT(DISTINCT bc.booked_coach_id) AS coaches, 
                    COUNT(DISTINCT bn.booked_net_id) AS nets
                FROM 
                    bookings b
                INNER JOIN 
                    booked_coaches bc ON b.booking_id = bc.bookingId
                INNER JOIN 
                    booked_nets bn ON b.booking_id = bn.bookingId
                WHERE 
                    b.booking_id = $booking_id 
                    AND b.id_number = $nic_number
                    AND NOT EXISTS (
                        SELECT 1
                        FROM cancelled_bookings cb
                        WHERE cb.booking_id = b.booking_id
                    )
                GROUP BY 
                    b.booking_id;
                ";
    
        $result = $mysqli->query($sql2);
        
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $order_id = $row['booking_id'];
            $name1 = $row['name'];
            $contact_number = $row['contact_number'];
            $date = $row['date'];
            $coaches = $row['coaches'];
            $nets = $row['nets'];
            $time_slot = $row['slot_id']; // Format the time as desired
    
            // Now you can use these variables in your HTML code
            echo "<script>document.getElementById('right').style.display = 'block';</script>";
        } else {
            echo "<script>alert('Booking ID or NIC Number is incorrect');</script>";
        }
    }else if(isset($_POST['form2_submit'])){
        $booking_id = $_POST['booking_id'];

        $sql1 = "INSERT INTO `cancelled_bookings`(`booking_id`) VALUES ($booking_id)";
        $mysqli->query($sql1);
        echo "<script>alert('Your Booking is Deleted!!');</script>";
    }

}
?>


    <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <span class="close" onclick="closePopup1()">&times;</span> -->
                <h3 class="i3-name">Cancel a booking</h3>
            </div>

            <br>

            <div class="modal-body">
              <form id="bookingForm" method="post">
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="booking_id">Booking ID:</label>
                        <input type="number" name="booking_id" placeholder="Booking ID">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="nic_number">NIC number:</label>
                        <input type="number" name="nic_number" placeholder="NIC Number">
                    </div>
                </div>

                <div class="update-form5">
                    <!-- <input class="btn-update" type="submit" name="submit" value="Add Team"> -->
                    <!-- <input class="btn-update" type="submit" name="submit" value="Add Match"> -->
                    <input onclick="openPopup2()" class="btn-update" type="submit" name="form1_submit" value="Confirm Booking ID and NIC">
                </div>
                </form>
                <p style="font-size: 12px;">**need to Booking ID & NIC Number</p>

                <br>


        <div class="modal-body">
            <div class="right" id="right">
              <div class="order-details">

              <div class="update-form1">
                    <div class="update-form2">
                    <label for="booking_id">Booking ID:</label>
                    <input value="<?php echo isset($order_id) ? $order_id : $result; ?>" type="number" name="nic_number" placeholder="<?php echo isset($order_id) ? $order_id : $result; ?>" readonly>
                    </div>
              </div>

              <div class="update-form1">
                    <div class="update-form2">
                    <label for="name">Name:</label>
                    <input value="<?php echo isset($name1) ? $name1 : ""; ?>" type="text" name="name" placeholder="<?php echo isset($name1) ? $name : ""; ?>" readonly>
                    </div>
              </div>

              <div class="update-form1">
                    <div class="update-form2">
                    <label for="coaches">Coaches:</label>
                    <input value="<?php echo isset($coaches) ? $coaches : ""; ?>" type="text" name="coaches" placeholder="<?php echo isset($coaches) ? $coaches : ""; ?>" readonly>
                    </div>
              </div>

              <div class="update-form1">
                    <div class="update-form2">
                    <label for="nets">Nets:</label>
                    <input value="<?php echo isset($nets) ? $nets : ""; ?>" type="text" name="nets" placeholder="<?php echo isset($nets) ? $nets : ""; ?>" readonly>
                    </div>
              </div>

                  <form method="post">
                      <input type="number" name="booking_id" value=<?php echo $order_id; ?> placeholder="Booking ID" hidden>
                      <button class="cancel-button btn-update" type="submit" onclick="return confirmAction()" name="form2_submit">Delete this booking</button>

                  </form>
              </div>
          </div>
          
        </div>
        
                </div>
                
                </div>
                <div class="but-container">
                    <button class="back btn-update" id="back">Back to Booking Calendar</button>
                </div>
                
            </div>

            <script>
                document.getElementById('back').addEventListener('click', function() {
                  window.location.href = '<?php echo URLROOT?>/N_Calendar'; // Redirect to index.html
                });
            </script>

</body>
</html>