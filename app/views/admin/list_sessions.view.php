<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Sessions</title>
</head>
<body>
    <h1>Sessions</h1>
    <ul>
        <?php foreach ($data['sessions'] as $session): ?>
            <li>
                <a href="<?php echo URLROOT; ?>/A_Attendance/listOccurrences/<?php echo $session['session_id']; ?>">
                    <?php echo htmlspecialchars($session['session_name']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
