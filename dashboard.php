<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cafe_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch account balance for logged-in user
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT balance FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$balance = $result->fetch_assoc()['balance'];

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Cafe Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Display account balance -->
        <div class="account-balance">
            <p>Account Balance: ৳<?php echo $balance; ?></p>
        </div>

        <!-- Options for Dine In, Parcel, Online Order -->
        <div class="order-options">
            <h2>Select Order Type</h2>

            <!-- Dine In Option -->
            <form action="user_dashboard.html" method="POST">
                <input type="hidden" name="order_type" value="dinein">
                <button type="submit">Dine In Order</button>
            </form>

            <!-- Parcel Option -->
            <form action="food_menu.php" method="POST">
                <input type="hidden" name="order_type" value="parcel">
                <button type="submit">Parcel Order</button>
            </form>

            <!-- Online Order Option -->
            <form action="food_menu.php" method="POST">
                <input type="hidden" name="order_type" value="online">
                <button type="submit">Online Order</button>
            </form>
        </div>
    </div>
</body>
</html>
