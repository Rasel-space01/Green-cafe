<?php
session_start(); // Start the session at the beginning

// Database connection
$conn = new mysqli('localhost', 'root', );

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Message for login status

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // Bind the username parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username; // Store username in session
            $_SESSION['role'] = $user['role']; // Store the role in the session

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: manager_dashboard.php"); // Admin goes to manager dashboard
            } else {
                header("Location: dashboard.php"); // User goes to student dashboard
            }
            exit();
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "User not found!";
    }

    $stmt->close(); // Close the prepared statement
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Cafe Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="images/green.png" width="50" height="60" alt="Green Cafe Logo">
            <h1>Green Cafe Login</h1>
            
            <!-- Display any login error message -->
            <p style="color: red;"><?php echo $message; ?></p> 
            
            <!-- Login Form -->
            <form method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                
                <button type="submit">Login</button>
            </form>

            <!-- Register Option -->
            <p>Don't have an account? <a href="register.php">Register here</a></p>

            <!-- Admin Login Option -->
            <p>Are you an admin? <a href="admin_login.php">Log in as Admin</a></p>

            <!-- Guest Access Option -->
            <p>Or continue as <a href="guestdashbord.php">Guest</a></p>
        </div>
    </div>
</body>
</html>
