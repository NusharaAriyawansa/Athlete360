<?php
// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if teamID is set in the URL
if(isset($_GET['teamID'])) {
    $teamID = $_GET['teamID'];
    
    // Connect to MySQL
    $conn = mysqli_connect("localhost", "root", "", "athlete360");
    
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Add member to the team if form submitted
    if(isset($_POST['submit'])) {
        $memberID = sanitize_input($_POST['memberID']);
        $email = sanitize_input($_POST['email']);
        
        if($memberID){
            // Check if member already exists in the team
            $check_query = "SELECT * FROM member_team WHERE memberID = '$memberID' AND teamID = '$teamID'";
            $check_result = mysqli_query($conn, $check_query);
            if(mysqli_num_rows($check_result) > 0) {
                echo "Member is already in the team.";
            } else {
                // Check if memberID exists
                $member_check_query = "SELECT * FROM memberdetails WHERE memberID = '$memberID'";
                $member_check_result = mysqli_query($conn, $member_check_query);
                if(mysqli_num_rows($member_check_result) > 0) {
                    // Add member to the team
                    $add_query = "INSERT INTO member_team (memberID, teamID) VALUES ('$memberID', '$teamID')";
                    if(mysqli_query($conn, $add_query)) {
                        echo "Member added successfully.";
                    } else {
                        echo "Error adding member: " . mysqli_error($conn);
                    }
                } else {
                    echo "Member does not exist.";
                }
            }
        }
        if($email){

                    $add_query =  "INSERT INTO member_team (memberID, teamID) 
                                    SELECT ud.memberID, '$teamID' AS teamID FROM users u 
                                    JOIN memberdetails ud ON u.userID = ud.userID 
                                    WHERE u.email = '$email';";
                    if(mysqli_query($conn, $add_query)) {
                        echo "Member added successfully.";
                    } else {
                        echo "Error adding member: " . mysqli_error($conn);
                    }

            
        }
        }

    }
    
    // Delete member from the team if form submitted
    if(isset($_POST['delete'])) {
        $memberID = sanitize_input($_POST['delete']);
        
        // Delete member from the team
        $delete_query = "DELETE FROM member_team WHERE memberID = '$memberID' AND teamID = '$teamID'";
        if(mysqli_query($conn, $delete_query)) {
            echo "Member deleted successfully.";
        } else {
            echo "Error deleting member: " . mysqli_error($conn);
        }
    }
    
    // Fetch members of the team with their details
    $sql = "SELECT mt.memberID, u.name, u.dob
            FROM member_team mt
            INNER JOIN memberdetails md ON mt.memberID = md.memberID
            INNER JOIN users u ON md.userID = u.userID
            WHERE mt.teamID = $teamID";
    $result = mysqli_query($conn, $sql);

    $sql1 = "SELECT COUNT(*) AS num_rows FROM member_team WHERE teamID = '$teamID'";
    $result1 = $conn->query($sql1);

    $row1 = $result1->fetch_assoc();
    $numOfMembers = $row1["num_rows"];

    $sql2 = "SELECT `teamID`, `ageGroup`, `name` FROM `teams` WHERE teamID='$teamID';";
    $result2 = $conn->query($sql2);

    $row2 = $result2->fetch_assoc();
    $ageGroup = $row2["ageGroup"];
    $Tname = $row2["name"];
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Team</title>
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
                    <!-- <h2>ATHLETE' 360</h2> -->
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
                    View Team - <?php echo $ageGroup." - ".$Tname." Team" ?>
                </h3>

                <div class="go-back">
                    <a href="<?php echo URLROOT?>/C_Teams"><button class="add-button go-back-button">Go back to View all teams</button></a>
                </div>
                

                <div class="values">
                    <div class="val-box">
                        <i class="fa fa-users"></i>
                        <div>
                            <h3><?php echo $numOfMembers ?> Members</h3>
                            <span>Number of Members in the team</span>
                        </div>
                    </div>
                    <div class="val-box">
                        <i class="fa fa-user-plus"></i>
                        <div>
                            <h3>15 Members</h3>
                            <span>Maximum members for the team</span>
                        </div>
                    </div>
                    
                </div>

                
        <div class="people">
            <table class="team_table" width="100%">
                <thead>
                    <tr>
                        <td>Member ID</td> 
                        <td>Name</td>
                        <td>DOB</td>
                        <td>View Player Profile</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>".$row['memberID']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['dob']."</td>";
                            echo "<td class='table_but'>
                            
                            <i class='fa fa-eye' style='font-size:24px'></i></a></td>";
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
            <button class="add-button" onclick="openPopup1()">Add a Member</button>
            <button class="delete-button" onclick="openPopup2()">Delete a Member</button>
        </div>


    <!-- <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closePopup1()">&times;</span>
                <h3 class="i3-name">Add a Member</h3>
            </div>

            <br>

            <div class="modal-body">
                <form method="post" action="">
                    <div class="update-form1">
                        <div class="update-form2">
                            <label for="memberID">Member ID:</label>
                            <input type="text" id="memberID" name="memberID">
                        </div>
                    </div>

                    <div class="update-form5">
                        <input class="btn-update" type="submit" name="submit" value="Add Member">
                    </div>
                </form>
            </div>
        </div>
    </div> -->

    <div class="modal" id="update-modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" onclick="closePopup1()">&times;</span>
            <h3 class="i3-name">Add a Member</h3>
        </div>

        <br>

        <div class="modal-body">
            <form method="post" action="">
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="selectOne">Select One:</label>
                        <select class="update-form2" id="optionSelect" onchange="toggleInputField()">
                            <option value="memberID">Member ID</option>
                            <option value="email">Email</option>
                        </select>
                    </div>
                </div>

                <div class="update-form1" id="memberIDField">
                    <div class="update-form2">
                        <label for="memberID">Member ID:</label>
                        <input type="text" id="memberID" name="memberID">
                    </div>
                </div>

                <div class="update-form1" id="emailField" style="display: none;">
                    <div class="update-form2">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email">
                    </div>
                </div>

                <div class="update-form5">
                    <input class="btn-update" type="submit" name="submit" value="Add Member">
                </div>
            </form>
            <p style="font-size: 12px;">**Can add member using either member ID or email</p>
        </div>
    </div>
</div>





    <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closePopup2()">&times;</span>
                <h3 class="i3-name">Delete a member</h3>
            </div>

            <br>



            <div class="modal-body">
                <form id="deleteForm" method="post" action="">
                    <div class="update-form1">
                        <div class="update-form2">
                            <label for="delete">Member ID:</label>
                            <input type='text' name='delete'>
                        </div>
                    </div>

                    <div class="update-form5">
                        <input class="btn-update" type='submit' value='Delete' onclick="return confirmDelete()">
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
                if (confirm("Are you sure you want to delete this member?")) {
                    return true; // Proceed with form submission
                } else {
                    return false; // Cancel form submission
                }
            }
            function toggleInputField() {
                var optionSelect = document.getElementById("optionSelect");
                var memberIDField = document.getElementById("memberIDField");
                var emailField = document.getElementById("emailField");

                if (optionSelect.value === "memberID") {
                    memberIDField.style.display = "block";
                    emailField.style.display = "none";
                } else if (optionSelect.value === "email") {
                    memberIDField.style.display = "none";
                    emailField.style.display = "block";
                }
            }

        </script>
</body>
</html>

<?php
// Close connection
$conn->close();
        
?>