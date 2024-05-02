<?php

$numdates_thismon = "";
$numdates_nxtmon = "";

$coach_id =  $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "athlete360";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $name = "";
    $booking_id = "";

    $futureDate = $_POST["futureDate"];

    if(isset($_POST['selectAll']) && $_POST['selectAll'] == 'selectAll'){
        $numbers = range(1, 12);
    } else {
        $numbers = $_POST["numbers"];
    }

    foreach ($numbers as $number) {
        $sql = "INSERT INTO `bookings`(`name`, `id_number`, `contact_number`, `slot_id`, `net_id`, `coach_id`, `date`, `member_ID`) 
        VALUES ('coach', 1, 1, $number, 1, $coach_id, '$futureDate', 1)";
        
        if ($conn->query($sql) === TRUE) {
            $booking_id = $conn->insert_id;
            
            $sql2 = "INSERT INTO `booked_coaches`(`bookingId`, `booked_coach_id`) VALUES ($booking_id, $coach_id)";
            $conn->query($sql2);

            $sql3 = "INSERT INTO `payments`(`booking_id`, `amount`) VALUES ($booking_id, 1)";
            $conn->query($sql3);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $currentMonth = date('m');
    $nextMonth = $currentMonth +1;
    $currentYear = date('Y');


    // Query to count distinct dates in the current month where name is "coach" and coach_id is 2
    //$query3 = "SELECT COUNT(DISTINCT date) AS num_dates FROM bookings WHERE name = 'coach' AND coach_id = 2 AND MONTH(date) = $currentMonth AND YEAR(date) = $currentYear";
    // $query3 = "SELECT COUNT(DISTINCT date) AS num_dates FROM bookings WHERE name = 'coach' AND coach_id = 2 AND MONTH(date) = $currentMonth AND YEAR(date) = $currentYear";

    // $query4 = "SELECT COUNT(DISTINCT date) AS num_dates FROM bookings WHERE name = 'coach' AND coach_id = 2 AND MONTH(date) = $nextMonth AND YEAR(date) = $currentYear";
   
    // $result3 = $conn->query($query3);

    // $result4 = $conn->query($query4);
        

    // // $result3 = mysqli_query($conn, $query3);

    // if ($result3) {
    //     $row3 = mysqli_fetch_assoc($result3);
    //     $numdates_thismon = $row3['num_dates'];
    //     //echo "Number of distinct dates in current month where name=coach and coach_id=2: $numDates";
    // } else {
    //     echo "Error executing query: " . mysqli_error($conn);
    // }

    // //$query4 = "SELECT COUNT(DISTINCT date) AS num_dates FROM bookings WHERE name = 'coach' AND coach_id = 2 AND MONTH(date) = $nextMonth AND YEAR(date) = $currentYear";

    // //$result4 = mysqli_query($conn, $query4);

    // if ($result4) {
    //     $row4 = mysqli_fetch_assoc($result4);
    //     $numdates_nxtmon = $row4['num_dates'];
    //     //echo "Number of distinct dates in current month where name=coach and coach_id=2: $numDates";
    // } else {
    //     echo "Error executing query: " . mysqli_error($conn);
    // }

        // Redirect to the same page after processing the POST request
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">       
        
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>  <!-- jQuery ready function -->
    
    <title>Availability</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/headCoach/teams.css">
 
    <style>
        .modal-content{
            height: 500px;
            width: 900px;
        }

                /* Style for the popup */
                .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ccc;
            z-index: 9999;
        }

        /* Close button style */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        /* Close button hover effect */
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .unavailables {
            display: flex; /* Use flexbox */
            flex-wrap: nowrap; /* Ensure they stay in a single row */
            justify-content: flex-start; /* Align items from the start */
        }

        .unavailables a {
            background-color: rgb(86, 62, 196);
            color: white;
            padding: 1em 1.5em;
            text-decoration: none;
            text-transform: uppercase;
            margin: 30px 30px; /* Adjust margin to create space between items */
            align-items: center;
            border: 2px solid #555; /* Add border */
            
        }

        .unavailables a:hover {
            background-color: #555;
            cursor: pointer;
        }

        .unavailables a:active {
            background-color: black;
        }

        .add-button{
            margin-top: 30px;
        }

        .popup{
            width: 500px;
        }

        input[type="date" i]{
            width: 400px;
            height: 30px;
        }

        .checkbox-row {
            display: flex;
            flex-wrap: wrap;
        }

        .checkbox-item {
            flex-basis: 50%; /* Adjust as needed */
        }

        /* Optional: Add additional styling as needed */

        /* Modal styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
    max-width: 600px; /* Max width */
    border-radius: 10px;
}

