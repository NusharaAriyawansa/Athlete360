<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Player Performance</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css"> <!-- Path to your CSS file -->
</head>
<body>
    <section class="update-performance-form">
        <h1>Update Performance</h1>
        <form action="<?php echo URLROOT; ?>/C_Performance/updatePerformance/<?php echo $performances->id; ?>" method="post">            
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" value="<?php echo htmlspecialchars($performances->date ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="batting">Batting</label>
                <input type="text" name="batting" id="batting" value="<?php echo htmlspecialchars($performances->batting ?? ''); ?>">
                <textarea name="batting_notes"><?php echo htmlspecialchars($performances->batting_notes ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="bowling">Bowling</label>
                <input type="text" name="bowling" id="bowling" value="<?php echo htmlspecialchars($performances->bowling ?? ''); ?>">
                <textarea name="bowling_notes"><?php echo htmlspecialchars($performances->bowling_notes ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="fielding">Fielding</label>
                <input type="text" name="fielding" id="fielding" value="<?php echo htmlspecialchars($performances->fielding ?? ''); ?>">
                <textarea name="fielding_notes"><?php echo htmlspecialchars($performances->fielding_notes ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="fitness">Fitness</label>
                <input type="text" name="fitness" id="fitness" value="<?php echo htmlspecialchars($performances->fitness ?? ''); ?>">
                <textarea name="fitness_notes"><?php echo htmlspecialchars($performances->fitness_notes ?? ''); ?></textarea>
            </div>
            <button type="submit" class="btn">Update Performance</button>
        </form>
    </section>
</body>
</html>
