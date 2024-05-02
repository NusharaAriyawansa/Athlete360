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

		$date = $_REQUEST['date'];
		$time_slot = $_REQUEST['time_slot'];

// start - find and insert not booked nets
$queries = [
    "TRUNCATE TABLE book_net;",
    "TRUNCATE TABLE book_net_inverse;",

    "    INSERT INTO book_net (net_id, net_name)
    SELECT n.net_id, n.net_name
    FROM nets n
    LEFT JOIN booked_nets bn ON n.net_id = bn.booked_net_id
    LEFT JOIN bookings b ON bn.bookingId = b.booking_id
    LEFT JOIN payments p ON b.booking_id = p.booking_id
    WHERE b.date = '$date' 
    AND b.slot_id = $time_slot
    AND p.booking_id IS NOT NULL;",

"    INSERT INTO book_net_inverse (net_id, net_name)
    SELECT n.net_id, n.net_name
    FROM nets n
    LEFT JOIN book_net nb ON n.net_id = nb.net_id
    WHERE nb.net_id IS NULL;"
];

// Execute queries one by one
foreach ($queries as $query) {
    if ($mysqli->query($query) === TRUE) {
        // Query executed successfully
    } else {
        // Query execution failed
        echo "Error: " . $query . "<br>" . $mysqli->error;
        // You may choose to exit or handle the error in another way
    }
}
//start - 26

$queries1 = [
  "TRUNCATE TABLE book_coach;",
  "TRUNCATE TABLE book_coach_inverse;",
  
  "INSERT INTO book_coach (coach_id, coach_name)
    SELECT n.coach_id, n.coach_name
    FROM coach n
    LEFT JOIN booked_coaches bn ON n.coach_id = bn.booked_coach_id
    LEFT JOIN bookings b ON bn.bookingId = b.booking_id
    LEFT JOIN payments p ON b.booking_id = p.booking_id
    WHERE b.date = '$date' 
    AND b.slot_id = $time_slot
    AND p.booking_id IS NOT NULL;",
  
  "INSERT INTO book_coach_inverse (coach_id, coach_name)
    SELECT n.coach_id, n.coach_name
    FROM coach n
    LEFT JOIN book_coach nb ON n.coach_id = nb.coach_id
    WHERE nb.coach_id IS NULL;"
];

// Execute queries one by one
foreach ($queries1 as $query) {
  if ($mysqli->query($query) === TRUE) {
      // Query executed successfully
  } else {
      // Query execution failed
      echo "Error: " . $query . "<br>" . $mysqli->error;
      // You may choose to exit or handle the error in another way
  }
}

// end - find and insert not booked coaches

// Fetch and display data
$result = $mysqli->query("SELECT * FROM book_net_inverse;");
$result1 = $mysqli->query("SELECT * FROM book_coach_inverse;");
?>

<!-- HTML code to display data in tabular format -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/headCoach/teams.css">
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/non-member/style1.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Calendar</title>
    <style>
      body {margin:0;}

      .navbar {
        overflow: hidden;
        background-color: #373c4f;
        position: fixed;
        top: 0;
        width: 100%;
        display: flex;
        justify-content: center; /* Aligns items along the main axis (horizontally in this case) */
      }

      .navbar a {
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
        width: 200px;
      }

      .navbar a:hover {
        background: #ddd;
        color: black;
      }
    </style>
