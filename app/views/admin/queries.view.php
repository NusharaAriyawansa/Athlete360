<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/admin/queries.css">
    
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>  <!-- jQuery ready function -->
</head>

<body>
    <section id="menu">        
        <div class="logo">
            <img src="<?php echo URLROOT?>/images/logo.png" alt="">
        </div>

        <div class="items">
            <li><i class="fa fa-user"></i><a href="<?php echo URLROOT?>/A_MemberManage">Member Management</a></li>
            <li><i class="fa fa-user-circle-o"></i><a href="<?php echo URLROOT?>/A_CoachManage">Coach Management</a></li>
            <li><i class="fa fa-th-large"></i><a href="<?php echo URLROOT?>/A_EquipmentManage">Resource Management</a></li>
            <li><i class="fa-solid fa-clock"></i><a href="<?php echo URLROOT?>/A_Sessions">Session Management</a></li>
            <li><i class="fa fa-commenting"></i><a href="<?php echo URLROOT?>/A_Advertisement">Advertisements</a></li>
            <li><i class="fa fa-question"></i><a href="<?php echo URLROOT?>/A_Queries">Queries</a></li>
            <li><i class="fa fa-check-circle"></i><a href="<?php echo URLROOT?>/A_profile">My Profile</a></li>
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
            Queries posted by coaches
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa-solid fa-rectangle-ad"></i>
                <div>
                    <h3><?php echo $data['count_coaches']; ?></h3>
                    <span>Total No. of Queries Asked in the current month</span>
                </div>
            </div>
            
            <div class="val-box">
                <i class="fa fa-check-circle"></i>
                <div>
                    <h3><?php echo $data['count_coaches_reviewed']; ?></h3>
                    <span>No. of Queries Reviewed in the Current month</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-times-circle"></i>
                <div>
                    <h3><?php echo $data['count_coaches_not_reviewed']; ?></h3>
                    <span>No. of Queries to be Reviewed in the Current month</span>
                </div>
            </div>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th>Query ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Date/ Time</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $data['queries_by_coaches']->fetch_assoc()) : ?>
                        <tr>
                            <td class="addId"><?php echo $row['queryID']; ?></td>
                            <td><?php echo $row['userID']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['dateTime']; ?></td>
                            <td><?php echo $row['type']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td class="addReply"><?php echo $row['reply']; ?></td>

                            <td class ="edit" >
                                <i id="edit" class="fas fa-pencil-alt" style="color: green; cursor: pointer;"></i>
                            </td>
                        </tr>
                    <?php endwhile;?>
            </tbody>
            </table>
        </div>


        <h3 class="i2-name">
            Queries posted by members
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa-solid fa-rectangle-ad"></i>
                <div>
                    <h3><?php echo $data['count_members']; ?></h3>
                    <span>Total No. of Queries Asked in the current month</span>
                </div>
            </div>
            
            <div class="val-box">
                <i class="fa fa-check-circle"></i>
                <div>
                    <h3><?php echo $data['count_members_reviewed']; ?></h3>
                    <span>No. of Queries Reviewed in the Current month</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-times-circle"></i>
                <div>
                    <h3><?php echo $data['count_members_not_reviewed']; ?></h3>
                    <span>No. of Queries to be Reviewed in the Current month</span>
                </div>
            </div>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th>Query ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Date/ Time</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $data['queries_by_members']->fetch_assoc()) : ?>
                        <tr>
                            <td class="addId"><?php echo $row['queryID']; ?></td>
                            <td><?php echo $row['userID']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['dateTime']; ?></td>
                            <td><?php echo $row['type']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td class="addReply"><?php echo $row['reply']; ?></td>

                            <td class ="edit" >
                                <i id="edit" class="fas fa-pencil-alt" style="color: green; cursor: pointer;"></i>
                            </td>
                        </tr>
                    <?php endwhile;?>
            </tbody>
            </table>
        </div>
        <br><br>



        <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3 class="i3-name">Reply to Query</h3>
            </div>

            <div class="modal-body">
                <form method="post" action="<?php echo URLROOT; ?>/A_Queries/update">
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="title">Query ID:</label>
                        <input type="text" id="updateId" name="updateId" value="">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="title">Reply:</label>
                        <input type="text" id="updateReply" name="updateReply" value="">
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
                var addReply = tableRow.find('.addReply').text();
    
                $('#updateId').val(addId);
                $('#updateReply').val(addReply);

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



</body>
</html>