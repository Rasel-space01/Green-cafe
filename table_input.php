<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['username'])) {
    die("User not logged in.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Number Input</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .table-input-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
        }
        label {
            margin-bottom: 10px;
            display: block;
        }
        input[type="text"] {
            padding: 10px;
            width: 100%;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #5cb85c;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="table-input-container">
        <h1>Enter Table Number</h1>
        <form action="food_menu.php" method="POST">
            <label for="table_number">Table Number:</label>
            <input type="text" id="table_number" name="table_number" required>
            <button type="submit">Proceed to Food Menu</button>
        </form>
    </div>
</body>
</html>
