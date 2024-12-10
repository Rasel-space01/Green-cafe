<?php
session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['cart'])) {
    header('Location: login.php');
    exit();
}

$order_type = $_POST['order_type'];
$table_number = $_POST['table_number'];
$cart = $_SESSION['cart'];
$totalPrice = 0;

foreach ($cart as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Green Cafe</title>
    <link rel="stylesheet" href="payment.css">
</head>
<body>
    <div class="payment-container">
        <h1>Payment Options</h1>
        <p>Total Amount: <?php echo $totalPrice; ?> BDT</p>

        <form method="POST" action="place_order.php">
            <input type="hidden" name="order_type" value="<?php echo $order_type; ?>">
            <input type="hidden" name="table_number" value="<?php echo $table_number; ?>">
            <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">

            <h3>Select Payment Method:</h3>
            <label>
                <input type="radio" name="payment_method" value="bKash" required> bKash
            </label><br>
            <label>
                <input type="radio" name="payment_method" value="student_account"> Student Account
            </label><br>
            <label>
                <input type="radio" name="payment_method" value="cod"> Cash on Delivery
            </label><br>

            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>
