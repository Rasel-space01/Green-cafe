<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cafe_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the order has been placed, move to the payment page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantities = $_POST['quantity'];
    $order_items = [];
    $total_price = 0;

    foreach ($quantities as $item => $quantity) {
        if ($quantity > 0) {
            // Fetch item price from database or pre-defined array
            $price = 100; // Example price
            $order_items[] = $item . " x " . $quantity;
            $total_price += $price * $quantity;
        }
    }

    // Redirect to payment page with order and total amount
    $_SESSION['order_items'] = $order_items;
    $_SESSION['total_price'] = $total_price;
    header("Location: payment_page.php");
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .order-confirmation {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
        }
        .food-list {
            margin-bottom: 20px;
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
    <div class="order-confirmation">
        <h1>Order Confirmation</h1>
        <div class="food-list">
            <h2>Selected Items:</h2>
            <ul>
                <?php foreach ($food_details as $food): ?>
                    <li><?php echo $food; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <p>Total Price: ৳<?php echo $total_price; ?></p>
        <h2>Choose Payment Method:</h2>
        <form action="process_payment.php" method="POST">
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <input type="hidden" name="table_number" value="<?php echo $table_number; ?>">
            <label>
                <input type="radio" name="payment_method" value="bkash" required> bKash
            </label>
            <label>
                <input type="radio" name="payment_method" value="nagad" required> Nagad
            </label>
            <label>
                <input type="radio" name="payment_method" value="cod" required> Cash on Delivery
            </label>
            <button type="submit">Confirm Order</button>
        </form>
    </div>
</body>
</html>
