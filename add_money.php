<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cafe_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    die("User not logged in.");
}

// Fetch the username from the session
$username = $_SESSION['username'];

// Get the amount to add from the POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amountToAdd = $_POST['amount'];

    // Validate the amount
    if (!is_numeric($amountToAdd) || $amountToAdd <= 0) {
        die("Invalid amount.");
    }

    // Prepare SQL statement to update the user's balance
    $stmt = $conn->prepare("UPDATE users SET balance = balance + ? WHERE username = ?");
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ds", $amountToAdd, $username);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Money added successfully!";
    } else {
        echo "Error adding money: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No data submitted.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Money - Green Cafe</title>
    <link rel="stylesheet" href="add_money.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h1>Add Money to User Account</h1>
    <form action="add_money.php" method="POST">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" required>

        <label for="amount">Amount to Add (BDT):</label>
        <input type="number" id="amount" name="amount" min="1" required>

        <button type="submit">Add Money</button>
    </form>
	 <a href="manager_dashboard.php">Back to Dashboard</a>
</body>
</html>
