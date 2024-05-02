<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Player Performance</title>
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/coach/performance.css">
</head>
<body>
    <section id="addPerformanceForm">
        <h1>Add New Performance for Player</h1>
        <form action="<?php echo URLROOT; ?>/C_Performance/addPerformance" method="post">
            <input type="hidden" name="player_id" value="<?php echo $data['player_id']; ?>">

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="batting">Batting (0-10):</label>
            <input type="number" id="batting" name="batting" min="0" max="10">

            <label for="batting_notes">Batting Notes:</label>
            <textarea id="batting_notes" name="batting_notes"></textarea>

            <label for="bowling">Bowling (0-10):</label>
            <input type="number" id="bowling" name="bowling" min="0" max="10">

            <label for="bowling_notes">Bowling Notes:</label>
            <textarea id="bowling_notes" name="bowling_notes"></textarea>

            <label for="fielding">Fielding (0-10):</label>
            <input type="number" id="fielding" name="fielding" min="0" max="10">

            <label for="fielding_notes">Fielding Notes:</label>
            <textarea id="fielding_notes" name="fielding_notes"></textarea>

            <label for="fitness">Fitness (0-10):</label>
            <input type="number" id="fitness" name="fitness" min="0" max="10">

            <label for="fitness_notes">Fitness Notes:</label>
            <textarea id="fitness_notes" name="fitness_notes"></textarea>

            <label for="additional_notes">Additional Notes:</label>
            <textarea id="additional_notes" name="additional_notes"></textarea>

            <button type="submit" name="save" value="save">Submit Performance</button>
        </form>
    </section>
</body>
</html>
