<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cafe_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the order ID is set
if (isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    // Update order status to Delivered
    $stmt = $conn->prepare("UPDATE orders SET status = 'Delivered' WHERE id = ?");
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
        echo "Order marked as delivered.";
    } else {
        echo "Error marking order as delivered: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No order ID provided.";
}

$conn->close();
?>
