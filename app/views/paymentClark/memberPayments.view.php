<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/payment-clark/memberPayments.css">

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
            Due Member Payments for Club Sessions
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $data['count_member_all_due_payments']; ?></h3>
                    <span>Number of member to pay</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3><?php echo $data['sum_member_all_due_payments']; ?></h3>
                    <span>Total due payments</span>
                </div>
           </div>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Member ID</th>
                        <th>Amount</th>
                        <th>Month</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if($data['member_all_payments']!=null) : ?>
                    <?php while($row = $data['member_all_due_payments']->fetch_assoc()) : ?>
                        <tr>
                            <td ><?php echo $row['id']; ?></td>
                            <td ><?php echo $row['member_id']; ?></td>
                            <td >Rs. <?php echo $row['amount']; ?> /=</td>
                            <td ><?php echo $row['month']; ?></td>
                            <td >
                            <form class = "pay-button" method="post" action="<?php echo URLROOT ?>/P_MemberPayments/paid">
                                <button type="submit" name="action" value=<?php echo $row['id']; ?>>pay</button>
                            </form> 

                            </td>
                        </tr>
                    <?php endwhile;?>
                    <?php endif;?>
                </tbody>
            </table>
        </div>

        <h3 class="i2-name">
            Member Payment details 
        </h3>

        <div class="search-bar">
            <form id="selectionForm" action="<?php echo URLROOT ?>/P_MemberPayments/load_payments" method="POST">
            <select name ="selected_member" id="selected_member">
                <option value="">Select a Member -></option>

                    <?php if ($data['all_members']) : ?>
                        <?php while ($row = $data['all_members']->fetch_assoc()) : ?>
                            <option value="<?php echo $row['memberID']; ?>"><?php echo $row['memberID']; ?></option>
                        <?php endwhile; ?>
                    <?php endif; ?>
            </select>
    
            <input type="hidden" name="action_type" id="action_type" value="all"> 

            <button class="load-button" type="submit" name="action" value="paid">Load</button>
           
            </form>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                    <tr>
                       
                        <th>Member ID</th>
                        <th>Amount</th>
                        <th>Month</th>
                        <th>No. of Sessions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if($data['option']!=null) : ?>
                        <?php while($row = $data['option']->fetch_assoc()) : ?>
                            <tr>
                                
                                <td ><?php echo $row['member_id']; ?></td>
                                <td ><?php echo $row['amount']; ?></td>
                                <td ><?php echo $row['month']; ?></td> 
                                <td ><?php echo $row['sessions_attended']; ?></td> 
                            </tr>
                        <?php endwhile;?>
                    <?php endif;?>
                </tbody>
            </table>
        </div>

    </section>
</body>2
</html>