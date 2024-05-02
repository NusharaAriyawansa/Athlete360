<?php
    $conn = new mysqli("localhost", "root", "", "athlete360");
      
    if(isset($_POST['submit']) && $_POST['submit'] == 'Add Match') {
        $matchID = $_POST['matchID'];
        $matchDate = $_POST['matchDate'];
        $matchName = $_POST['matchName'];
        $ageGroup = $_POST['ageGroup'];    //mehema gnna ba
        $teamID = $_POST['teamID'];
        $opponents = $_POST['opponents'];
        
                $add_query = "INSERT INTO `matches`(`matchID`, `date`, `matchName`, `teamID`, `vs`) VALUES ('$matchID','$matchDate','$matchName','$teamID','$opponents')";
                if(mysqli_query($conn, $add_query)) {
                    echo "Member added successfully.";
                } else {
                    echo "Error adding member: " . mysqli_error($conn);
                }
    }
    
    if(isset($_POST['submit']) && $_POST['submit'] == 'Delete Match') {
        $matchID = $_POST['matchID'];
                $delete_query = "DELETE FROM `matches` WHERE matchID=$matchID;";
                if(mysqli_query($conn, $delete_query)) {
                    echo "Match deleted successfully.";
                } else {
                    echo "Error deleting Match: " . mysqli_error($conn);
                }
    }

    $sql1 = "SELECT COUNT(*) AS num_rows
            FROM matches m
            JOIN teams t ON m.teamID = t.teamID
            WHERE m.date > CURDATE();";

    $result1 = mysqli_query($conn, $sql1);
    $row1 = $result1->fetch_assoc();
    $numOfMatchesUp = $row1["num_rows"];

    $sql2 = "SELECT COUNT(*) AS num_matches
            FROM matches m
            JOIN teams t ON m.teamID = t.teamID
            WHERE (MONTH(m.date) = MONTH(CURDATE()) AND YEAR(m.date) = YEAR(CURDATE()))
                AND (m.date > CURDATE());";

    $result2 = mysqli_query($conn, $sql2);
    $row2 = $result2->fetch_assoc();
    $numOfMatchesUpThis = $row2["num_matches"];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Matches</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/headCoach/teams.css">
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
            All Matches
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-calendar"></i>
                <div>
                    <h3><?php echo $numOfMatchesUp ?> Matches</h3>
                    <span>Total Upcoming Matches</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-calendar"></i>
                <div>
                <h3><?php echo $numOfMatchesUpThis ?> Matches</h3>
                    <span>Upcoming Matches in this month</span>
                </div>
            </div>

        <div class="add-del-buts matches_but">
            <button class="add-button" onclick="openPopup1()">Add a Match</button>
            <button class="delete-button" onclick="openPopup2()">Delete a Match</button>
        </div>
            
        </div>
        <h3 " class="i-name match-table">
            Upcoming Matches
        </h3>
        <div class="people">

        
            <table class="team_table" width="100%">
                <thead>
                    <tr>
                        <td>Match ID</td> 
                        <td>Date</td>
                        <td>Match Name</td>
                        <td>Age Group</td>
                        <td>Team Name</td>
                        <td>Opponents</td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    // Connect to MySQL
                    $conn = mysqli_connect("localhost", "root", "", "athlete360");
                    
                    // Check connection
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    
                    // // Fetch teams from database
                    // $sql = "SELECT * FROM teams";
                    // $result = mysqli_query($conn, $sql);

                                // Fetch upcoming and finished matches from the database
                    $sql_upcoming = "SELECT m.matchID, m.date, m.matchName, t.ageGroup, t.name AS team_name, m.vs
                    FROM matches m
                    JOIN teams t ON m.teamID = t.teamID
                    WHERE m.date > CURDATE();";

                    $sql_finished = "SELECT m.matchID, m.date, m.matchName, t.ageGroup, t.name AS team_name, m.vs
                    FROM matches m
                    JOIN teams t ON m.teamID = t.teamID
                    WHERE m.date < CURDATE();";

                    $result_upcoming = mysqli_query($conn, $sql_upcoming);
                    $result_finished = mysqli_query($conn, $sql_finished);
                    
                    function displayMatches($result) {
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>".$row['matchID']."</td>";
                                echo "<td>".$row['date']."</td>";
                                echo "<td>".$row['matchName']."</td>";
                                echo "<td>".$row['ageGroup']."</td>";
                                echo "<td>".$row['team_name']."</td>";
                                echo "<td>".$row['vs']."</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>0 results</td></tr>";
                        }
                    }

                    displayMatches($result_upcoming);
                ?>

            </table>
        </div>

            <h3 class="i-name">
            Finished Matches
            </h3>
            <div class="people">
                    <table class="team_table" width="100%" >
                    <thead>
                        <tr>
                            <td>Match ID</td>
                            <td>Date</td>
                            <td>Match Name</td>
                            <td>Age Group</td>
                            <td>Team Name</td>
                            <td>Opponents</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display finished matches
                        displayMatches($result_finished);
            
                        // Close connection
                        mysqli_close($conn);
                        ?>
                    </tbody>



                </tbody>
            </table>
            </div>
            <!-- The popup box -->


    <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closePopup1()">&times;</span>
                <h3 class="i3-name">Add a Match</h3>
            </div>

            <br>

            <div class="modal-body">
                <form method="post" action="">
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="matchID">Match ID:</label>
                        <input type="number" id="matchID" name="matchID">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="matchDate">Match Date:</label>
                        <input class="selectOne" type="date" id="matchDate" name="matchDate">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="matchName">Match Name:</label>
                        <input type="text" id="matchName" name="matchName">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                    <label for="teamID">Select Team:</label>
                    <select class="selectOne" id="teamID" name="teamID">
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

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="opponents">Opponents:</label>
                        <input type="text" id="opponents" name="opponents">
                    </div>
                </div>



                <div class="update-form5">
                    <!-- <input class="btn-update" type="submit" name="submit" value="Add Team"> -->
                    <input class="btn-update" type="submit" name="submit" value="Add Match">
                </div>
                </form>
                <p style="font-size: 12px;">**need to fill all fields</p>
            </div>
        </div>
    </div>


    <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closePopup2()">&times;</span>
                <h3 class="i3-name">Delete a Match</h3>
            </div>

            <br>



            <div class="modal-body">
                <form id="deleteForm" method="post" action="">

                    <div class="update-form1">
                    <div class="update-form2">
                    <label for="matchID">Match ID:</label>
                    <select class="selectOne" type="number" id="matchID" name="matchID">
                        <option value="">Select a match</option>
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
                            $sql = "SELECT m.matchID, m.date, m.matchName, t.ageGroup, t.name AS team_name, m.vs
                                    FROM matches m
                                    JOIN teams t ON m.teamID = t.teamID
                                    WHERE m.date > CURDATE();";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['matchID'] . "'>" . $row['date'] . " - " . $row['ageGroup'] . " - " .$row['team_name'] . "</option>";
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
                        <!-- <input class="btn-update" type='submit' value='Delete' onclick="return confirmDelete()"> -->
                        <input class="btn-update" type="submit" name="submit" value="Delete Match" onclick="return confirmDelete()">
                    </div>
                </form>
                <p style="font-size: 12px;">**Can delete only upcoming matches</p>
            </div>
        </div>
    </div>



    </section>


            <script>
                // Function to open the popup
                function openPopup() {
                    document.getElementById("popup").style.display = "block";
                }
                // Function to close the popup
                function closePopup() {
                    document.getElementById("popup").style.display = "none";
                }

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
                    if (confirm("Are you sure you want to delete this match?")) {
                        return true; // Proceed with form submission
                    } else {
                        return false; // Cancel form submission
                    }
                }
            </script>
    
</body>
</html>
