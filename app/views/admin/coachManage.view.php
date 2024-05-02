<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/admin/coachManage.css">

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
            Coach Management
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $data['total_coaches']; ?></h3>
                    <span>Total coaches</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-user-plus"></i>
                <div>
                    <h3><?php echo $data['new_coaches']; ?></h3>
                    <span>New coaches</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-user"></i>
                <div>
                    <h3><?php echo $data['active_coaches']; ?></h3>
                    <span>Active coaches</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-user-times"></i>
                <div>
                    <h3><?php echo $data['inactive_coaches']; ?></h3>
                    <span>Inactive coaches</span>
                </div>
            </div>
        </div>

        <div class="people">
        <?php if (TRUE) : ?>
            <table width="100%">
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>Coach ID</th>
                    <th>Hire Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>NIC</th>
                    <th>Contact No</th>
                    <th>Address</th>
                    <th>DoB</th>
                    <th>Gender</th>
                    <th>Status</th>

                    <th>Years of Exp</th>    
                    <th>Qualifications</th>
                    <th>Salary</th>

                    <th></th>
                    <!--<th></th>-->
                </tr>
                </thead>

                <tbody> 
                
                <?php
                
                while($row = $data['coaches']->fetch_assoc()) : ?>
                    <tr>
                        <td class ="addID"><?php echo $row['userID']; ?></td>
                        <td class ="addCoachID"><?php echo $row['coachID']; ?></td>
                        <td class ="addHireDate"><?php echo $row['hireDate']; ?></td>
                        <td class ="addName"><?php echo $row['name']; ?></td>
                        <td class="addEmail"><?php echo $row['email']; ?></td>
                        <td class="addNic"><?php echo $row['nic']; ?></td>
                        <td class="addContactNo"><?php echo $row['contactNo']; ?></td>
                        <td class="addAddress"><?php echo $row['address']; ?></td>
                        <td class="addDob"><?php echo $row['dob']; ?></td>
                        <td class="addGender"><?php echo $row['gender']; ?></td>
                        <td class="addStatus"><?php echo $row['status']; ?></td>

                        <td class="addYearsOfExperience"><?php echo $row['yearsOfExperience']; ?></td>
                        <td class="addQualifications"><?php echo $row['qualifications']; ?></td>
                        <td class="addSalary"><?php echo $row['salary']; ?></td>

                        <td class= "edit" >
                            <i id="edit" class="fas fa-pencil-alt" style="color: green; cursor: pointer;"></i>
                        </td>
                        <!--<td class="delete">
                            <i class="fas fa-trash" style="color: black; cursor: pointer;" onclick="if(confirm('Are you sure you want to delete this?')) location.href='<?php echo URLROOT ?>/A_MemberManage/delete/<?php echo $row['userID']; ?>'"></i>
                        </td> -->
                    </tr>
                <?php endwhile;?>
            </tbody>

            </table>
            <?php else : ?>
                <p>No coaches found.</p>
            <?php endif; ?>
        </div>

        <div class="add-form">
            <h3 class="i2-name">
                Add a coach
            </h3>
    
            <form method="post" action="<?php echo URLROOT ?>/A_CoachManage/add">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required><br>

                <div class="update-labels">
                    <div class="form-row">
                        <label for="nic">NIC:</label>
                        <input type="text" id="nic" name="nic" required>
                    </div>

                    <div class="form-row">
                        <label for="contactNo">Contact No:</label>
                        <input type="text" id="contactNo" name="contactNo" required>
                    </div>
                </div>

                <div class="update-labels">
                    <div class="form-row">
                        <label for="gender">Gender:</label>
                        <input type="text" id="gender" name="gender" required>
                    </div>

                    <div class="form-row">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" required>
                    </div>
                </div>

                <div class="update-labels">
                    <div class="form-row">
                        <label for="yearsOfExperience">Years Of Experience:</label>
                        <input type="text" id="yearsOfExperience" name="yearsOfExperience" required>
                    </div>

                    <div class="form-row">
                        <label for="qualifications">Qualifications:</label>
                        <input type="text" id="qualifications" name="qualifications" required>
                    </div>
                </div>

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
                <h3 class="i3-name">Update a coach</h3>
            </div>

            <div class="modal-body">
                <form action="<?php echo URLROOT ?>/A_CoachManage/update " method="post"  >
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateID">User ID:</label>
                        <input type="text" id="updateID" name="updateID">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateHireDate">Hired Date:</label>
                        <input type="text" id="updateHireDate" name="updateHireDate">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateName">Name:</label>
                        <input type="text" id="updateName" name="updateName">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateEmail">Email:</label>
                        <input type="text" id="updateEmail" name="updateEmail">                    
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateNic">NIC:</label>
                        <input type="text" id="updateNic" name="updateNic">
                    </div>
                </div>
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateContactNo">Contact No.:</label>
                        <input type="text" id="updateContactNo" name="updateContactNo">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateGender">Gender:</label>
                        <input type="text" id="updateGender" name="updateGender">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateAddress">Address:</label>
                        <input type="text" id="updateAddress" name="updateAddress">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateDob">Date of Birth:</label>
                        <input type="text" id="updateDob" name="updateDob">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateStatus">Status:</label>
                        <input type="text" id="updateStatus" name="updateStatus">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateYearsOfExperience">Years Of Experience:</label>
                        <input type="text" id="updateYearsOfExperience" name="updateYearsOfExperience">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateQualifications">Qualifications:</label>
                        <input type="text" id="updateQualifications" name="updateQualifications">
                    </div>
                </div>
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateSalary">Salary:</label>
                        <input type="text" id="updateSalary" name="updateSalary">
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
                var addID = tableRow.find('.addID').text();
                var addHireDate = tableRow.find('.addHireDate').text();
                var addName = tableRow.find('.addName').text();
                var addEmail = tableRow.find('.addEmail').text();
                var addNic = tableRow.find('.addNic').text();
                var addContactNo = tableRow.find('.addContactNo').text();
                var addGender = tableRow.find('.addGender').text();
                var addAddress = tableRow.find('.addAddress').text();
                var addDob = tableRow.find('.addDob').text();
                var addStatus = tableRow.find('.addStatus').text();
                var addQualifications = tableRow.find('.addQualifications').text();
                var addYearsOfExperience = tableRow.find('.addYearsOfExperience').text();
                var addSalary = tableRow.find('.addSalary').text();
   
                $('#updateID').val(addID);
                $('#updateHireDate').val(addHireDate);
                $('#updateName').val(addName);
                $('#updateEmail').val(addEmail);
                $('#updateNic').val(addNic);
                $('#updateContactNo').val(addContactNo);
                $('#updateGender').val(addGender);
                $('#updateAddress').val(addAddress);
                $('#updateDob').val(addDob);
                $('#updateStatus').val(addStatus);
                $('#updateQualifications').val(addQualifications);
                $('#updateYearsOfExperience').val(addYearsOfExperience);
                $('#updateSalary').val(addSalary);

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
        