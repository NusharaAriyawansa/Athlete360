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

    <link rel="stylesheet" href="<?php echo URLROOT?>/css/coach/profile.css">

    <style>
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 40%; /* Could be more or less, depending on screen size */
            background: #fff;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-content label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        .modal-content input[type="text"],
        .modal-content input[type="email"],
        .modal-content input[type="date"],
        .modal-content input[type="password"],
        .modal-content textarea[type="text"],
        .modal-content select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-save {
            display: block;
            background-color: #6a0602; 
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .btn-save:hover {
            background-color: #7f0808;
        }

        .close {
            cursor: pointer;
            float: right;
            font-size: 24px;
            font-weight: bold;
        }

        .close:hover {
            color: #f44336;
        }


    </style>
</head>

<body>
    <section id="menu"> 
        <div class="logo">
            <img src="<?php echo URLROOT?>/images/logo.png" alt="">
        </div>

        <div class="items">
            <li><i class="fa fa-user"></i></i><a href="<?php echo URLROOT?>/M_Dashboard">Dashboard</a></li>
            <li><i class="fa fa-th-large"></i><a href="<?php echo URLROOT?>/M_Sessions">Session Management</a></li>
            <li><i class="fa fa-money"></i><a href="<?php echo URLROOT?>/M_Payments">Payments</a></li>
            <li><i class="fa fa-file"></i><a href="<?php echo URLROOT?>/M_Performance">Performance Evaluation</a></li>
            <li><i class="fa fa-thumbs-up"></i><a href="<?php echo URLROOT?>/M_Attendance">Attendance Evaluation</a></li>
            <li><i class="fa fa-check-circle"></i><a href="<?php echo URLROOT?>/M_Profile">My Profile</a></li>
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
        
        <div class="profile-container">
            <div class="top-container" style="display:flex;">
                <div class="profile-header">
                    <img src="<?php echo URLROOT?>/images/person.png" alt="<?php URLROOT; ?>/images/person.png" class="profile-photo">
                    <h1><?php echo htmlspecialchars($data['profile']['name']); ?></h1>
                    <p><?php echo htmlspecialchars($data['profile']['memberID'] ?? ''); ?></p>
                    <p><?php echo htmlspecialchars($data['profile']['regDate'] ?? ''); ?></p>
                </div>

                <div class="" style="margin:60px; margin-left:300px;">
                    <div style="padding: 10px"><button id="editProfileBtn" class="change-btn">Edit Profile</button></div>
                    <div style="padding: 10px"><button id="addComplaintBtn" class="change-btn">Add Complaint</button></div>
                    <div style="padding: 10px"><button id="changePasswordBtn" class="change-btn">Change Password</button></div>
                </div>
            </div>

            <div id="editProfileModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Update Profile</h2>
                    <form id="editProfileForm" method="post" action="<?php echo URLROOT; ?>/M_Profile/updateProfile">
                        <input type="hidden" name="userID" value="<?php echo htmlspecialchars($data['profile']['userID']); ?>">
                        <input type="hidden" name="memberID" value="<?php echo htmlspecialchars($data['profile']['memberID']); ?>">

                        <label for="name">Full Name:</label>
                        <input type="text" name="name" placeholder="Full Name" value="<?php echo htmlspecialchars($data['profile']['name']); ?>">
                        
                        <label for="email">Email:</label>
                        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($data['profile']['email']); ?>">
                        
                        <label for="contactNo">Contact Number:</label>
                        <input type="text" name="contactNo" placeholder="Contact Number" value="<?php echo htmlspecialchars($data['profile']['contactNo'] ?? ''); ?>">

                        <label for="nic">NIC:</label>
                        <input type="text" name="nic" placeholder="NIC" value="<?php echo htmlspecialchars($data['profile']['NIC']  ?? ''); ?>">

                        <label for="gender">Gender:</label>
                        <select name="gender">
                            <option value="Male" <?php echo $data['profile']['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $data['profile']['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo $data['profile']['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>

                        <label for="address">Address:</label>
                        <input type="text" name="address" placeholder="Address" value="<?php echo htmlspecialchars($data['profile']['address']  ?? ''); ?>">

                        <label for="dob">Date of Birth:</label>
                        <input type="date" name="dob" value="<?php echo htmlspecialchars($data['profile']['dob'] ?? ''); ?>">

                        <label for="school">School:</label>
                        <input type="text" name="school" placeholder="School" value="<?php echo htmlspecialchars($data['profile']['school'] ?? ''); ?>">

                        <label for="pName">Parent's Name:</label>
                        <input type="text" name="pName" placeholder="Name" value="<?php echo htmlspecialchars($data['profile']['pName'] ?? ''); ?>">

                        <label for="pRelationship">Relationship to the Parent:</label>
                        <input type="text" name="pRelationship" placeholder="Relationship" value="<?php echo htmlspecialchars($data['profile']['pRelationship'] ?? ''); ?>">

                        <label for="pContactNo">Parent's Contact No:</label>
                        <input type="text" name="pContactNo" placeholder="Contact Number" value="<?php echo htmlspecialchars($data['profile']['pContactNo'] ?? ''); ?>">

                        <button type="submit" class="btn-save">Update Profile</button>
                    </form>
                </div>
            </div>


            <div id="addComplaintModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form id="addComplaintForm" method="POST" action="<?php echo URLROOT; ?>/M_Profile/">
                        <label for="complaint">Complaint</label>
                        <textarea type="text" name="complaint" placeholder="Describe your complaint"></textarea>
                        <button type="submit" class="btn-save">Submit Complaint</button>
                    </form>
                </div>
            </div>


            <div id="changePasswordModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form id="changePasswordForm" action="<?php echo URLROOT; ?>/M_Profile/changePassword" method="POST">
                        <label for="oldPassword">Current Password</label>
                        <input type="password" name="oldPassword" placeholder="Current Password">

                        <label for="newPassword">New Password</label>
                        <input type="password" name="newPassword" placeholder="New Password">

                        <label for="confirmNewPassword">Confirm New Password</label>
                        <input type="password" name="confirmNewPassword" placeholder="Confirm New Password">

                        <button type="submit" class="btn-save">Change Password</button>
                    </form>
                </div>
            </div>


            <div class="profile-info">
                <h2>Contact Information</h2>
                <p>Email: <?php echo htmlspecialchars($data['profile']['email']); ?></p>
                <p>Contact No: <?php echo htmlspecialchars($data['profile']['contactNo'] ?? ''); ?></p>
                <p>NIC: <?php echo htmlspecialchars($data['profile']['NIC'] ?? '-'); ?></p>
                <p>Gender: <?php echo htmlspecialchars($data['profile']['gender'] ?? ''); ?></p>
                <p>Address: <?php echo htmlspecialchars($data['profile']['address'] ?? ''); ?></p>
                <p>Date of Birth: <?php echo htmlspecialchars($data['profile']['dob'] ?? ''); ?></p>
            </div>


            <div class="school-info">
                <h2>School Details</h2>
                <p>School: <?php echo htmlspecialchars($data['profile']['school'] ?? ''); ?></p>
            </div>


            <div class="parent-info">
                <h2>Parent Details</h2>
                <p>Name: <?php echo htmlspecialchars($data['profile']['pName'] ?? ''); ?></p>
                <p>Contact No: <?php echo htmlspecialchars($data['profile']['pContactNo'] ?? ''); ?></p>
                <p>Relationship: <?php echo htmlspecialchars($data['profile']['pRelationship'] ?? ''); ?></p>
            </div>
        </div>
    </section>

    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = document.getElementById("editProfileModal");
            var complaintModal = document.getElementById("addComplaintModal");
            var passwordModal = document.getElementById("changePasswordModal");

            var editBtn = document.getElementById("editProfileBtn");
            var complaintBtn = document.getElementById("addComplaintBtn");
            var passwordBtn = document.getElementById("changePasswordBtn");

            var spans = document.getElementsByClassName("close");

            editBtn.onclick = function() {
                editModal.style.display = "block";
            }
            complaintBtn.onclick = function() {
                complaintModal.style.display = "block";
            }
            passwordBtn.onclick = function() {
                passwordModal.style.display = "block";
            }

            for (let span of spans) {
                span.onclick = function() {
                    this.parentElement.parentElement.style.display = "none";
                }
            }

            window.onclick = function(event) {
                if (event.target == editModal || event.target == complaintModal || event.target == passwordModal) {
                    event.target.style.display = "none";
                }
            }
        });

    </script>

<style>
        #menu .items li:nth-child(6){
    border-left: 4px solid #fff;
    background: #4d0f0f;
}
#menu .items li:nth-child(6) i{
    color: #F3F4F6;
}






    </style>

    
</body>
</html>