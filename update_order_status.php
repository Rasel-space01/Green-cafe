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

// Update the status of the order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update_sql = "UPDATE orders SET status='$status' WHERE id='$order_id'";
    if ($conn->query($update_sql) === TRUE) {
        header('Location: order_management.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