.modal-header {
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Form styles */
.update-form1 {
    margin-bottom: 20px;
}

.update-form2 {
    margin-bottom: 10px;
}

.update-form2 label {
    font-weight: bold;
}

.checkbox-row {
    display: flex;
    flex-wrap: wrap;
}

.checkbox-item {
    flex-basis: 50%;
    margin-bottom: 10px;
}

/* Submit button styles */
.update-form5 {
    text-align: center;
    margin-top: 20px;
}

#submitButton {
    padding: 10px 20px;
    background-color: #444444;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 200px;
}

#submitButton:hover {
    background-color: #444444c3;
}




    </style>

    
</head>

<body>
    <section id="menu"> 
        <div class="logo">
            <img src="<?php echo URLROOT?>/images/logo.png" alt="">
        </div>

        <div class="items">
            <li><i class="fa fa-user"></i><a href="<?php echo URLROOT?>/C_Dashboard">Dashboard</a></li>
            <li><i class="fa fa-th-large"></i><a href="<?php echo URLROOT?>/C_SessionManage">Session Management</a></li>
            <li><i class="fa-solid fa-clock"></i><a href="<?php echo URLROOT?>/C_Availability">Availability</a></li>
            <li><i class="fa fa-file"></i><a href="<?php echo URLROOT?>/C_Performance">Player Performance</a></li>
            <li><i class="fa fa-money"></i><a href="<?php echo URLROOT?>/C_Earnings">Earnings</a></li>
            <li><i class="fa fa-thumbs-up"></i><a href="<?php echo URLROOT?>/C_Attendance">Attendance</a></li>
            <li><i class="fa fa-check-circle"></i><a href="<?php echo URLROOT?>/C_Profile">My Profile</a></li>
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
            Member Management
        </h3>

        <!-- <div class="values">
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php  if($numdates_thismon){
                        echo $numdates_thismon;}
                        else{
                            echo 0;
                        }
                    ; ?></h3>
                    <span>Unavailable days in this month</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-user-plus"></i>
                <div>
                    <h3><?php echo $numdates_nxtmon; ?></h3>
                    <span>Unavailable days in next month</span>
                </div>
            </div>
        </div> -->


        <div class="add-del-buts">
            <button class="add-button" onclick="openPopup1()">Add Unavailable date with time slots</button>
            <!-- <button class="delete-button" onclick="openPopup2()">Delete a Date</button> -->
        </div>

        <div class="unavailables">
        <?php

    $conn = mysqli_connect("localhost", "root", "", "athlete360");


    // Check if the date parameter is set
    if(isset($_GET['date'])) {
        // Retrieve the date from the URL parameter
        $date = $_GET['date'];

        // Query to select slot_ids for the given date
        $query = "SELECT slot_id FROM bookings WHERE name='coach' AND coach_id=$coach_id AND date='$date'";
        $result = mysqli_query($conn, $query);

        // Check if there are any results
        if (mysqli_num_rows($result) > 0) {
            // Output each slot_id in a popup window
            echo "<script>";
            echo "function showPopup() {";
            echo "var popup = document.getElementById('popup');";
            echo "popup.style.display = 'block';";
            echo "}";

            echo "function hidePopup() {";
            echo "var popup = document.getElementById('popup');";
            echo "popup.style.display = 'none';";
            echo "}";

            echo "</script>";

            echo "<a class='dates' href='#' onclick='showPopup()'>$date</a><br>";

            echo "<div id='popup' class='popup'>";
            echo "<span class='close' onclick='hidePopup()'>&times;</span>";
            echo "<h3>Slots for $date:</h3>";
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                $slot_id = $row['slot_id'];
                echo "<li>";switch ($slot_id) {
                    case 1:
                      echo '9-10 AM';
                      break;
                      case 2:
                        echo '10-11 AM';
                        break;
                        case 3:
                          echo '11-12 AM';
                          break;
                          case 4:
                            echo '12-1 PM';
                            break;
                            case 5:
                              echo '1-2 PM';
                              break;
                              case 6:
                                echo '2-3 PM';
                                break;
                                case 7:
                                  echo '3-4 PM';
                                  break;
                                  case 8:
                                    echo '4-5 PM';
                                    break;
                                    case 9:
                                      echo '5-6 PM';
                                      break;
                                      case 10:
                                        echo '6-7 PM';
                                        break;
                                        case 11:
                                          echo '7-8 PM';
                                          break;
                                          case 12:
                                            echo '8-9AM';
                                            break;
                      
                    default:
                    echo 'wrong time slot';
                  } ;"</li>";
            }
            echo "</ul>";
            echo "</div>";
        } else {
            echo "No bookings found for this date.";
        }
    } else {
        // Query to select distinct dates where name="coach" and coach_id=2
        $query = "SELECT DISTINCT date FROM bookings WHERE name='coach' AND coach_id=$coach_id";
        $result = mysqli_query($conn, $query);

        // Check if there are any results
        if (mysqli_num_rows($result) > 0) {
            // Output each unique date as a clickable link
            while ($row = mysqli_fetch_assoc($result)) {
                $date = $row['date'];
                echo "<a href='http://localhost/athlete360/public/C_Availability?date=$date#'>$date</a><br>";
            }
        } else {
            echo "No bookings found for this coach.";
        }
    }

    // Close the database connection
    //mysqli_close($conn);
    ?>

        </div>
    
    </section>


    <div class="modal" id="update-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close" onclick="closePopup1()">&times;</span>
                    <h3 class="i3-name">Select unavailable time slots for date</h3>
                </div>

                <br>

              <div class="modal-body">
                <form id="myForm" method="post" action="">
                  
                    <div class="update-form1">
                        <div class="update-form2">
                        <label for="futureDate">Select a date:</label>  
                        <input type="date" id="futureDate" name="futureDate" min="<?php echo date('Y-m-d'); ?>" required><br>
                        </div>
                    </div>

            
                    <div class="update-form1">
    <div class="update-form2">
        <label>Select Time slots:</label><br>
        <!-- <input type="checkbox" id="selectAll" name="selectAll" value="selectAll">Select All<br> -->
        <div class="checkbox-row">
            <?php
            // Generate checkboxes for numbers 1 to 12
            for ($i = 1; $i <= 12; $i++) {
                echo "<div class='checkbox-item'>";
                echo "<input type='checkbox' name='numbers[]' value='$i'>" ;                  
                switch ($i) {
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
                };
                echo "</div>"; // Close .checkbox-item div
            }
            ?>
        </div> <!-- Close .checkbox-row div -->
        <br>
        <div class="update-form5">
                <!-- <button type="submit" class="btn btn-update">Add payment to my dashboard</button> -->
                <input type="submit" id="submitButton" value="Submit">
              </div>
    </div>  
</div>

            


            </div>
        </div>




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

                    // JavaScript to handle 'Select All' functionality
            document.getElementById('selectAll').addEventListener('change', function() {
                var checkboxes = document.getElementsByName('numbers[]');
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = this.checked;
                }
                enableSubmit();
            });

            // JavaScript to enable submit button only when date and at least one number is selected
            function enableSubmit() {
                var futureDate = document.getElementById('futureDate').value;
                var checkboxes = document.getElementsByName('numbers[]');
                var submitButton = document.getElementById('submitButton');

                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked && futureDate) {
                        submitButton.disabled = false;
                        return;
                    }
                }

                submitButton.disabled = true;
            }

            // Event listener for date and number checkboxes
            document.getElementById('futureDate').addEventListener('change', enableSubmit);
            var checkboxes = document.getElementsByName('numbers[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].addEventListener('change', enableSubmit);
            }

        </script>


</body>
</html>