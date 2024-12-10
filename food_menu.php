<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cafe_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a session for the user or guest
if (!isset($_SESSION['username']) && !isset($_SESSION['guest'])) {
    die("User not logged in.");
}

// Items list (you can fetch this from a database if necessary)
$items = [
    ["name" => "Burger", "price" => 100, "img" => "images/burger.jpg"],
    ["name" => "Pizza", "price" => 200, "img" => "images/pizza.jpg"],
    ["name" => "Pasta", "price" => 50, "img" => "images/pasta.jpg"],
    ["name" => "Sandwich", "price" => 80, "img" => "images/sandwich.png"],
    ["name" => "Sushi", "price" => 100, "img" => "images/susi.png"],
    ["name" => "Singara", "price" => 10, "img" => "images/singara.jpg"],
    ["name" => "Puri", "price" => 10, "img" => "images/puri.jpg"],
    ["name" => "Steak", "price" => 250, "img" => "images/stake.png"],
    ["name" => "Noodles", "price" => 30, "img" => "images/noodles.png"],
    ["name" => "Curry", "price" => 100, "img" => "images/curry.png"],
    ["name" => "Fried Rice", "price" => 90, "img" => "images/fride.png"],
    ["name" => "Ice Cream", "price" => 60, "img" => "images/ice.png"],
    ["name" => "Chocolate Cake", "price" => 40, "img" => "images/cake.png"],
    ["name" => "Coffee", "price" => 20, "img" => "images/cofe.png"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menu</title>
    <link rel="stylesheet" href="food_menu.css">
</head>
<body>
    <div class="menu-container">
        <h1>Choose Your Food</h1>
        <form action="place_order.php" method="POST">
            <div class="menu-items">
                <?php foreach ($items as $item): ?>
                    <div class="menu-item">
                        <img src="<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>">
                        <h3><?php echo $item['name']; ?></h3>
                        <p><?php echo $item['price']; ?> BDT</p>
                        <div class="quantity">
                            <button type="button" class="decrease">-</button>
                            <input type="number" name="quantity[<?php echo $item['name']; ?>]" value="0" min="0">
                            <button type="button" class="increase">+</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="checkout">
                <button type="submit">Place Order</button>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('.increase').forEach(button => {
            button.addEventListener('click', function() {
                let input = this.nextElementSibling;
                input.value = parseInt(input.value) + 1;
            });
        });

        document.querySelectorAll('.decrease').forEach(button => {
            button.addEventListener('click', function() {
                let input = this.previousElementSibling;
                if (parseInt(input.value) > 0) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });
    </script>
</body>
</html>
