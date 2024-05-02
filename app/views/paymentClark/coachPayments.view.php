<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/payment-clark/coachSalaries.css">

    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>  <!-- jQuery ready function -->
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

        <h3 class="i-name">
            Due Coach Salaries
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $data['count_due_coaches']; ?> Coaches</h3>
                    <span>Number of coaches to be paid</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-user-plus"></i>
                <div>
                    <h3>Rs. <?php echo $data['total_due_payments']; ?>/=</h3>
                    <span>Total due salaries</span>
                </div>
           </div>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                    <tr>
                        <th>Coach ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Amount (Total) </th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if($data['coach_unpaid_club_session']!=null) : ?>
                        <?php while($row = $data['coach_unpaid_club_session']->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $row['coach_id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo  $row['amount']; ?></td>
                                <td>

                                <form class = "pay-button" method="post" action="<?php echo URLROOT ?>/P_CoachPayments/pay">
                                <button type="submit" name="action" value=<?php echo $row['coach_id']; ?>>pay</button>
                            </form> 

                                </td>
                            </tr>
                        <?php endwhile;?>
                    <?php endif;?>
                </tbody>
            </table>
        </div>

       

        <h3 class="i2-name">
            Coach Salary details 
        </h3>

        <div class="search-bar">
            <form id="selectionForm" action="<?php echo URLROOT ?>/P_CoachPayments/salary_selected_coach" method="POST">
                
                <select name="selected_coach" id="selected_coach">
                    <option value="">Select a Coach -></option>
                        <?php if ($data['all_coaches']) : ?>
                            <?php while ($row = $data['all_coaches']->fetch_assoc()) : ?>
                                <option value="<?php echo $row['coach_id']; ?>"><?php echo $row['coach_id']; ?></option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                </select>
            
                <input type="hidden" name="action_type" id="action_type" value="all"> 

                <button type="submit" onclick="document.getElementById('action_type').value='all'">All records</button>
                <button type="submit" onclick="document.getElementById('action_type').value='paid'">Paid</button>
                <button type="submit" onclick="document.getElementById('action_type').value='not_paid'">No Paid</button>
            </form>
        </div>

        </div>
    
        <div class="people">
            <table width="100%">
                <thead>
                    <tr>
                        <th>Coach ID</th>
                        <th>Booking ID</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if($data['option']!=null) : ?>
                        <?php while($row = $data['option']->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $row['coachID']; ?></td>
                                <td><?php echo $row['bookingID']; ?></td>
                                <td><?php echo $row['Salary']; ?></td>
                                <td><?php echo  $row['date']; ?></td>
                            </tr>
                        <?php endwhile;?>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </section>

    </body>

    <style>
        
    </style>

</html>