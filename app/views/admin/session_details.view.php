<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sessions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/admin/sessions.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
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
            <li><i class="fa fa-table"></i><a href="<?php echo URLROOT?>/A_Sessions">Session Management</a></li>
            <li><i class="fa fa-commenting"></i><a href="<?php echo URLROOT?>/A_Advertisement">Advertisements</a></li>
            <li><i class="fa fa-check-circle"></i><a href="<?php echo URLROOT?>/A_profile">My Profile</a></li>
        </div>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div class="search">
                    <i class="fa fa-search"></i>
                    <input type="text" placeholder="Search">
                </div>
            </div>
            <div class="profile">
                <i class="fa fa-bell"></i>
                <img src="<?php echo URLROOT?>/images/person.png" alt="">
            </div>
        </div>
        
        <h2 class="i-name">Session Management</h2>        
        
        <div class="details">
            <h3>Session Details: <?php echo htmlspecialchars($data['session']['session_name']); ?></h3>
            <table width="100%" style="margin:10px 5px 0 5px">
                <thead>
                    <th>Session</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Allocated Equipments</th>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($data['session']['session_name']); ?></td>
                        <td><?php echo ($data['session']['day']); ?></td>
                        <td><?php echo ($data['session']['start_time']); ?></td>
                        <td><?php echo ($data['session']['end_time']); ?></td>
                        <td>
                            <?php foreach ($data['equipments'] as $equipment): ?>
                                <li><?php echo ($equipment['name']); ?></li>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="coach-member-details">
                <div class="add-member">
                    <h3>Members</h3>
                    <div class="search-bar">
                        <input type="text" id="memberSearch" placeholder="Enter member name to search">
                        <button class="search-btn" onclick="searchMembers()">&#x1F50D;</button>
                        <div id="searcMemberResults"></div>
                        <button id="addMemberButton" style="display:none;" onclick="addMemberToSession()">Add Selected Member</button>
                    </div>
                    <div class="member-table">
                        <table width=100%>
                            <thead>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th></th>
                            </thead>
                            <body>
                                <?php foreach ($data['members'] as $member): ?>
                                    <tr>
                                        <td><?php echo $member['memberID']; ?></td>
                                        <td><?php echo ($member['name']); ?></td>
                                        <td><button onclick="removeMemberFromSession(<?php echo $member['memberID']; ?>, <?php echo $data['session']['session_id']; ?>)" class="button-delete">&#x1F5D1</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            </body>
                        </table>
                    </div>
                </div>

                <div class="add-coaches">
                    <h3>Coaches</h3>
                    <div class="search-bar">
                        <input type="text" id="coachSearch" placeholder="Enter coach name to search">
                        <button  class="search-btn" onclick="searchCoaches()">&#x1F50D;</button>
                        <div id="searchCoachResults"></div>
                        <button id="addCoachButton" style="display:none;" onclick="addCoachToSession()">Add Selected Coach</button>
                    </div>
                    <div class="coach-table">
                        <table width=100%>
                            <thead>
                                <th>Coach ID</th>
                                <th>Name</th>
                                <th></th>
                            </thead>
                            <body>
                                <?php foreach ($data['coaches'] as $coach): ?>
                                    <tr>
                                        <td><?php echo $coach['coachID']; ?></td>
                                        <td><?php echo ($coach['name']); ?></td>
                                        <td><button onclick="removeMemberFromSession(<?php echo $coach['coachID']; ?>, <?php echo $data['session']['session_id']; ?>)" class="button-delete">&#x1F5D1</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            </body>
                        </table>
                    </div>
                </div>
            </div>

            <div>
                <form action="<?php echo URLROOT; ?>/A_Sessions/index/" method="POST">
                    <button type="submit" class="button-back">&larr; Back</button>
                </form>
            </div>
        </div>
    
    </section>
    
    <script>
        function searchMembers() {
            var query = document.getElementById('memberSearch').value;
            $.ajax({
                url: '<?php echo URLROOT; ?>/A_Sessions/searchMembers',
                type: 'POST',
                data: { query: query },
                success: function(data) {
                    $('#searcMemberResults').html(data);
                    if (data) {
                        $('#addMemberButton').show();
                    }
                },
                error: function() {
                    alert('Error searching members.');
                }
            });
        }

        function searchCoaches() {
            var query = document.getElementById('coachSearch').value;
            $.ajax({
                url: '<?php echo URLROOT; ?>/A_Sessions/searchCoaches',
                type: 'POST',
                data: { query: query },
                success: function(data) {
                    $('#searchCoachResults').html(data);
                    if (data) {
                        $('#addCoachButton').show();
                    }
                },
                error: function() {
                    alert('Error searching coaches.');
                }
            });
        }

        function addMemberToSession() {
            var user_id = $('#searcMemberResults input[type="checkbox"]:checked').val();
            if (user_id) {
                console.log(user_id)
                $.ajax({
                    url: '<?php echo URLROOT; ?>/A_Sessions/addMemberToSession/<?php echo $data['sessionId']; ?>',
                    type: 'POST',
                    data: { user_id },  // Changed from { id: selectedUserId }
                    success: function(response) {
                        alert('Member added successfully!');
                        $('#searcMemberResults').html(''); // Clear results
                        $('#addMemberButton').hide();
                        window.location.reload();
                    },
                    error: function() {
                        alert('Error adding member.');
                    }
                });
            } else {
                alert('No member selected.');
            }
        }

        function addCoachToSession() {
            var user_id = $('#searchCoachResults input[type="checkbox"]:checked').val();
            if (user_id) {
                $.ajax({
                    url: '<?php echo URLROOT; ?>/A_Sessions/addCoachToSession/<?php echo $data['sessionId']; ?>',
                    type: 'POST',
                    data: { user_id },  // Changed from { id: selectedUserId }
                    success: function(response) {
                        alert('Coach added successfully!');
                        $('#searchCoachResults').html(''); // Clear results
                        $('#addMemberButton').hide();
                        window.location.reload();
                    },
                    error: function() {
                        alert('Error adding member.');
                    }
                });
            } else {
                alert('No member selected.');
            }
        }

        function removeMemberFromSession(userId, sessionId) {
            if (confirm('Are you sure you want to remove this member?')) {
                $.ajax({
                    url: '<?php echo URLROOT; ?>/A_Sessions/removeMemberFromSession',
                    type: 'POST',
                    data: { user_id: userId, session_id: sessionId },
                    success: function(response) {
                        alert('Member removed successfully!');
                        window.location.reload();  
                    },
                    error: function() {
                        alert('Error removing member.');
                    }
                });
            }
        }

        function removeCoachFromSession(userId, sessionId) {
            if (confirm('Are you sure you want to remove this coach?')) {
                $.ajax({
                    url: '<?php echo URLROOT; ?>/A_Sessions/removeCoachFromSession',
                    type: 'POST',
                    data: { user_id: userId, session_id: sessionId },
                    success: function(response) {
                        alert('Coach removed successfully!');
                        window.location.reload();  
                    },
                    error: function() {
                        alert('Error removing coach.');
                    }
                });
            }
        }
    </script>

</body>
</html>