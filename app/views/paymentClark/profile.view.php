<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/payment-clark/profile.css">
</head>

<body>
    <section id="menu"> 
        <div class="logo">
            <img src="<?php echo URLROOT?>/images/logo.png" alt="">
        </div>

        <div class="items">
            <li><i class="fa fa-user"></i><a href="<?php echo URLROOT?>/P_MemberPayments">Member Payments</a></li>
            <li><i class="fa fa-user-circle-o"></i><a href="<?php echo URLROOT?>/P_CoachPayments">Coach Salaries</a></li>
            <li><i class="fa-solid fa-clock"></i><a href="<?php echo URLROOT?>/P_PrivateBookingPayments">Private Booking Payments</a></li>
            <li><i class="fa-solid fa-money-bill-transfer"></i><a href="<?php echo URLROOT?>/P_RefundForBookings">Refunding Payments</a></li>
            <li><i class="fa fa-money"></i><a href="<?php echo URLROOT?>/P_PettyCashPayments">Petty Cash Payments</a></li>
            <li><i class="fa fa-check-circle"></i><a href="<?php echo URLROOT?>/P_Profile">My Profile</a></li>
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

        <div class="user-profile">
            <div class="profile-content">

                <div class="page-data">
                    <div class="header-data">
                        <img class="img" src="<?php echo URLROOT?>/images/person.png" alt="Profile Image">
                        <h2 class="name"><?php echo $data['name']; ?></h2>
                        <h2 class="name"><?php echo $data['userID']; ?></h2>
                        <div class = "edit" >
                            <i id="edit" class="fas fa-pencil-alt" style="color: green; cursor: pointer;"></i>
                        </div>
                    </div>

                    <div class="card">
                        <ul>
                            <li><h4>Email:</h4><p><?php echo $data['email']; ?></p></li>
                            <br>
                            <li><h4>NIC:</h4><p><?php echo $data['nic']; ?></p></li>
                            <br>
                            <li><h4>Contact No.:</h4><p><?php echo $data['contactNo']; ?></p></li>
                            <br>
                            <li><h4>Gender:</h4><p><?php echo $data['gender']; ?></p></li>
                            <br>
                            <li><h4>Address:</h4><p><?php echo $data['address']; ?></p></li>
                            <br>
                            <li><h4>Date of Birth:</h4><p><?php echo $data['dob']; ?></p></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    
    </section>








    <script>

   
    </script>

    <style>
        

</style>

    
</body>
</html>