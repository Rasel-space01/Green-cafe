<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'cafe_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Ensure that only admins/managers can access this page
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch order history for the current month
$order_history_sql = "SELECT * FROM orders WHERE MONTH(created_at) = MONTH(CURRENT_DATE())";
$order_history = $conn->query($order_history_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Green Cafe</title>
    <link rel="stylesheet" href="manager_dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Order History (Current Month)</h1>
        <table>
            <thead>
                <tr>
                    <th>Table Number</th>
                    <th>Order Details</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($history = $order_history->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $history['table_number']; ?></td>
                    <td><?php echo $history['order_details']; ?></td>
                    <td><?php echo $history['status']; ?></td>
                    <td><?php echo $history['created_at']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="manager_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
