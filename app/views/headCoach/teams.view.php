<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "athlete360";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the number of rows in the teams table
$sql = "SELECT COUNT(*) AS num_rows FROM teams";
$result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // Output data of each row
//     while($row = $result->fetch_assoc()) {
//         echo "Number of rows in teams table: " . $row["num_rows"];
//     }
// } else {
//     echo "0 results";
// }
$row = $result->fetch_assoc();
$numOfTeams = $row["num_rows"];
// // Check if form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Get form data
//     $teamID = $_POST['teamID'];
//     $ageGroup = $_POST['ageGroup'];
//     $name = $_POST['name'];

//     // Prepare and execute SQL query to insert data into 'teams' table
//     $sql = "INSERT INTO teams (teamID, ageGroup, name) VALUES ('$teamID', '$ageGroup', '$name')";

//     if ($conn->query($sql) === TRUE) {
//         echo "New record created successfully";
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }

if(isset($_POST['submit']) && $_POST['submit'] == 'Add Team') {
    $teamID = $_POST['teamID'];
    $ageGroup = $_POST['ageGroup'];
    $namea = $_POST['namea'];
            $add_query = "INSERT INTO `teams`(`teamID`, `ageGroup`, `name`) VALUES ('$teamID','$ageGroup','$namea')";
            if(mysqli_query($conn, $add_query)) {
                echo "Member added successfully.";
            } else {
                echo "Error adding member: " . mysqli_error($conn);
            }
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Delete Team') {
    $teamID = $_POST['teamID'];
            $delete_query = "DELETE FROM `teams` WHERE teamID=$teamID;";
            if(mysqli_query($conn, $delete_query)) {
                echo "Member deleted successfully.";
            } else {
                echo "Error deleting member: " . mysqli_error($conn);
            }
}
//     }
// }


// Fetch teams from database
$sql = "SELECT * FROM teams";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/headCoach/teams.css">
    <style>




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
                    All Teams
                </h3>

                <div class="values">
                    <div class="val-box">
                        <i class="fa fa-users"></i>
                        <div>
                            <h3><?php echo "<p>".$numOfTeams." Teams </p>" ?></h3>
                            <span>Number of Teams</span>
                        </div>
                    </div>
                    <div class="val-box">
                        <i class="fa fa-user-plus"></i>
                        <div>
                            <h3>Age Groups</h3>
                            <span>U19, U17, U15, U13</span>
                        </div>
                    </div>
                    
                </div>

                
        <div class="people">
            <table class="team_table" width="100%">
                <thead>
                    <tr>
                        <td>Team Id</td> 
                        <td>Age Group</td>
                        <td>Name</td>
                        <td>View, Add, Delete Team Members</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>".$row['teamID']."</td>";
                            echo "<td>".$row['ageGroup']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td class='table_but'><a href='C_ViewTeam?teamID=".$row['teamID']."&ageGroup=".$row['ageGroup']."'><i class='fa fa-edit' style='font-size:24px'></i></a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="add-del-buts">
            <button class="add-button" onclick="openPopup1()">Add a Team</button>
            <button class="delete-button" onclick="openPopup2()">Delete a Team</button>
        </div>


    <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closePopup1()">&times;</span>
                <h3 class="i3-name">Add Team</h3>
            </div>

            <br>

            <div class="modal-body">
                <form method="post" action="">
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="teamID">Team ID:</label>
                        <input type="number" id="teamID" name="teamID" required>
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                    <label for="ageGroup">Age Group:</label>
                    <select class="drop-down" id="ageGroup" name="ageGroup" required>
                        <option value="">Select Age Group</option>
                        <option value="Under 19">Under 19</option>
                        <option value="Under 17">Under 17</option>
                        <option value="Under 15">Under 15</option>
                        <option value="Under 13">Under 13</option>
                    </select>
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="namea">Team Name:</label>
                        <input type="text" id="namea" name="namea" required>
                    </div>
                </div>
                <div class="update-form5">
                    <input class="btn-update" type="submit" name="submit" value="Add Team">
                </div>
                </form>
                <p style="font-size: 12px;">**need to fill all 3 fields</p>
            </div>
        </div>
    </div>



    <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closePopup2()">&times;</span>
                <h3 class="i3-name">Delete Team</h3>
            </div>

            <br>

            <div class="modal-body">
    <form id="deleteForm" method="post" action="">
        <div class="update-form1">
            <div class="update-form2">
                <label for="teamID">Team ID:</label>
                <select class="drop-down" id="teamID" name="teamID">
                    <option value="">Select a team</option>
                    <?php
                    // Assuming you're using PHP for server-side scripting
                    // Connect to your database and retrieve teams
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "athlete360";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // SQL query to retrieve teams
                    $sql = "SELECT teamID, ageGroup, name FROM teams";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['teamID'] . "'>" . $row['teamID'] . " - " . $row['ageGroup'] . " - " . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No teams available</option>";
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </select>
            </div>
        </div>


        <div class="update-form5">
            <input class="btn-update" type="submit" name="submit" value="Delete Team" onclick="return confirmDelete()">
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

<?php
// Close connection
//$conn->close();
?>