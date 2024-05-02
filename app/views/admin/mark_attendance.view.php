<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
</head>
<body>
    <h1>Mark Attendance for Today</h1>
    <form action="<?php echo URLROOT; ?>/sessions/updateAttendance" method="post">
        <input type="hidden" name="occurrence_id" value="<?php echo $data['occurrenceId']; ?>">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['members'] as $member): ?>
                <tr>
                    <td><?php echo htmlspecialchars($member['name']); ?></td>
                    <td>
                        <input type="checkbox" name="attendance[<?php echo $member['user_id']; ?>]" value="Present">
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit">Submit Attendance</button>
    </form>
</body>
</html>
