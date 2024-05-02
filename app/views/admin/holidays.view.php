<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booking1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Add Holiday') {
    $holiday = $_POST['holiday'];
    $reason = $_POST['reason'];
    // Prepare and execute SQL query to insert data into 'holidays' table
    $add_query = "INSERT INTO `holidays`(`holiday`, `reason`) VALUES ('$holiday','$reason')";
    if(mysqli_query($conn, $add_query)) {
        echo "<script>alert('New Holiday added successfully!!')</script>";
    }
}


// Handle form submission for deleting a holiday
if(isset($_POST['submit']) && $_POST['submit'] == 'Delete Holiday') {
    $holiday = $_POST['holiday'];
    //$reason = $_POST['reason'];
    // Prepare and execute SQL query to delete data from 'holidays' table
    $delete_query = "DELETE FROM `holidays` WHERE holiday='$holiday'";
    if(mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Holiday deleted successfully!');</script>";
    } else {
        echo "Error deleting holiday: " . mysqli_error($conn);
    }
}

// Get the current month
$currentMonth = date('m');

// Get the next month
$nextMonth = date('m', strtotime('+1 month'));

// Fetch the number of holidays in the current month
$sqlCurrentMonth = "SELECT COUNT(*) AS num_holidays_current_month FROM holidays WHERE MONTH(holiday) = '$currentMonth'";
$resultCurrentMonth = $conn->query($sqlCurrentMonth);
$rowCurrentMonth = $resultCurrentMonth->fetch_assoc();
$numHolidaysCurrentMonth = $rowCurrentMonth['num_holidays_current_month'];

// Fetch the number of holidays in the next month
$sqlNextMonth = "SELECT COUNT(*) AS num_holidays_next_month FROM holidays WHERE MONTH(holiday) = '$nextMonth'";
$resultNextMonth = $conn->query($sqlNextMonth);
$rowNextMonth = $resultNextMonth->fetch_assoc();
$numHolidaysNextMonth = $rowNextMonth['num_holidays_next_month'];

// echo "Number of holidays in the current month: " . $numHolidaysCurrentMonth . "<br>";
// echo "Number of holidays in the next month: " . $numHolidaysNextMonth;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holidays</title>
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/headCoach/teams.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/member/payments.css">
    <style>
        .add-del-buts{
            margin-top: 30px;
        }
        .i-name2{
            margin-top: 0px;
            font-size: 20px;
        }
        .update-form2 input[type="date"],
        .del-hol{
            width: 75%; /* Allocating width for input */
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
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
            <li><i class="fa fa-user"></i><a href="<?php echo URLROOT?>/A_MemberManage">Member Management</a></li>
            <li><i class="fa fa-user-circle-o"></i><a href="<?php echo URLROOT?>/A_CoachManage">Coach Management</a></li>
            <li><i class="fa fa-th-large"></i><a href="<?php echo URLROOT?>/A_ResourceManage">Resource Management</a></li>
            <li><i class="fa fa-table"></i><a href="<?php echo URLROOT?>/">Session Management</a></li>
            <li><i class="fa fa-commenting"></i><a href="<?php echo URLROOT?>/A_Advertisement">Advertisements</a></li>
            <li><i class="fa fa-check-circle"></i><a href="<?php echo URLROOT?>/A_profile">My Profile</a></li>
        </div>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div class="search">
                    <i class="fa fa-search"></i>
                    <input type="text" placeholder="Search">
                </div>
            </div>
            <div class="profile">
                <i class="fa fa-bell"></i>
                <img src="<?php echo URLROOT?>/images/person.png" alt="">
            </div>
        </div>
        
        <h3 class="i-name">
            Holidays of Academy
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $numHolidaysCurrentMonth; ?></h3>
                    <span>Number of Holidays in this month</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-user-plus"></i>
                <div>
                    <h3><?php echo $numHolidaysNextMonth; ?></h3>
                    <span>Number of Holidays in next month</span>
                </div>
            </div>
        </div>

        <div class="add-del-buts">
            <button class="add-button" onclick="openPopup1()">Add a Holiday</button>
            <button class="delete-button" onclick="openPopup2()">Delete a Holiday</button>
        </div>

        <h2 class="i-name i-name2">
            Upcomming Holidays
        </h2>

        <?php
        // Fetch holidays from the database
        $sql = "SELECT * FROM holidays";
        $result = $conn->query($sql);
        ?>

        <div class="people">
            <table width="100%">
                <thead>
                    <tr>
                        <td>Date of Holiday</td>
                        <td>Reason</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are holidays in the database
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><h5>" . $row["holiday"] . "</h5></td>";
                            echo "<td><p>" . $row["reason"] . "</p></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No holidays found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>


    <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closePopup1()">&times;</span>
                <h3 class="i3-name">Add a Holiday</h3>
            </div>

            <br>

            <div class="modal-body">
                <form method="post" action="">
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="date">Holiday:</label>
                        <input type="date" id="holiday" name="holiday" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="reason">Reason:</label>
                        <input type="text" id="reason" name="reason" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>

                <div class="update-form5">
                    <input class="btn-update" type="submit" name="submit" value="Add Holiday">
                </div>
                </form>
                <p style="font-size: 12px;">**need to fill all 2 fields</p>
            </div>
        </div>
    </div>

    <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closePopup2()">&times;</span>
                <h3 class="i3-name">Delete a Holiday</h3>
            </div>

            <br>

            <div class="modal-body">
            <form method="post" action="">
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="holiday">Select Holiday:</label>
                        <select id="holiday" name="holiday" class="del-hol">
                            <!-- Populate select options with holidays from the database -->
                            <?php
                            $sql = "SELECT holiday FROM holidays";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["holiday"] . "'>" . $row["holiday"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="update-form5">
                    <input class="btn-update" type="submit" name="submit" value="Delete Holiday">
                </div>
            </form>
            </div>
        </div>
    </div>
    
    </section>
    

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