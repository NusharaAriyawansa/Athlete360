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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #addPerformanceForm, #addMatchStatForm {
            display: none;
            background: #f4f4f4;
            padding: 20px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
        }
        input[type="number"], input[type="date"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        button {
            background-color: #6a0602;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 30px;
            cursor: pointer;
            border-radius: 5px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }


        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            left: 0;
            top: 0;
            z-index: 1; 
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; /* 10% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Could be more or less, depending on screen size */
        }

        .close-addMatchStatBtn, .close-addPerformanceBtn, .close-performanceNotesButton {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .grahp-1 {
            margin-left: 200px;
            margin-right: 200px;

        }

        



    .video-carousel { display: flex; align-items: center; }
    .video-wrapper { overflow-x: scroll; display: flex; }
    .video { flex: 0 0 auto; width: 300px; height: 300px; margin-right: 10px; position: relative; }
    .video button { position: absolute; top: 10px; right: 10px; }
    iframe { width: 100%; height: 100%; }

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

        
        <h3 class="i-name">Statistics</h3>
            

        <div class="graph-1">
            <button class="previous-btn" onclick="previousStat()"><</button>
            <canvas id="statsChart" style=""></canvas>
            <button class="next-btn"onclick="nextStat()">></button>
        </div>
    

        <script>
            let currentStatIndex = 0;
            const stats = ['runs', 'wickets', 'catches', 'run_outs', 'stumpings']; 
            let chart;

            function fetchData(stat) {
                const playerId = window.location.pathname.split('/')[5];
                const url = `<?php echo URLROOT; ?>/C_Performance/getStatData/${playerId}/${stat}`;

                $.ajax({
                    url: url,
                    type: 'GET',  
                    dataType: 'json',  
                    success: function(data) {
                        console.log(data);
                        updateChart(data, stat);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Failed to fetch data:', textStatus, errorThrown);
                        console.error('Server response:', jqXHR.responseText);  
                    }
                });
            }


            function updateChart(data, stat) {
                const labels = data.map(item => `${item.month}`);
                const values = data.map(item => item.total);

                if (chart) chart.destroy();

                chart = new Chart(document.getElementById('statsChart'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: `Total ${stat} per Month`,
                            data: values,
                            backgroundColor: '#7d0501',
                            borderColor: '#7d0501',
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            function nextStat() {
                currentStatIndex = (currentStatIndex + 1) % stats.length;
                fetchData(stats[currentStatIndex]);
            }

            function previousStat() {
                currentStatIndex = (currentStatIndex - 1 + stats.length) % stats.length;
                fetchData(stats[currentStatIndex]);
            }


            // Initialize with the first stat
            document.addEventListener('DOMContentLoaded', function() {
                fetchData(stats[currentStatIndex]);
            });
        </script>



        <div class="performance">
            <table width="80%">
                <thead>
                    <th>Match</th>
                    <th>Date</th>
                    <th>Runs</th>
                    <th>Wickets</th>
                    <th>Catches</th>
                    <th>Run Outs</th>
                    <th>Stumpings</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach ($data['matchStats'] as $stat): ?>
                    <tr>
                        <td><?php echo ($stat['match_name']); ?></td>
                        <td><?php echo ($stat['date']); ?></td>
                        <td><?php echo htmlspecialchars($stat['runs'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($stat['wickets'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($stat['catches'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($stat['run_outs'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($stat['stumpings'] ?? '-'); ?></td>
                        <td><a href="<?php echo URLROOT; ?>/C_Performance/deleteMatchStat/<?php echo $stat['id']; ?>/<?php echo $stat['player_id']; ?>" onclick="return confirm('Are you sure you want to delete this entry?');" class="delete-btn">&#x1F5D1</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <button id="addMatchStatBtn">Add Match Statistic</button>

        <div id="addMatchStatModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close-addMatchStatBtn">&times;</span>
                <h1>Add Match Statistic</h1>
                <form action="<?php echo URLROOT; ?>/C_Performance/addMatchStat" method="post">
                    <input type="hidden" name="player_id" value="<?php echo $stat['player_id']; ?>">
                    <table>
                        <tr>
                            <td><label for="match_name">Match Name:</label></td>
                            <td><input type="text" id="match_name" name="match_name" required></td>
                        </tr>
                        <tr>
                            <td><label for="date">Date:</label></td>
                            <td><input type="date" id="date" name="date" required></td>
                        </tr>
                        <tr>
                            <td><label for="runs">Runs:</label></td>
                            <td><input type="number" id="runs" name="runs"></td>
                        </tr>
                        <tr>
                            <td><label for="wickets">Wickets:</label></td>
                            <td><input type="number" id="wickets" name="wickets"></td>
                        </tr>
                        <tr>
                            <td><label for="catches">Catches:</label></td>
                            <td><input type="number" id="catches" name="catches"></td>
                        </tr>
                        <tr>
                            <td><label for="run_outs">Run Outs:</label></td>
                            <td><input type="number" id="run_outs" name="run_outs"></td>
                        </tr>
                        <tr>
                            <td><label for="stumpings">Stumpings:</label></td>
                            <td><input type="number" id="stumpings" name="stumpings"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><button type="submit">Save</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('addMatchStatBtn').onclick = function() {
                var modal = document.getElementById('addMatchStatModal');
                modal.style.display = 'block';
                this.style.display = 'none'; // Hide the add button
            };

            document.getElementsByClassName('close-addMatchStatBtn')[0].onclick = function() {
                var modal = document.getElementById('addMatchStatModal');
                modal.style.display = 'none';
                document.getElementById('addMatchStatBtn').style.display = 'block'; // Show the add button again
            };

            window.onclick = function(event) {
                var modal = document.getElementById('addMatchStatModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                    document.getElementById('addMatchStatBtn').style.display = 'block'; // Show the add button again
                }
            };

        </script>



        <h3 class="i-name">Skill Evaluation</h3>

        <div class="performance">
            <table width="100%">
                <thead style="z-index: 0; position: relative;">
                    <th>Date</th>
                    <th>Batting (0-10)</th>
                    <th>Bowling (0-10)</th>
                    <th>Fielding (0-10)</th>
                    <th>Fitness (0-10)</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach ($data['performances'] as $performance): ?>
                    <tr style="cursor: pointer" onclick="showDetails(this);">
                        <td><?php echo date('Y-m-d', strtotime($performance['date'])); ?></td>
                        <td><?php echo ($performance['batting'] ?? ''); ?>
                            <span style="display:none;"><?php echo htmlspecialchars($performance['batting_notes' ?? '-']); ?></span>
                            <div class="note-preview" style="color: #787d8d; font-size: small;"><?php echo substr(htmlspecialchars($performance['batting_notes']), 0, 12) . '...'; ?></div>
                        </td>
                        <td><?php echo ($performance['bowling'] ?? ''); ?>
                        <span style="display:none;"><?php echo htmlspecialchars($performance['bowling_notes' ?? '-']); ?></span>

                            <div class="note-preview" style="color: #787d8d; font-size: small;"><?php echo substr(htmlspecialchars($performance['bowling_notes']), 0, 12) . '...'; ?></div>
                        </td>
                        <td><?php echo ($performance['fielding'] ?? ''); ?>
                        <span style="display:none;"><?php echo htmlspecialchars($performance['bowling_notes' ?? '-']); ?></span>

                            <div class="note-preview" style="color: #787d8d; font-size: small;"><?php echo substr(htmlspecialchars($performance['fielding_notes']), 0, 12) . '...'; ?></div>
                        </td>
                        <td><?php echo ($performance['fitness'] ?? ''); ?>
                        <span style="display:none;"><?php echo htmlspecialchars($performance['bowling_notes' ?? '-']); ?></span>

                            <div class="note-preview" style="color: #787d8d; font-size: small;"><?php echo substr(htmlspecialchars($performance['fitness_notes']), 0, 12) . '...'; ?></div>
                        </td>
                        <td>
                            <a href="<?php echo URLROOT; ?>/C_Performance/deletePerformance/<?php echo $performance['id']; ?>/<?php echo $performance['player_id']; ?>" onclick="return confirm('Are you sure you want to delete this performance?');" class="delete-btn">&#x1F5D1</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close-performanceNotesButton">&times;</span>
            <p id="modal-content"></p>
        </div>
        </div>

        <script>
            function showDetails(row) {
                var modal = document.getElementById('myModal');
                var content = document.getElementById('modal-content');
                var spans = row.getElementsByTagName('span'); // Assuming the full notes are stored in these spans

                content.innerHTML = '<h2>Performance Details</h2>' + '<br>' +
                    '<strong>Date: </strong> ' + row.cells[0].textContent + '<br>' + '<br>' +
                    '<strong>Batting Notes: </strong> ' + spans[0].textContent + '<br>' + '<br>' +
                    '<strong>Bowling Notes: </strong> ' + spans[1].textContent + '<br>' + '<br>' +
                    '<strong>Fielding Notes: </strong> ' + spans[2].textContent + '<br>' + '<br>' +
                    '<strong>Fitness Notes: </strong> ' + spans[3].textContent;

                modal.style.display = "block";
                modal.querySelector('.close-performanceNotesButton').onclick = function() {
                    modal.style.display = "none";
                };
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                };
            }
        </script>




        <button id="addPerformanceBtn">Add Player Performance</button>
        <div id="addPerformanceModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close-addPerformanceBtn">&times;</span>
                <h1>New Evaluation</h1>
                <form action="<?php echo URLROOT; ?>/C_Performance/addPerformance/" method="post">
                    <input type="hidden" name="player_id" value="<?php echo $performance['player_id']; ?>">
                        <table>
                        <tr>
                            <td><label for="date">Date:</label><input type="date" id="date" name="date" required></td>
                        </tr>
                        <tr>
                            <td><label for="batting">Batting (0-10):</label><input type="number" id="batting" name="batting" min="0" max="10" required></td>
                        </tr>
                        <tr>
                            <td><label for="batting_notes">Batting Notes:</label><textarea id="batting_notes" name="batting_notes"></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="bowling">Bowling (0-10):</label><input type="number" id="bowling" name="bowling" min="0" max="10" required></td>
                        </tr>
                        <tr>
                            <td><label for="bowling_notes">Bowling Notes:</label><textarea id="bowling_notes" name="bowling_notes"></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="fielding">Fielding (0-10):</label><input type="number" id="fielding" name="fielding" min="0" max="10" required></td>
                        </tr>
                        <tr>
                            <td><label for="fielding_notes">Fielding Notes:</label><textarea id="fielding_notes" name="fielding_notes"></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="fitness">Fitness (0-10):</label><input type="number" id="fitness" name="fitness" min="0" max="10" required></td>
                        </tr>
                        <tr>
                            <td><label for="fitness_notes">Fitness Notes:</label><textarea id="fitness_notes" name="fitness_notes"></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="additional_notes">Additional Notes:</label><textarea id="additional_notes" name="additional_notes"></textarea></td>
                        </tr>
                        <tr>
                            <td><button type="submit" name="save" value="save">Submit Performance</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>






        <div class="video-carousel">
            <?php if (count($data['videos']) > 0): ?>
                <button class="carousel-control left" onclick="scroll(-1)">&#10094;</button>
            <?php endif; ?>
            <div class="video-wrapper">
                <?php foreach ($data['videos'] as $video): ?>
                    <div class="video">
                        <iframe src="https://www.youtube.com/embed/<?= substr($video['video_url'], -11) ?>" frameborder="0" allowfullscreen></iframe>
                        <button onclick="deleteVideo(<?= $video['id'] ?>)">Delete</button>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($data['videos'])): ?>
                    <p style="margin: 4vb; padding-top: 3vb;">No videos available.</p>
                <?php endif; ?>
            </div>
            <?php if (count($data['videos']) > 0): ?>
                <button class="carousel-control right" onclick="scroll(1)">&#10095;</button>
            <?php endif; ?>
        </div>
        <button id="addVideoBtn" onclick="showAddVideoModal()">Add Video</button>

        <script>
            function deleteVideo(videoId) {
                if (confirm('Are you sure you want to delete this video?')) {
                    window.location.href = '/performance/deleteVideo/' + videoId;
                }
            }

            function scroll(direction) {
                let scrollAmount = 0;
                const container = document.querySelector('.video-wrapper');
                const scrollTimer = setInterval(function() {
                    container.scrollLeft += direction * 10;
                    scrollAmount += 10;
                    if(scrollAmount >= 300) {
                        clearInterval(scrollTimer);
                    }
                }, 25);
            }

            function showAddVideoModal() {
                document.getElementById('addVideoModal').style.display = 'block';
            }

            // Improved YouTube URL validation
            function validateYouTubeUrl(urlToParse) {
                try {
                    let url = new URL(urlToParse);
                    let v = url.searchParams.get("v");
                    if (!v) {
                        // Handling YouTube short URLs and embeds
                        if (url.hostname === "youtu.be") {
                            v = url.pathname.substring(1);
                        } else if (url.pathname.includes('/embed/')) {
                            v = url.pathname.split('/').pop();
                        }
                    }
                    return v ? v : null;
                } catch (error) {
                    console.error("Error parsing URL", error);
                    return null;
                }
            }
            document.addEventListener('DOMContentLoaded', function () {
                const videoForm = document.getElementById('addVideoForm');
                if (videoForm) {
                    videoForm.onsubmit = async function(event) {
                        event.preventDefault();
                        const videoUrlInput = document.getElementById('videoUrl');
                        const videoId = validateYouTubeUrl(videoUrlInput.value);
                        const playerId = window.location.pathname.split('/')[5];

                        if (videoId) {
                            try {
                                const response = await fetch('<?php echo URLROOT; ?>/C_Performance/addVideo', {
                                    method: 'POST',
                                    headers: {'Content-Type': 'application/json'},
                                    body: JSON.stringify({videoUrl: videoId, playerId: playerId})
                                });
                                const result = await response.json();
                                console.log(result);

                                if (response.ok) {
                                    closeModal();
                                    alert('Video added successfully');
                                } else {
                                    alert(result.message);
                                }
                            } catch (error) {
                                alert('Failed to add the video. Error: ' + error.message);
                            }
                        } else {
                            alert('Please enter a valid YouTube URL.');
                        }
                    };
                } else {
                    console.error('The form element was not found.');
                }
            });




        </script>

        <div id="addVideoModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <form id="addVideoForm">
                    <label for="videoUrl">Video URL:</label>
                    <input type="text" id="videoUrl" name="videoUrl" required>
                    <button type="submit">Add Video</button>
                </form>
            </div>
        </div>


        <script>
            function closeModal() {
                document.getElementById('addVideoModal').style.display = 'none';
            }

            window.onclick = function(event) {
                var modal = document.getElementById('addVideoModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        </script>












        <script>
           document.getElementById('addPerformanceBtn').onclick = function() {
                var modal = document.getElementById('addPerformanceModal');
                modal.style.display = 'block';
                this.style.display = 'none'; // Hide the add button
            };

            document.getElementsByClassName('close-addPerformanceBtn')[0].onclick = function() {
                var modal = document.getElementById('addPerformanceModal');
                modal.style.display = 'none';
                document.getElementById('addPerformanceBtn').style.display = 'block'; // Show the add button again
            };

            window.onclick = function(event) {
                var modal = document.getElementById('addPerformanceModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                    document.getElementById('addPerformanceBtn').style.display = 'block'; // Show the add button again
                }
            };
        </script>

        <h3 class="i-name">Additional Notes</h3>
        
        <div class="notes">
            <table>
                <tbody>
                    <?php foreach ($data['performances'] as $performance): ?>
                        <?php if (!empty($performance['additional_notes'])): ?>
                            <tr height='10px'>
                                <td class='note_date' width='160px'><?php echo date('Y-m-d', strtotime($performance['date'])); ?></td>
                                <td><?php echo ($performance['additional_notes']); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </section>
    
</body>
</html['