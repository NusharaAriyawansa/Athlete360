<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
</head>
<body>
    <h1>Attendance on <?php echo htmlspecialchars($data['session_date']); ?></h1>
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
                <td><?php echo htmlspecialchars($member['attendance']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
