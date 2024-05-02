<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">    
    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/coach/dashboard.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                Advertisements
        </h3>
        
        <div class="announcements">
            <?php while($row = $data['ads']->fetch_assoc()) : ?>
                <div class="announcement">
                    <h4><?php echo $row['title']; ?></h4>
                    <p><?php echo $row['description']; ?></p>
                </div>
            <?php endwhile;?>            
        </div>

        <div class="add-form">
            <h3 class="i2-name">
                Add your queries 
            </h3>
    
            <form method="post" action="<?php echo URLROOT ?>/C_Dashboard/add">
                <label for="type">Type:</label>
                <select id="type" name="type" required>
                    <option value="Select an Option">Select an option</option> 
                    <option value="About sessions details">About sessions details</option>
                    <option value="About coach details">About coach details</option> 
                    <option value="Other">Other</option> 
                </select>
              
                <label for="description">Enter your query:</label>
                <input type="text" id="description" name="description" required><br>

                <div class="update-form6">
                    <input type="submit" value="Submit" onclick="alert('Added successfully');">
                </div>           
            </form>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th>Query ID</th>
                    <th>Date/Time</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Reply</th>
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $data['all_queries']->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['queryID']; ?></td>
                            <td><?php echo $row['dateTime']; ?></td>
                            <td><?php echo $row['type']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['reply']; ?></td>
                        </tr>
                    <?php endwhile;?>
            </tbody>
            </table>
        </div>

        <h3 class="i3-name">
            Team Selections and Match Scheduling  
        </h3>
        <p class="i4-name">*only applicable to the head coach</p>
        <div class="head-coach1">
            <div class="head-coach2">
                <a href="<?php echo URLROOT?>/C_Teams">Select Teams</a>
            </div>  
            <div class="head-coach2">
                <a href="<?php echo URLROOT?>/C_ScheduleMatches">Schedule Matches</a>
            </div>
        </div>
</body>


<script>
  $(document).ready(function() {
    var currentUrl = window.location.href;
    $('#menu .items li a').each(function() {
      var href = new URL($(this).attr('href'), '<?php echo URLROOT; ?>').href;
      if (currentUrl.includes(href)) {
        $(this).parent('li').addClass('active');
      }
    });
  });
</script>





</html>