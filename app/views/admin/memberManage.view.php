<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/admin/memberManage.css">

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
            Member Management
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3><?php echo $data['total_members']; ?></h3>
                    <span>Total members</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-user-plus"></i>
                <div>
                    <h3><?php echo $data['new_members']; ?></h3>
                    <span>New members</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-user"></i>
                <div>
                    <h3><?php echo $data['active_members']; ?></h3>
                    <span>Active members</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-user-times"></i>
                <div>
                    <h3><?php echo $data['inactive_members']; ?></h3>
                    <span>Inactive members</span>
                </div>
            </div>
        </div>

        <input type="text" id="searchInput" placeholder="Search by Name or User ID..." class="search-input">

        <div class="people">
        <?php if ($data!=null) : ?>
            <table width="100%" id="memberTable">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Reg Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>NIC</th>
                        <th>Contact No</th>
                        <th>Address</th>
                        <th>DoB</th>
                        <th>Gender</th>
                        <th>Status</th>

                        <th>School</th>  
                        <th>Grade</th>
                        <th>Age Group</th>
                        <th>Parent's Name</th>
                        <th>Relationship</th>
                        <th>Contact No.</th>

                        <th></th>
                        <!--<th></th>--> 
                    </tr>
                </thead>

                <tbody> 
                
                <?php
                
                while($row = $data['members']->fetch_assoc()) : ?>
                    <tr>
                        <td class ="addID" ><?php echo $row['userID']; ?></td>
                        <td class ="addRegDate"><?php echo $row['regDate']; ?></td>
                        <td class="addName"><?php echo $row['name']; ?></td>
                        <td class="addEmail"><?php echo $row['email']; ?></td>
                        <td class="addNic"><?php echo $row['nic']; ?></td>
                        <td class="addContactNo"><?php echo $row['contactNo']; ?></td>
                        <td class="addAddress"><?php echo $row['address']; ?></td>
                        <td class="addDob"><?php echo $row['dob']; ?></td>
                        <td class="addGender"><?php echo $row['gender']; ?></td>
                        <td class="addStatus"><?php echo $row['status']; ?></td>

                        <td class="addSchool"><?php echo $row['school']; ?></td>
                        <td class="addGrade"><?php echo $row['grade']; ?></td>
                        <td class="addAgeGroup"><?php echo $row['ageGroup']; ?></td>
                        <td class="addPName"><?php echo $row['pName']; ?></td>
                        <td class="addPRelationship"><?php echo $row['pRelationship']; ?></td>
                        <td class="addPContactNo"><?php echo $row['pContactNo']; ?></td>

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
                <p>No members found.</p>
            <?php endif; ?>
        </div>

        <h3 class="i-button">
            <a href="<?=URLROOT?>/H_Register" class="add-advertisement-link">
            <button class="add-member-button">Add a new member</button></a> 
        </h3>

    </section>

    <div class="modal" id="update-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3 class="i3-name">Update a member</h3>
            </div>

            <div class="modal-body">
                <form action="<?php echo URLROOT ?>/A_MemberManage/update " method="post"  >
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateID">User ID:</label>
                        <input type="text" id="updateID" name="updateID">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateRegDate">Registration Date:</label>
                        <input type="text" id="updateRegDate" name="updateRegDate">
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
                        <label for="updateAgeGroup">Age Group:</label>
                        <input type="text" id="updateAgeGroup" name="updateAgeGroup">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateSchool">School:</label>
                        <input type="text" id="updateSchool" name="updateSchool">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updateGrade">Grade:</label>
                        <input type="text" id="updateGrade" name="updateGrade">
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
                        <label for="updatePName">Parent's Name:</label>
                        <input type="text" id="updatePName" name="updatePName">
                    </div>
                </div>

                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updatePRelationship">Parent's Relationship:</label>
                        <input type="text" id="updatePRelationship" name="updatePRelationship">
                    </div>
                </div>
                
                <div class="update-form1">
                    <div class="update-form2">
                        <label for="updatePContactNo">Parent's Contact Number:</label>
                        <input type="text" id="updatePContactNo" name="updatePContactNo">
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
                var addName = tableRow.find('.addName').text();
                var addEmail = tableRow.find('.addEmail').text();
                var addNic = tableRow.find('.addNic').text();
                var addContactNo = tableRow.find('.addContactNo').text();
                var addGender = tableRow.find('.addGender').text();
                var addAddress = tableRow.find('.addAddress').text();
                var addDob = tableRow.find('.addDob').text();
                var addAgeGroup = tableRow.find('.addAgeGroup').text();
                var addSchool = tableRow.find('.addSchool').text();
                var addGrade = tableRow.find('.addGrade').text();
                var addStatus = tableRow.find('.addStatus').text();
                var addRegDate = tableRow.find('.addRegDate').text();
                var addPName = tableRow.find('.addPName').text();
                var addPRelationship = tableRow.find('.addPRelationship').text();
                var addPContactNo = tableRow.find('.addPContactNo').text();
                            
                $('#updateID').val(addID);
                $('#updateName').val(addName);
                $('#updateEmail').val(addEmail);
                $('#updateNic').val(addNic);
                $('#updateContactNo').val(addContactNo);
                $('#updateGender').val(addGender);
                $('#updateAddress').val(addAddress);
                $('#updateDob').val(addDob);
                $('#updateAgeGroup').val(addAgeGroup);
                $('#updateSchool').val(addSchool);
                $('#updateGrade').val(addGrade);
                $('#updateStatus').val(addStatus);
                $('#updateRegDate').val(addRegDate);
                $('#updatePName').val(addPName);
                $('#updatePRelationship').val(addPRelationship);
                $('#updatePContactNo').val(addPContactNo);

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
    
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $("#memberTable tbody tr").each(function() {
            // Check if the input is empty or matches the UserID or Name
            if (value == "" || ($(this).find(".addID").text().toLowerCase().indexOf(value) == -1 && $(this).find(".addName").text().toLowerCase().indexOf(value) == -1)) {
                $(this).removeClass('highlight'); // Remove highlighting
            } else {
                $(this).addClass('highlight'); // Apply highlighting to matching rows
            }
        });
    });
    
    </script>

<style>
    


</style>


</body>
</html>