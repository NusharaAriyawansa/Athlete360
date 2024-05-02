<!DOCTYPE html>
<html lang="en">
<head>
    <title>Earnings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">    
    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/coach/earnings.css">
    
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>  <!-- jQuery ready function -->
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
            Earnings from club sessions 
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-calendar-check-o"></i>
                <div>
                    <h3><?php echo $data['count_income_club_session']; ?></h3>
                    <span>No. of sessions held</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3>LKR 6000.00</h3>
                    <span>Total earnings</span>
                </div>
            </div>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th> Occurrence ID </th>
                    <th> Date </th>
                    <th> Session Name </th>
                    <th> Number of Students Attended </th>
                    <th> Total Amount </th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($data['income_list_club_session'])): ?>

                    <?php while($row = $data['income_list_club_session']->fetch_assoc()) : ?>
                        <tr>
                            <td ><?php echo $row['occurrence_id']; ?></td>
                            <td ><?php echo $row['attendance_date']; ?></td>
                            <td><?php echo $row['session_name'] . " - " . $row['day']; ?></td>
                            <td ><?php echo( (int)$row['number_of_students'])*3; ?></td>
                            <td > Rs. <?php echo ((int)($row['number_of_students']))*500*3; ?> /=</td>
                        </tr>
                    <?php endwhile;?>

                    <?php else: ?>

            <tr>
                <td colspan="2">No attendance records found.</td>
            </tr>

        <?php endif; ?>

            </tbody>
            </table>
        </div>

        <h3 class="i2-name">
            Earnings from private sessions -  for members
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-calendar-check-o"></i>
                <div>
                    <h3><?php echo $data['count_private_booking_members']; ?> Sessions</h3>
                    <span>No. of sessions held</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3>Rs. <?php echo $data['total_private_booking_members']; ?>/=</h3>
                    <span>Total earnings</span>
                </div>
            </div>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $data['private_booking_members']->fetch_assoc()) : ?>
                        <tr>
                            <td ><?php echo $row['bookingID']; ?></td>
                            <td ><?php echo $row['date']; ?></td>
                            <td >Rs. <?php echo $row['Salary']; ?> .00/=</td>
                        </tr>
                    <?php endwhile;?>
            </tbody>
            </table>
        </div>

        <h3 class="i2-name">
            Earnings from private sessions -  for non-members
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-calendar-check-o"></i>
                <div>
                    <h3><?php echo $data['count_private_booking_non_members']; ?> Sessions</h3>
                    <span>No. of sessions held</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3>Rs. <?php echo $data['total_private_booking_non_members']; ?>/=</h3>
                    <span>Total earnings</span>
                </div>
            </div>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $data['private_booking_non_members']->fetch_assoc()) : ?>
                        <tr>
                            <td ><?php echo $row['bookingID']; ?></td>
                            <td ><?php echo $row['date']; ?></td>
                            <td >Rs. <?php echo $row['Salary']; ?> .00/=</td>
                        </tr>
                    <?php endwhile;?>
            </tbody>
            </table>
        </div>

       

        <h3 class="i-red-name">
            Total income =  LKR 21,750.00
        </h3>

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