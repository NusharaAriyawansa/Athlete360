<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/coach/performance.css">

    <style>
        .modal {
            display: none; 
            position: fixed;
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%;
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 25%; 
            cursor: pointer;
        }
        .model-content td:hover {
            background-color: gray;
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        
    </style>
</head>

<body>
    <section id="menu"> 
        <div class="logo">
        <img src="<?php echo URLROOT?>/images/logo.png" alt="">
        </div>

        <div class="items">
            <li><i class="fa fa-user"></i><a href="<?php echo URLROOT?>/C_Dashboard">Dashboard</a></li>
            <li><i class="fa fa-th-large"></i><a href="<?php echo URLROOT?>/C_SessionManage">Session Management</a></li>
            <li><i class="fa-solid fa-clock"></i><a href="<?php echo URLROOT?>/C_Availability">Availability</a></li>
            <li><i class="fa fa-file"></i><a href="<?php echo URLROOT?>/C_Performance">Player Performance</a></li>
            <li><i class="fa fa-money"></i><a href="<?php echo URLROOT?>/C_Earnings">Earnings</a></li>
            <li><i class="fa fa-thumbs-up"></i><a href="<?php echo URLROOT?>/C_Attendance">Attendance</a></li>
            <li><i class="fa fa-check-circle"></i><a href="<?php echo URLROOT?>/C_Profile">My Profile</a></li>
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

        
        <h3 class="i-name">Sessions</h3>

        <div class="sessions">
            <?php foreach ($data['sessions'] as $session): ?>
                <div onclick="loadMembers('<?php echo $session['session_id']; ?>')" class="session-list">
                    <div class="line"><span class="label">Session ID:</span> <span class="value"><?php echo htmlspecialchars($session['session_id']); ?></span></div>
                    <div><span class="label">Session Name:</span> <span class="value"><?php echo htmlspecialchars($session['session_name']); ?></span></div>
                    <div><span class="label">Session Time:</span> <span class="value"><?php echo htmlspecialchars($session['start_time']); ?> to <?php echo htmlspecialchars($session['end_time']); ?></span></div>
                </div>
            <?php endforeach; ?>
        </div>


        <div id="membersModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>Session Members</h2>
                <div class="members-table">
                    <table class="members">
                        <!-- Members will be loaded here -->
                    </table>
                </div>
            </div>
        </div>


        <script>
            function loadMembers(sessionID) {
                fetch(`<?php echo URLROOT; ?>/C_Performance/getSessionMembers/${sessionID}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not OK: ' + response.statusText);
                    }
                    return response.text(); 
                })
                .then(text => {
                    return JSON.parse(text); 
                })
                .then(data => {                    
                    if (Array.isArray(data)) {
                        const membersHTML = data.map(member => `
                            <tr onclick="navigateToPerformance('${member.userID}')">
                                <td>${member.userID}</td>
                                <td>${member.name}</td>
                            </tr>
                        `).join('');

                        document.querySelector('.members').innerHTML = membersHTML;
                        showModal();
                    } else {
                        console.error('Expected an array, but received:', data);
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            function showModal() {
                document.getElementById('membersModal').style.display = 'block';
            }

            function hideModal() {
                document.getElementById('membersModal').style.display = 'none';
            }

            document.querySelector('.close-button').addEventListener('click', hideModal);

            window.onclick = function(event) {
                let modal = document.getElementById('membersModal');
                if (event.target == modal) {
                    hideModal();
                }
            }


            function navigateToPerformance(memberId) {
                window.location.href = '<?php echo URLROOT; ?>/C_Performance/performanceDashboard/' + memberId;
            }
        </script>


    </section>

    
</body>
</html>
