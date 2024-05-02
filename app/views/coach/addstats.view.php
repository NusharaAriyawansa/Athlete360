<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Match Statistic</title>
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/coach/performance.css">
</head>
<body>
    <h1>Add Match Statistic for Player</h1>
    <form action="<?php echo URLROOT; ?>/C_Performance/processAddMatchStat" method="post">
        <input type="hidden" name="player_id" value="<?php echo $data['playerId']; ?>">

        <label for="match_name">Match Name:</label>
        <input type="text" id="match_name" name="match_name" required>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="runs">Runs:</label>
        <input type="number" id="runs" name="runs">

        <label for="wickets">Wickets:</label>
        <input type="number" id="wickets" name="wickets">

        <label for="catches">Catches:</label>
        <input type="number" id="catches" name="catches">

        <label for="run_outs">Run Outs:</label>
        <input type="number" id="run_outs" name="run_outs">

        <button type="submit" name="submit">Add Statistic</button>
    </form>
</body>
</html>
