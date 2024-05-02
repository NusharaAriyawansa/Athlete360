<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petty Cash Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/payment-clark/pettyCash.css">

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
            <li><i class="fa fa-check-circle"></i><a href="<?php echo URLROOT?>/P_profile">My Profile</a></li>
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
            Monthly Expenses 
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3>Rs.5000/=</h3>
                    <span>Total</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3>NA</h3>
                    <span>Total expenses</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-money"></i>
                <div>
                    <h3>NA</h3>
                    <span>Remaining</span>
                </div>
            </div>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $data['records']->fetch_assoc()) : ?>
                        <tr>
                            <td class="addId"><?php echo $row['payment_id']; ?></td>
                            <td class="addDate"><?php echo $row['dateOnly']; ?></td>
                            <td class="addCategory"><?php echo $row['category']; ?></td>
                            <td class="addDescription"><?php echo $row['description']; ?></td>
                            <td class="addAmount">Rs. <?php echo $row['amount']; ?> /=</td>   
                            
                            <td class ="edit" >
                                <i id="edit" class="fas fa-pencil-alt" style="color: green; cursor: pointer;"></i>
                            </td>

                            <td class="delete">
                                <i class="fas fa-trash" style="color: black; cursor: pointer;" onclick="if(confirm('Are you sure you want to delete this?')) location.href='<?php echo URLROOT ?>/P_PettyCashPayments/delete/<?php echo $row['payment_id']; ?>'"></i>
                            </td>

                           
                        </tr>
                    <?php endwhile;?>
            </tbody>
            </table>
        </div>

        <div class="add-form">
            <h3 class="i2-name">
                Add an expense record
            </h3>
    
            <form method="post" action="<?php echo URLROOT ?>/P_PettyCashPayments/add">

                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required><br>

                <label for="category">Category:</label>
                <input type="text" id="category" name="category" required><br>

                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" required><br>

                <div class="update-form6">
                    <input type="submit" value="Submit" onclick="alert('Added successfully');">
                </div>           
            </form>
        </div>


        <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3 class="i3-name">Update a petty cash record</h3>
            </div>

            <div class="modal-body">
                <form method="post" action="<?php echo URLROOT ?>/P_PettyCashPayments/update " >
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="title">Id:</label>
                        <input type="text" id="updatePayment_id" name="updatePayment_id" value="">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="title">Date :</label>
                        <input type="text" id="updateTimestamp" name="updateTimestamp" value="">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="title">Category:</label>
                        <input type="text" id="updateCategory" name="updateCategory" value="">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="title">Description:</label>
                        <input type="text" id="updateDescription" name="updateDescription" value="">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="title">Amount:</label>
                        <input type="text" id="updateAmount" name="updateAmount" value="">
                    </div>
                </div>

                <div class="update-form5">
                    <button class="btn-update" id="password-change-submit" type ="submit" >Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.edit', function() {
                var tableRow = $(this).closest('tr');
        
                // Find the <td> element containing the data you want
                var addId = tableRow.find('.addId').text();
                var addDate = tableRow.find('.addDate').text();
                var addCategory = tableRow.find('.addCategory').text();
                var addDes = tableRow.find('.addDescription').text();
                var addAmount = tableRow.find('.addAmount').text();
    
                $('#updatePayment_id').val(addId);
                $('#updateTimestamp').val(addDate);
                $('#updateCategory').val(addCategory);
                $('#updateDescription').val(addDes);
                $('#updateAmount').val(addAmount);

        // Use the retrieved data as needed    
        // Show the modal or perform any other actions
                $('#update-modal').show();
                });
            });

            $(document).on('click', '.close', function() {
            var modal = $(this).closest('.modal');
            console.log("modal-close");

        modal.hide();
    });

    // close or modal-close both 
    $(document).on('click', '.modal-close', function() {
        var modal = $(this).closest('.modal');
        console.log("modal-close");

        modal.hide();
    });

    </script>




















    </section>

   

    </script>


    
</body>
</html>