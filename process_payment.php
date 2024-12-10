<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cafe


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cart and total price
$cart = json_decode($_POST['cart'], true);
$totalPrice = $_POST['totalPrice'];
$paymentMethod = $_POST['payment_method'];

// Apply discount for online or student account payment
if ($paymentMethod == 'bkash' || $paymentMethod == 'student_account') {
    $totalPrice = $totalPrice * 0.90; // 10% discount
}

$orderDetails = json_encode($cart);

// Insert order into the database
$sql = "INSERT INTO orders (order_details, total_price, payment_method, status) VALUES ('$orderDetails', '$totalPrice', '$paymentMethod', 'Pending')";

if ($conn->query($sql) === TRUE) {
    echo "Order placed successfully!";
    // Redirect to success page or reset cart
    header('Location: success.php');
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
