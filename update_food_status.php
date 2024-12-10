<?php
$conn = new mysqli('localhost', 'root', '', 'cafe_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_id = $_POST['food_id'];
    $availability = $_POST['availability'];

    $sql = "UPDATE food_items SET available = $availability WHERE id = $food_id";
    if ($conn->query($sql) === TRUE) {
        header('Location: manager_dashboard.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
