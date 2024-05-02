<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertisements</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/admin/advertisements.css">
    
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
            Advertisements
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa-solid fa-rectangle-ad"></i>
                <div>
                    <h3><?php echo $data['total_ads']; ?></h3>
                    <span>Total No. of Advertisements</span>
                </div>
            </div>
            
            <div class="val-box">
                <i class="fa-solid fa-calendar-week"></i>
                <div>
                    <h3><?php echo $data['weekly_ads']; ?></h3>
                    <span>Advertisements posted this week</span>
                </div>
            </div>
        </div>

        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Time Stamp</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                   <!--<?php if ($data['total_ads']>0): ?>-->
                        <?php while($row = $data['ads']->fetch_assoc()) : ?>
                            <tr>
                                <td class="addId"><?php echo $row['id']; ?></td>
                                <td class="addTime"><?php echo $row['dateOnly']; ?></td>
                                <td class="addTitle"><?php echo $row['title']; ?></td>
                                <td class="addDes"><?php echo $row['description']; ?></td>
                                
                                <td class ="edit" >
                                    <i id="edit" class="fas fa-pencil-alt" style="color: green; cursor: pointer;"></i>
                                </td>
                                <td class="delete">
                                    <i class="fas fa-trash" style="color: black; cursor: pointer;" onclick="if(confirm('Are you sure you want to delete this?')) location.href='<?php echo URLROOT ?>/A_Advertisement/delete/<?php echo $row['id']; ?>'"></i>
                                </td>

                            </tr>
                        <?php endwhile;?>
                        <!--<?php else: ?>
                            <tr>
                                <td colspan="6">No advertisements found.</td>
                            </tr>
                        <?php endif; ?>-->
            </tbody>
            </table>
        </div>

        <div class="add-form">
            <h3 class="i2-name">
                Add an advertisement
            </h3>
    
            <form method="post" action="<?php echo URLROOT ?>/A_Advertisement/add">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br>

                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required><br>

                <div class="update-form6">
                    <input type="submit" value="Submit" onclick="alert('Added successfully');">
                </div>           
            </form>
        </div>
        
    </section>

    <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3 class="i3-name">Update advertisement</h3>
            </div>

            <div class="modal-body">
                <form method="post" action="<?php echo URLROOT ?>/A_Advertisement/update " >
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="title">Id:</label>
                        <input type="text" id="updateId" name="updateId" value="">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="title">Timestamp:</label>
                        <input type="text" id="updateTime" name="updateTime" value="">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="title">Title:</label>
                        <input type="text" id="updateTitle" name="updateTitle" value="">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="title">Description:</label>
                        <input type="text" id="updateDescription" name="updateDescription" value="">
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
                var addTime = tableRow.find('.addTime').text();
                var addTitle = tableRow.find('.addTitle').text();
                var addDes = tableRow.find('.addDes').text();
    
                $('#updateId').val(addId);
                $('#updateTime').val(addTime);
                $('#updateTitle').val(addTitle);
                $('#updateDescription').val(addDes);

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