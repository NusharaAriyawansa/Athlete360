<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Session</title>
</head>
<body>
    <div class="container">
    <h1>Edit Session</h1>
        <?php if (isset($session) && $session): ?>  <!-- Corrected the condition to check for non-empty $session -->
            <form action="<?php echo URLROOT; ?>/A_Sessions/update/<?php echo htmlspecialchars($session['session_id']); ?>" method="post">
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
                <button type="submit">Update Session</button>
            </form>
        <?php else: ?>
            <p>Session not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
