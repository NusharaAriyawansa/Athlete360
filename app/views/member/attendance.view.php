<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <link rel="stylesheet" href="<?php echo URLROOT?>/css/coach/attendance.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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

        <h3 class="i-name">Attendance</h3>

        <div class="graphs">
            <div class="pie-chart">
                <h3 class="topic">Monthly Attendance</h3>
                <div class="graph-1">
                    <button id="prevMonth"><</button>
                    <canvas id="monthlyAttendanceChart"></canvas>
                    <button id="nextMonth">></button>
                </div>
                <div id="chartMonthLabel" class="chart-label"></div>
            </div>

            <div class="line-chart">
                <h3 class="topic">Session Attendance</h3>
                <div class="graph-2">
                    <canvas id="sessionAttendanceChart"></canvas>
                </div>
            </div>
        </div>



        <div class="attendance-tables">
            <h3 class="topic">Attendance (Present)</h3>
            <div class="present-table">
                <table width=100%>
                    <thead>
                        <tr>
                            <th>Session ID</th>
                            <th>Session Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['presentAttendance'] as $attendance): ?>
                            <tr>
                                <td><?= htmlspecialchars($attendance['session_id']) ?></td>
                                <td><?= htmlspecialchars($attendance['session_name']) ?></td>
                                <td><?= htmlspecialchars($attendance['attendance_date']) ?></td>
                                <td><?= htmlspecialchars($attendance['attendance_status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <h3 class="topic">Attendance (Absent)</h3>
            <div class="absent-table">
                <table width=100%>
                    <thead>
                        <tr>
                            <th>Session ID</th>
                            <th>Session Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['absentAttendance'] as $attendance): ?>
                            <tr>
                                <td><?= htmlspecialchars($attendance['session_id']) ?></td>
                                <td><?= htmlspecialchars($attendance['session_name']) ?></td>
                                <td><?= htmlspecialchars($attendance['attendance_date']) ?></td>
                                <td><?= htmlspecialchars($attendance['attendance_status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    
    </section>
    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const url = '<?php echo URLROOT; ?>/M_Attendance/getMonthlyAttendanceData';
            fetch(url)
            .then(response => {
                console.log(response);
                if (!response.ok) {
                    throw new Error('Network response was not OK: ' + response.statusText);
                }
                return response.text(); 
            })
            .then(text => {
                console.log("Received text:", text);
                return JSON.parse(text); 
            })
            .then(data => {
                console.log("Parsed data received:", data); 
                if (!data || typeof data !== 'object') {
                    console.error('Received data is not an object or is undefined', data);
                    return;
                }

                const firstMonthData = Object.values(data)[0]; 

                const ctx = document.getElementById('monthlyAttendanceChart').getContext('2d');
                const attendanceChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Present', 'Absent'],
                        datasets: [{
                            label: 'Attendance Status',
                            data: [firstMonthData.Present, firstMonthData.Absent],
                            backgroundColor: ['green', 'red'],
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        }
                    }
                });

                let currentMonthIndex = 0;
                let monthKeys = Object.keys(data); 
                document.getElementById('prevMonth').addEventListener('click', function () {
                    if (currentMonthIndex < monthKeys.length - 1) {
                        currentMonthIndex++;
                        const monthData = data[monthKeys[currentMonthIndex]];
                        const monthName = new Date(monthKeys[currentMonthIndex] + '-01').toLocaleString('default', { month: 'long', year: 'numeric' });
                        updateChartData(attendanceChart, monthData, monthName);
                    }
                });
                document.getElementById('nextMonth').addEventListener('click', function () {
                    if (currentMonthIndex > 0) {
                        currentMonthIndex--;
                        const monthData = data[monthKeys[currentMonthIndex]];
                        updateChartData(attendanceChart, monthData);
                    }
                });

                function updateChartData(chart, newData) {
                    chart.data.datasets[0].data = [newData.Present, newData.Absent];
                    chart.update();
                }
            })
            .catch(error => console.error('Error loading the data:', error));
        });




        document.addEventListener('DOMContentLoaded', function() {
            const url = '<?php echo URLROOT; ?>/M_Attendance/getSessionAttendanceData';
            fetch(url)
            .then(response => {
                console.log(response);
                if (!response.ok) {
                    throw new Error('Network response was not OK: ' + response.statusText);
                }
                return response.json(); 
            })
            .then(data => {
                console.log("Parsed data received:", data);
                if (!data || typeof data !== 'object') {
                    console.error('Received data is not an object or is undefined', data);
                    return;
                }

                const ctx = document.getElementById('sessionAttendanceChart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [{
                            label: 'Total Sessions',
                            data: data.totals,
                            borderColor: 'rgb(75, 192, 192)',
                            backgroundColor: 'rgba(75, 192, 192, 0.1)',
                            fill: true
                        }, {
                            label: 'Attended Sessions',
                            data: data.present,
                            borderColor: 'rgb(54, 162, 235)',
                            backgroundColor: 'rgba(54, 162, 235, 0.1)',
                            fill: true
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
            })
            .catch(error => console.error('Error loading the data:', error));
        });

    </script>


<style>
        #menu .items li:nth-child(5){
    border-left: 4px solid #fff;
    background: #4d0f0f;
}
#menu .items li:nth-child(5) i{
    color: #F3F4F6;
}






    </style>

    
</body>
</html>