<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">    
    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/coach/sessions.css">
    
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>  <!-- jQuery ready function -->
</head>

<body>
    <section id="menu"> 
        <div class="logo">
            <img src="<?php echo URLROOT?>/images/logo.png" alt="">
        </div>

        <div class="items">
            <li><i class="fa fa-user"></i><a href="<?php echo URLROOT?>/C_Dashboard">Dashboard</a></li>
            <li><i class="fa fa-th-large"></i><a href="<?php echo URLROOT?>/C_SessionManage">Session Plan</a></li>
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


        <!--TABLE 01 -->
        
        <h3 class="i-name">
            Schedule for club sessions 
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $data['u13_count']; ?></h3>
                    <span>Under 13 sessions</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $data['u15_count']; ?></h3>
                    <span>Under 15 sessions</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $data['u17_count']; ?></h3>
                    <span>Under 17 sessions</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $data['u19_count']; ?></h3>
                    <span>Under 19 sessions</span>
                </div>
            </div>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th>Session Date</th>
                    <th>Session Name</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $data['club_sessions']->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['session_date']; ?></td>
                            <td><?php echo $row['session_name']; ?></td>
                            <td><?php echo $row['start_time']; ?></td>
                            <td><?php echo $row['end_time']; ?></td>
                        </tr>
                    <?php endwhile;?>
            </tbody>
            </table>
        </div>


        <!--TABLE 02 -->

        <h3 class="i2-name">
            Schedule for private bookings - for members
        </h3>

        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Date</th>
                    <th>Slot No.</th>
                    <th>Net No.</th>
                    <th>Name</th>
                    <th>Contact No.</th>
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $data['member_private_sessions']->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['booking_id']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['slot_id']; ?></td>
                            <td>Net <?php echo $row['net_id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['contact_number']; ?></td>
                        </tr>
                    <?php endwhile;?>
            </tbody>
            </table>
        </div>


         <!--TABLE 03 -->

        <h3 class="i2-name">
            Schedule for private bookings - for non-members
        </h3>

        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Date</th>
                    <th>Slot No.</th>
                    <th>Net No.</th>
                    <th>Name</th>
                    <th>Contact No.</th>
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $data['non_member_private_sessions']->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['booking_id']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['slot_id']; ?></td>
                            <td>Net <?php echo $row['net_id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['contact_number']; ?></td>
                        </tr>
                    <?php endwhile;?>
            </tbody>
            </table>
            
        </div>
        <br><br>


    </section>
    
    
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