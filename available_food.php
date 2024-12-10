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

// Fetch all food items
$food_sql = "SELECT * FROM food_items";
$foods = $conn->query($food_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Food Items - Green Cafe</title>
    <link rel="stylesheet" href="manager_dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Manage Food Menu</h1>
        <table>
            <thead>
                <tr>
                    <th>Food Item</th>
                    <th>Price</th>
                    <th>Available</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($food = $foods->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $food['name']; ?></td>
                    <td><?php echo $food['price']; ?></td>
                    <td>
                        <form method="POST" action="update_food_status.php">
                            <input type="hidden" name="food_id" value="<?php echo $food['id']; ?>">
                            <select name="availability" onchange="this.form.submit()">
                                <option value="1" <?php if ($food['available']) echo 'selected'; ?>>Available</option>
                                <option value="0" <?php if (!$food['available']) echo 'selected'; ?>>Unavailable</option>
                            </select>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="manager_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
