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

    <link rel="stylesheet" href="<?php echo URLROOT?>/css/member/performance.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
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
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0,0.4); 
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            z-index: 1;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; /* 10% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Could be more or less, depending on screen size */
        }

        .close-performanceNotesButton { 
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-performanceNotesButton:hover,
        .close-performanceNotesButton:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .grahp-1 {
            margin-left: 200px;
            margin-right: 200px;

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

        
        <h3 class="i-name">Statistics</h3>


        <div class="graph-1">
            <button class="previous-btn" onclick="previousStat()"><</button>
            <canvas id="statsChart" style=""></canvas>
            <button class="next-btn" onclick="nextStat()">></button>
        </div>

        <script>
            let currentStatIndex = 0;
            const stats = ['runs', 'wickets', 'catches', 'run_outs', 'stumpings']; 
            let chart;

            function fetchData(stat) {
                const url = `<?php echo URLROOT; ?>/M_Performance/getStatData/${stat}`;

                $.ajax({
                    url: url,
                    type: 'GET',  // or 'POST' if the server expects a POST request
                    dataType: 'json',  // expecting JSON data in response
                    success: function(data) {
                        console.log(data);
                        updateChart(data, stat);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Failed to fetch data:', textStatus, errorThrown);
                        console.error('Server response:', jqXHR.responseText);  // This will show you the raw response content
                    }
                });
            }


            function updateChart(data, stat) {
                const labels = data.map(item => `${item.month}`);
                const values = data.map(item => item.total);

                if (chart) chart.destroy(); // Destroy the previous chart

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
            <table width="100%" style="margin-bottom: 10px">
                <thead>
                    <th>Match</th>
                    <th>Date</th>
                    <th>Runs</th>
                    <th>Wickets</th>
                    <th>Catches</th>
                    <th>Run Outs</th>
                    <th>Stumpings</th>
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
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <h3 class="i-name">Skill Evaluation</h3>

        <div class="performance" style="margin-bottom: 20px">
            <table width="100%" style="margin-bottom: 10px">
                <thead>
                    <th>Date</th>
                    <th>Batting (0-10)</th>
                    <th>Bowling (0-10)</th>
                    <th>Fielding (0-10)</th>
                    <th>Fitness (0-10)</th>
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



    </section>
    
</body>
</html>