<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sessions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/admin/sessions.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            background-color: rgba(0,0,0,0.8); 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%; 
            background: #fff;
            border-radius: 8px;
        }

        .modal-content input[type="text"],
        .modal-content input[type="email"],
        .modal-content input[type="time"],
        .modal-content input[type="password"],
        .modal-content textarea[type="text"],
        .modal-content table,
        .modal-content select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #333333;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-content label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
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
        
        .sessionOccurrencesList tr:hover {
            cursor: pointer;
            background-color: #e7e7e7;
        }
    </style>
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
            Session Management
        </h3>


        <button class="addSessionBtn" id="addSessionBtn">Add Session</button>

        <div id="addSessionModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add New Session</h2>
                <form action="<?php echo URLROOT; ?>/A_Sessions/add" method="post">

                    <label for="session_name">Session Name : </label>
                    <input type="text" name="session_name" placeholder="Session Name" required>

                    <label for="day">Session Day : </label>
                    <select name="day">
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>

                    <label for="start_time">Starting Time : </label>
                    <input type="time" name="start_time" placeholder="Start Time" required>

                    <label for="end_time">Ending Time : </label>
                    <input type="time" name="end_time" placeholder="End Time" required>

                    <label for="status">Status : </label>
                    <select name="status">
                        <option value="None">-</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>

                    <button class="btn-save" type="submit" onclick="return confirm('Are you sure you want to add this session?');">Add Session</button>
                </form>
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = document.getElementById("addSessionModal");
                var btn = document.getElementById("addSessionBtn");
                var span = document.getElementsByClassName("close")[0];

                btn.onclick = function() {
                    modal.style.display = "block";
                    btn.style.display = "none"; 
                }

                span.onclick = function() {
                    modal.style.display = "none";
                    btn.style.display = "block"; 
                }

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                        btn.style.display = "block"; 
                    }
                }
            });
        </script>


        <div class="session-list">
            <table width="100%">
                <thead>
                    <tr>
                        <th>Session ID</th>
                        <th>Session</th>
                        <th>Day</th>
                        <th>Session Time</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($data['sessions'] as $session): ?>
                    <tr data-session-id="<?php echo $session['session_id']; ?>">
                        <td class="session_id"><?php echo ($session['session_id']); ?></td>
                        <td class="session_name"><?php echo ($session['session_name']); ?></td>
                        <td class="day"><?php echo ($session['day']); ?></td>
                        <td><div class="start_time"><?php echo ($session['start_time']); ?></div> - <div class="end_time"><?php echo ($session['end_time']); ?></div></td>
                        <td>
                            <button data-session-id="<?php echo $session['session_id']; ?>" class="button-attendance">&#x2705</button>
                        </td>
                        <td>
                            <form action="<?php echo URLROOT; ?>/A_Sessions/SessionDetails/<?php echo $session['session_id']; ?>" method="POST">
                                <button type="submit" class="button-details">&#x1F50D</button>
                            </form>
                        </td>
                        <td class= "edit" >
                            <button type="submit" class="edit-button">&#x270E</button>
                        </td>
                        <td>
                            <form action="<?php echo URLROOT; ?>/A_Sessions/delete/<?php echo $session['session_id']; ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this session?');">
                                <button type="submit" class="button-delete">&#x1F5D1</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    

        <div id="sessionOccurrencesModal" class="modal">
            <div class="modal-content" style="width: 30%">
                <span class="close">&times;</span>
                <h2 style="margin-bottom: 20px">Session Occurrences</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Session ID</th>
                            <th>Session Date</th>
                        </tr>
                    </thead>
                    <tbody id="sessionOccurrencesList" class="sessionOccurrencesList"></tbody>
                </table>
            </div>
        </div>

        <div id="pastAttendanceModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Past Attendance</h2>
                <div id="pastAttendanceContent">
                    <div id="membersSection" class="attendance-section" style="margin-top: 10px">
                        <h3>Members</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Attended</th>
                                    <th>Absent</th>
                                </tr>
                            </thead>
                            <tbody id="membersAttendance"></tbody>
                        </table>
                    </div>
                    <div id="coachesSection" class="attendance-section" style="margin-top: 20px">
                        <h3>Coaches</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Attended</th>
                                    <th>Absent</th>
                                </tr>
                            </thead>
                            <tbody id="coachesAttendance"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div id="todayAttendanceModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Mark Today's Attendance</h2>
                <form id="todayAttendanceForm" onsubmit="submitAttendance(); return false;"></form>
            </div>
        </div>



        <script>
            document.querySelectorAll('.button-attendance').forEach(button => {
                button.addEventListener('click', function() {
                    const sessionId = this.getAttribute('data-session-id');
                    console.log(sessionId);
                    fetchOccurrences(sessionId);
                });
            });

            function fetchOccurrences(sessionId) {
                fetch(`<?php echo URLROOT; ?>/A_Attendance/getOccurrences/${sessionId}`)
                .then(response => response.json())
                .then(occurrences => {
                    console.log("Received occurrences:", occurrences); 
                    
                    if (!Array.isArray(occurrences)) {
                        console.error('Expected an array but received:', occurrences);
                        return; 
                    }

                    const list = document.getElementById('sessionOccurrencesList');
                    list.innerHTML = ''; 
                    occurrences.forEach(occurrence => {
                        const row = document.createElement('tr');  
                        const sessionIdCell = document.createElement('td');
                        sessionIdCell.textContent = occurrence.session_id;
                        row.appendChild(sessionIdCell);

                        const dateCell = document.createElement('td');
                        dateCell.textContent = occurrence.session_date;
                        row.appendChild(dateCell);

                        row.addEventListener('click', () => handleOccurrenceClick(occurrence));

                        list.appendChild(row);  
                    });
                    showModal('sessionOccurrencesModal');
                })
                .catch(error => {
                    console.error('Error loading occurrences:', error);
                });
            }

            function handleOccurrenceClick(occurrence) {
                const today = new Date().toISOString().slice(0, 10);
                console.log(today);
                console.log(occurrence.session_date);
                if (occurrence.session_date < today) {
                    fetchPastAttendance(occurrence.session_id, occurrence.session_date);
                } else if (occurrence.session_date === today) {
                    fetchTodayAttendance(occurrence.session_id);
                } else {
                    alert('SESSION YET TO COME');
                }
            }

            function fetchPastAttendance(sessionId, date) {
                fetch(`<?php echo URLROOT; ?>/A_Attendance/getPastAttendance/${sessionId}/${date}`)
                .then(response => {
                    const contentType = response.headers.get("content-type");
                    if (contentType && contentType.includes("application/json")) {
                        return response.json();
                    } else {
                        response.text().then(text => {
                            console.log('Unexpected response:', text);
                            alert('Attendance Not Recorded');
                        });
                        throw new TypeError("Oops, we haven't got JSON! The response is: " + contentType);
                    }
                })
                .then(attendanceData => {
                    console.log(attendanceData);
                    if (attendanceData == null) {
                        alert('Attendance is not recorded');
                    } else {
                        displayPastAttendance(attendanceData);
                    }
                })
                .catch(error => {
                    console.error('Error fetching past attendance:', error);
                    alert('Failed to fetch past attendance data.');
                });
            }

            function displayPastAttendance(attendanceData) {
                const membersTable = document.getElementById('membersAttendance');
                const coachesTable = document.getElementById('coachesAttendance');
                let membersRows = '';
                let coachesRows = '';
                let hasMembers = false;
                let hasCoaches = false;

                attendanceData.forEach(entry => {
                    const row = `<tr>
                                    <td>${entry.name}</td>
                                    <td>${entry.attendance_status === "Present" ? '<input type="checkbox" checked disabled>' : '<input type="checkbox" disabled>'}</td>
                                    <td>${entry.attendance_status === "Absent" ? '<input type="checkbox" checked disabled>' : '<input type="checkbox" disabled>'}</td>
                                </tr>`;
                    if (entry.type === 'member') {
                        membersRows += row;
                        hasMembers = true;
                    } else {
                        coachesRows += row;
                        hasCoaches = true;
                    }
                });

                membersTable.innerHTML = membersRows;
                coachesTable.innerHTML = coachesRows;
                document.getElementById('membersSection').style.display = hasMembers ? 'block' : 'none';
                document.getElementById('coachesSection').style.display = hasCoaches ? 'block' : 'none';

                if (hasMembers || hasCoaches) {
                    showModal('pastAttendanceModal');
                } else {
                    alert('No attendance data available.');
                }
            }



            function fetchTodayAttendance(sessionId) {
                fetch(`<?php echo URLROOT; ?>/A_Attendance/getTodayAttendanceForm/${sessionId}`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('todayAttendanceForm').innerHTML = html; 
                        showModal('todayAttendanceModal'); 
                    })
                    .catch(error => console.error('Error fetching today\'s attendance form:', error));
            }


            

            function submitAttendance() {
                const form = document.getElementById('todayAttendanceForm');
                const formData = new FormData(form);

                fetch(`<?= URLROOT; ?>/A_Attendance/markAttendanceToday`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Attendance marked successfully!');
                        closeModal('todayAttendanceModal');
                    } else {
                        alert('Failed to mark attendance: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error marking attendance:', error);
                    alert('Error marking attendance: ' + error.message);
                });
            }



            function showModal(id) {
                const modal = document.getElementById(id);
                modal.style.display = 'block';
                document.querySelector(`#${id} .close`).onclick = function() {
                    modal.style.display = 'none';
                }
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = 'none';
                    }
                }
            }

            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                if (!modal) {
                    console.error('Modal not found: ', modalId);
                    return;
                }

                modal.style.display = 'none';

                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                }

                const errorMessages = modal.querySelectorAll('.error-message');
                errorMessages.forEach(msg => msg.textContent = '');

                const dynamicContent = modal.querySelectorAll('.dynamic-content');
                dynamicContent.forEach(content => content.innerHTML = '');
            }
        </script>



        <div class="modal" id="update-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2 class="i3-name">Update Session</h2>
                </div>

                <div class="modal-body">

                    <?php if (isset($session) && $session): ?>  
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Session Name:</label>
                                <input type="text" name="session_name" value="<?php echo htmlspecialchars($session['session_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Day:</label>
                                <select name="day">
                                    <?php
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                    foreach ($days as $day) {
                                        $selected = ($session['day'] === $day) ? 'selected' : '';
                                        echo "<option value='$day' $selected>$day</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Start Time:</label>
                                <input type="time" name="start_time" value="<?php echo htmlspecialchars($session['start_time']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>End Time:</label>
                                <input type="time" name="end_time" value="<?php echo htmlspecialchars($session['end_time']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Status:</label>
                                <select name="status">
                                    <option value="Active" <?php echo ($session['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="Inactive" <?php echo ($session['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                            <button class="btn-save" type="submit">Update Session</button>
                        </form>
                    <?php else: ?>
                        <p>Session not found.</p>
                    <?php endif; ?>

            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.edit').on('click', function() {
                    var tableRow = $(this).closest('tr');
                    var sessionId = tableRow.data('session-id');  
                    var sessionName = tableRow.find('.session_name').text();
                    var sessionDay = tableRow.find('.day').text();
                    var startTime = tableRow.find('.start_time').text();
                    var endTime = tableRow.find('.end_time').text();
                    var status = tableRow.find('.status').text();
                    console.log(sessionId, sessionName, sessionDay);
                    var formAction = `<?php echo URLROOT; ?>/A_Sessions/update/${sessionId}`;
                    $('#update-modal form').attr('action', formAction);

                    $('#update-modal [name="session_name"]').val(sessionName);
                    $('#update-modal [name="day"]').find(`option[value="${sessionDay}"]`).prop('selected', true);
                    $('#update-modal [name="start_time"]').val(startTime);
                    $('#update-modal [name="end_time"]').val(endTime);
                    $('#update-modal [name="status"]').find(`option[value="${status}"]`).prop('selected', true);

                    $('#update-modal').show();
                });

                $('.close, .modal-close').on('click', function() {
                    $(this).closest('.modal').hide();
                });
            });

            $('#update-modal form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#update-modal').hide();
                        alert('Session updated successfully');
                        window.location.reload();
                    },
                    error: function() {
                        alert('Error updating session');
                    }
                });
            });
        </script>

    </section>

</body>
</html>