<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/admin/resourcemanage.css">
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

    </style>
</head>


<body>
    <section id="menu">
        <div class="logo">
            <img src="<?php echo URLROOT?>/images/logo.png" alt="">
            <!-- <h2>ATHLETE' 360</h2> -->
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
            Equipment Management
        </h3>

        <h3 class="topic">Available Equipment</h3>
        <div class="equipment-list">
            <table width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Availability</th>
                        <th>Last Maintained</th>
                        <th>Price for Hiring</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($data['availableEquipments'] as $equipment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($equipment['id']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['name']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['availability']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['last_maintained_date']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['price_for_hiring']); ?></td>
                        
                        <td style="padding-top: 0; padding-bottom: 0"><button data-equipment-id="<?php echo $equipment['id']; ?>" class="set-to-maintaining-btn" onclick="return confirm('Are you sure you want to set this equipment to maintainance?');">&#x1F527;</button></td>
                        <td style="padding-top: 0; padding-bottom: 0"><a href="<?php echo URLROOT; ?>/A_EquipmentManage/delete/<?php echo $equipment['id']; ?>" onclick="return confirm('Are you sure you want to delete this equipment?');" class="delete-btn">&#x1F5D1;</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>




        <button id="addEquipmentBtn" class="addEquipmentBtn">Add New Equipment</button>

        <!-- The Modal -->
        <div id="addEquipmentModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add New Equipment</h2>
                <form action="<?php echo URLROOT; ?>/A_EquipmentManage/add" method="post">
                    <label for="name">Equipment Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="availability">Availability:</label>
                    <select name="availability" id="availability">
                        <option value="Available">Available</option>
                        <option value="Unavailable">Unavailable</option>
                    </select>

                    <label for="price_for_hiring">Price for Hiring:</label>
                    <input type="number" id="price_for_hiring" name="price_for_hiring" required>

                    <button type="submit" class="btn-save">Add Equipment</button>
                </form>
            </div>
        </div>


        <script>
            document.getElementById('addEquipmentBtn').addEventListener('click', function() {
                document.getElementById('addEquipmentModal').style.display = 'block';
                this.style.display = 'none'; 
            });

            var closeSpan = document.getElementsByClassName("close")[0];

            closeSpan.onclick = function() {
                document.getElementById('addEquipmentModal').style.display = 'none';
                document.getElementById('addEquipmentBtn').style.display = 'block'; 
            }

            window.onclick = function(event) {
                var modal = document.getElementById('addEquipmentModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                    document.getElementById('addEquipmentBtn').style.display = 'block'; 
                }
            }

        </script>




        <h3 class="topic">Allocated Sessions</h3>
        <div class="session-equipment-list">
            <table width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Sessions</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($data['availableEquipments'] as $equipment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($equipment['id']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['name']); ?></td>
                        <td>
                            <?php if (!empty($equipment['sessions'])): ?>
                                <div>
                                    <?php foreach ($equipment['sessions'] as $session): ?>
                                        <p>
                                            <?php echo htmlspecialchars($session['session_name']) . ' - ' . 
                                                htmlspecialchars($session['day']) . ' from ' . 
                                                htmlspecialchars($session['start_time']) . ' to ' . 
                                                htmlspecialchars($session['end_time']); ?>
                                        </p>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                            <p>No sessions allocated</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>        


        


        <div id="equipmentDetailsModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Equipment Details</h2>
                <div id="equipmentDetailsContent"></div>
                <form id="addSessionForm">
                    <input type="hidden" name="id" id="equipmentIdInput">
                    <label for="sessionDropdown">Choose a Session:</label>
                    <select id="sessionDropdown" name="session_id"></select>
                    <button type="submit" id="addSessionButton">Add Session</button>
                </form>
            </div>
        </div>



        <script>
            document.querySelectorAll('.session-equipment-list tr').forEach(row => {
                row.addEventListener('click', function() {
                    const equipmentId = this.cells[0].textContent.trim();
                    fetch(`<?php echo URLROOT; ?>/A_EquipmentManage/getEquipmentDetails/${equipmentId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        const modalContent = document.getElementById('equipmentDetailsContent');
                        modalContent.innerHTML = `<p>Name: ${data.equipment.name}</p>
                                                <p>Availability: ${data.equipment.availability}</p>
                                                <p>Last Maintained: ${data.equipment.last_maintained_date}</p>
                                                <h3>Sessions:</h3>`;
                        data.sessions.forEach(session => {
                            modalContent.innerHTML += `<div><span class="s-details">${session.session_id} - ${session.session_name}</span> 
                                                        <button onclick="removeSessionFromEquipment(${data.equipment.id}, ${session.session_id})">Remove</button></div>`;
                        });
                        return fetch(`<?php echo URLROOT; ?>/A_EquipmentManage/getAllSessions`);
                    })
                    .then(response => {
                        console.log(response);
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Sessions Data:", data);
                        const sessions = data.sessions; 
                        const sessionDropdown = document.getElementById('sessionDropdown');
                        sessionDropdown.innerHTML = '';
                        console.log(sessions)

                        if (Array.isArray(sessions)) {
                            sessions.forEach(session => {
                                const option = document.createElement('option');
                                option.value = session.session_id;
                                option.textContent = `${session.session_name} - ${session.day} - ${session.start_time} to ${session.end_time}`;
                                sessionDropdown.appendChild(option);
                            });
                        } else {
                            console.error('Expected an array for sessions, but received:', sessions);
                        }
                    })
                    .catch(error => console.error('Error loading data:', error));

                    document.getElementById('equipmentDetailsModal').style.display = 'block';
                });
            });


            document.getElementById('addSessionForm').addEventListener('submit', function(event) {
                event.preventDefault(); 

                const equipmentId = this.cells[0].textContent.trim();
                console.log(equipmentId);
                const sessionId = document.getElementById('sessionDropdown').value;
                console.log(sessionId);

                fetch(`<?php echo URLROOT; ?>/A_EquipmentManage/addSessionToEquipment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'  
                    },
                    body: JSON.stringify({ equipmentId: equipmentId, sessionId: sessionId })
                })
                .then(response => console.log(response))
                .then(data => {
                    if (data.success) {
                        alert('Session successfully added to equipment.');
                    } else {
                        alert('Failed to add session. ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error adding session to equipment:', error);
                    alert('Error adding session to equipment.');
                });
            });

 

            

            var closeSpan = document.getElementsByClassName("close")[1]; // Change index as per your existing close buttons
            closeSpan.onclick = function() {
                document.getElementById('equipmentDetailsModal').style.display = 'none';
            }
            window.onclick = function(event) {
                var modal = document.getElementById('equipmentDetailsModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }

            function removeSessionFromEquipment(equipmentId, sessionId) {
                fetch(` <?php echo URLROOT; ?>/A_EquipmentManage/deleteEquipmentSession/${equipmentId}/${sessionId}`, {
                    method: 'POST'
                })
                .then(response => {
                    if (response.ok) {
                        alert('Session removed successfully.');
                        window.location.reload();
                    } else {
                        throw new Error('Failed to remove session');
                    }
                })
                .catch(error => {
                    console.error('Error removing session:', error);
                    alert('Error removing session.');
                });
            }
        </script>








        
        

        <h3 class="topic">Equipment Under Maintenance</h3>
        <div class="maintaining-equipment-list">
            <table width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Availability</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['maintainingEquipments'] as $equipment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($equipment['id']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['name']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['availability']); ?></td>
                        <td><button data-equipment-id="<?php echo $equipment['id']; ?>" class="done-maintaining-btn" onclick="return confirm('Are you sure this equipment is done maintaining?');">&#x2190; Done Maintaining</button></td>
                        <td><a href="<?php echo URLROOT; ?>/A_EquipmentManage/delete/<?php echo $equipment['id']; ?>" onclick="return confirm('Are you sure you want to delete this equipment?');" class="delete-btn">&#x1F5D1;</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>



    </section>

    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlRoot = "<?php echo URLROOT; ?>"; 

            document.querySelectorAll('.set-to-maintaining-btn, .done-maintaining-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const equipmentId = this.dataset.equipmentId; 
                    const action = this.classList.contains('set-to-maintaining-btn') ? 'setToMaintaining' : 'doneMaintaining';
                    equipmentAction(equipmentId, action);
                });
            });

            function equipmentAction(equipmentId, action) {
                fetch(`<?php echo URLROOT; ?>/A_EquipmentManage/${action}/${equipmentId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    window.location.reload();
                })
                .catch(error => {
                    console.log(error);
                    alert("Error updating equipment status.");
                });
            }
        });
    </script>

    
</body>
</html>