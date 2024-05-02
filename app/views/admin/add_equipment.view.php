<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Equipment</title>
    <link rel="stylesheet" href="/path/to/your/stylesheets/style.css"> <!-- Adjust the path as necessary -->
</head>
<body>
    <h1>Add New Equipment</h1>
    <form action="<?php echo URLROOT; ?>/A_EquipmentManage/add" method="POST"> <!-- Ensure the action matches the route handling the POST request -->
        <div class="form-group">
            <label for="name">Equipment Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="availability">Availability:</label>
            <select id="availability" name="availability" required>
                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
            </select>
        </div>
        <div class="form-group">
            <label for="price">Price for Hiring:</label>
            <input type="text" id="price" name="price" required>
        </div>
        <button type="submit" class="btn">Add Equipment</button>
    </form>
</body>
</html>