</head>
<body onload="runAfterLoad()">

  <!-- header -->
    <div class="navbar">
      <a href="#home">Home</a>
      <a href="#news">About Us</a>
      <a href="#contact">Contact Us</a>
      <a href="#contact">Register</a>
      <a href="#contact">Login</a>
    </div>

    
      <form method="POST" action="<?php echo URLROOT?>/N_ProcessBooking">
      <?php

          if ($result1->num_rows == 0) {
            ?>
              <div class="custom-div">
                  <p>Can't book on this time slot. If you want more details, please contact us.</p>
                  <a href="<?php echo URLROOT?>/N_Calendar">Go back to Calendar</a>
              </div>


                <!-- <button onclick="window.history.back();">Go Back</button> -->
            <?php
                // Exit the script to prevent further execution
                exit;                          
          }
      ?>
          <div class="container">
              <div class="table-container">
                  <h1 class="table-head">Available Nets</h1>
                  <table class="table1">
                          <thead>
                            <tr>
                              <th>Net Number</th>
                              <th>Net Name</th>
                              <th>Book</th>
                            </tr>
                          </thead>
                          <!-- PHP CODE TO FETCH DATA FROM ROWS -->



                            <?php  
                          // Loop till end of data
                          while ($rows = $result->fetch_assoc()) {
                          ?>
                          
                              <tr>
                                
                                  <!-- FETCHING DATA FROM EACH ROW OF EVERY COLUMN -->
                                  
                                  <td><?php echo $rows['net_id']; ?></td>
                                  <td><?php echo $rows['net_name']; ?></td>
                                  <td><input type="checkbox" name='selected_nets[]' value="<?php echo (int)$rows['net_id']; ?>"]></td>
                                  
                              
                              </tr>
                          
                          <?php
                          }
                          ?>
                      
                      </table>
                  </table>
                  <h1 class="time_indi">Time Slot:</h1>
                  <h2 class="time"><?php 
                    switch ($time_slot) {
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
                                    ?></h2>
              <input value="<?php echo $time_slot; ?>" id="time_1" name="time_1" hidden></input>
              </div>
              <div class="table-container">
                  <h1 class="table-head">Available Coaches</h1>
                  <table class="table1">
                      
                          <thead>
                            <tr>
                              <th>Coach Number</th>
                              <th>Coach Name</th>
                              <th>Book</th>
                            </tr>
                          </thead>
                          <!-- PHP CODE TO FETCH DATA FROM ROWS -->
                          <?php
                          // Loop till end of data
                          while ($rows = $result1->fetch_assoc()) {
                          ?>
                              <tr>
                                  <!-- FETCHING DATA FROM EACH ROW OF EVERY COLUMN -->
                                  <td><?php echo $rows['coach_id']; ?></td>
                                  <td><?php echo $rows['coach_name']; ?></td>
                                  <td><input type="checkbox" name='selected_coaches[]' value="<?php echo (int)$rows['coach_id']; ?>"]></td>


                              </tr>
                          <?php
                          }
                          ?>
                      
                      </table>
                  </table>
                  <h1 class="time_indi">Date:</h1>
                  <h2 class="time date"><?php echo $date; ?></h2>
                  <input value="<?php echo $date; ?>" id="datea" name="datea" hidden></input>
              </div>
      
          </div>

        
                      <!-- Form for date, time slot, and submit button -->
          <div class="form-container">
              
          
          <div class="from">
            
          <div class="modal" id="update-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close" onclick="closePopup1()">&times;</span>
                    <h3 class="i3-name">Make a Booking Form</h3>
                </div>

                <br>

              <div class="modal-body">
                  <form method="post" action="">
                  
                  <div class="update-form1">
                    <div class="update-form2">
                        <label for="namea">Name:</label>  
                        <input type="text" id="namea" name="namea" class="input1" placeholder="First and Last Name" pattern="^\w+\s+\w+$" title="Please enter your first and last name" required>
                    </div>
                  </div>

            
                  <div class="update-form1">
                    <div class="update-form2">
                        <label for="idNumber">ID Number:</label>  
                        <input type="text" id="idNumber" name="idNumber" class="input1" placeholder="NIC Number" pattern="\d{12}|\d{9}v" title="Please enter a valid ID number" required> 
                    </div> 
                  </div>

                  <div class="update-form1">
                      <div class="update-form2">
                          <label for="contactNumber">Phone:</label>  
                          <input type="text" id="contactNumber" name="contactNumber" class="input1" placeholder="Mobile Number" pattern="7\d{8}" title="Please enter a valid 7xxxxxxxx number" required>    
                      </div>
                  </div>
              </div>
            
              <div class="update-form5">
                <button type="submit" class="btn btn-update">Make a Booking</button>
              </div>

            </div>
          </div>
        </div>
              
          </div>
          </div>
        </form>
        <br>

        <div class="add-del-buts">
            <button class="add-button" onclick="openPopup1()">Make a Booking</button>
            <!-- <button class="delete-button" onclick="openPopup2()">Delete a Team</button> -->
        </div>




    <script src="<?php echo URLROOT?>/js/non-member/calendar.js"></script>

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