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

// Query to select holidays from the database
$query1 = "SELECT holiday FROM holidays";
$result1 = $mysqli->query($query1);

// Fetch holidays and store them in markedDates array
$markedDates1 = array();
while ($row1 = $result1->fetch_assoc()) {
    $markedDates1[] = $row1['holiday'];
}

$markedDates = [23,24];

// Free result set
//$result->free();

// Close connection
$mysqli->close();

// Output the markedDates array
//print_r($markedDates1);

// Output the markedDates array as JSON
echo "<script>";
echo "var markedDates1 = " . json_encode($markedDates1) . ";";
echo "</script>";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Stay organized with our user-friendly Calendar featuring events, reminders, and a customizable interface. Built with HTML, CSS, and JavaScript. Start scheduling today!"
    />
    <meta
      name="keywords"
      content="calendar, events, reminders, javascript, html, css, open source coding"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/non-member/style.css" />
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/headCoach/teams.css" />
    <title>Calendar with Events</title>
    <style>
      .add-button{
        margin-right: -5px;
        background-color: #373C4F;
      }
      .add-button:hover{
        margin-right: -5px;
        background-color: #373c4f85;
      }
    </style>
  </head>
  <body>

  <!-- header -->
    <div class="header">
    <ul class="menu">
      <li><a href="#">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
      <div class="menu-toggle" onclick="toggleMenu()">&#9776;</div>
    </div>
    <div class="container">
      <div class="left">
        <div class="calendar">
          <div class="month">
            <i class="fas fa-angle-left prev"></i>
            <div class="date">december 2015</div>
            <i class="fas fa-angle-right next"></i>
          </div>
          <div class="weekdays">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
          </div>
          <div class="days"></div>
          <div class="goto-today">
            <div class="goto">
              <input type="text" placeholder="mm/yyyy" class="date-input" />
              <button class="goto-btn">Go</button>
            </div>
            <button class="today-btn">Today</button>
          </div>
        </div>
      </div>
      <div class="right">
        <div class="today-date">
          <div class="event-day">wed</div>
          <div class="event-date">12th december 2022</div>
        </div>
        <form action="<?php echo URLROOT?>/N_BookTables" method="post">
            <h1 class="head-btn">Click the Time slot</h1>
            <div class="button-group">
              <button value="1" onclick="updateTimeSlot(this)" type="submit">9-10 AM</button>
              <button value="2" onclick="updateTimeSlot(this)" type="submit">10-11 AM</button>
              <button value="3" onclick="updateTimeSlot(this)" type="submit">11-12 AM</button>
              <button value="4" onclick="updateTimeSlot(this)" type="submit">12-1 PM</button>
              <button value="5" onclick="updateTimeSlot(this)" type="submit">1-2 PM</button>
              <button value="6" onclick="updateTimeSlot(this)" type="submit">2-3 PM</button>
              <button value="7" onclick="updateTimeSlot(this)" type="submit">3-4 PM</button>
              <button value="8" onclick="updateTimeSlot(this)" type="submit">4-5 PM</button>
              <button value="9" onclick="updateTimeSlot(this)" type="submit">5-6 PM</button>
              <button value="10" onclick="updateTimeSlot(this)" type="submit">6-7 PM</button>
              <button value="11" onclick="updateTimeSlot(this)" type="submit">7-8 PM</button>
              <button value="12" onclick="updateTimeSlot(this)" type="submit">8-9 PM</button>
            </div>

            <div class="events"></div>

            <center hidden>
            <h1>Retrive available nets</h1>
            
                <p>
                    <label for="date">Date:</label>
                    <input class="date-label" type="date" name="date" id="date3" class="date-input2">
                </p>
                
                <p>
                    <label for="time_slot">Time slot:</label>
                    <input type="number" name="time_slot" id="time_slot">
                </p>

                <!-- Replace input type="submit" with button -->
                <!-- <button type="submit">Submit</button> -->
        </form>
      </center>  

      <button id="cancelBookingButton" class="fixed-button add-button">Cancel<br>View a<br>Booking</button> 




      <script>

       console.log(markedDates1);
       console.log(markedDates1[1]) // Print the holidays array in console

        // Pass PHP array to JavaScript as JSON
        const markedDates = <?php echo json_encode($markedDates); ?>;

                document.getElementById('cancelBookingButton').addEventListener('click', function() {
                  window.location.href = '<?php echo URLROOT?>/N_CancelBooking'; // Redirect to index.html
                });
      </script>
    <script src="<?php echo URLROOT?>/js/non-member/calendar.js"></script>
    
  </body>
</html>
