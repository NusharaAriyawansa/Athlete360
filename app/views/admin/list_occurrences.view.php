<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Occurrences</title>
</head>
<body>
    <h1>Session Occurrences</h1>
    <ul>
        <?php foreach ($data['occurrences'] as $occurrence): ?>
            <li>
                <a href="<?php echo URLROOT; ?>/A_Attendance/viewAttendance/<?php echo $occurrence['occurrence_id']; ?>">
                    Occurrence ID: <?php echo htmlspecialchars($occurrence['occurrence_id']); ?>
                    Date: <?php echo htmlspecialchars($occurrence['session_date']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    

    <script>
        function checkOccurrence(occurrenceId, sessionDate) {
            const today = new Date().toISOString().slice(0, 10); // "YYYY-MM-DD"
            if (sessionDate < today) {
                showPastAttendance(occurrenceId);
            } else if (sessionDate === today) {
                showTodayAttendance(occurrenceId);
            } else {
                alert("SESSION YET TO COME");
            }
        }

        function showPastAttendance(occurrenceId) {
            $.ajax({
                url: '<?php echo URLROOT; ?>/A_Sessions/getAttendance',
                type: 'POST',
                data: { occurrence_id: occurrenceId },
                success: function(data) {
                    $('#attendanceDisplay').html(data);
                },
                error: function() {
                    alert('Failed to load attendance.');
                }
            });
        }

        function showTodayAttendance(occurrenceId) {
            $.ajax({
                url: '<?php echo URLROOT; ?>/A_Sessions/getEditableAttendance',
                type: 'POST',
                data: { occurrence_id: occurrenceId },
                success: function(data) {
                    $('#attendanceDisplay').html(data);
                    $('#attendanceDisplay').append('<button onclick="submitAttendance(' + occurrenceId + ')">Submit Attendance</button>');
                },
                error: function() {
                    alert('Failed to load attendance marking page.');
                }
            });
        }

        function submitAttendance(occurrenceId) {
            var attendanceData = [];
            $('#attendanceDisplay input[type="checkbox"]').each(function() {
                attendanceData.push({
                    user_id: $(this).data('user-id'),
                    attended: $(this).is(':checked') ? 1 : 0
                });
            });

            $.ajax({
                url: '<?php echo URLROOT; ?>/A_Sessions/updateAttendance',
                type: 'POST',
                contentType: 'application/json',  // Ensure you are sending JSON
                data: JSON.stringify({ occurrence_id: occurrenceId, attendance: attendanceData }),
                success: function(response) {
                    alert('Attendance updated successfully!');
                    window.location.reload(); // Reload to see the updated attendance
                },
                error: function() {
                    alert('Error updating attendance.');
                }
            });
        }
    </script>
</body>
</html>
