<?php
include 'includes/db.php';
include 'includes/functions.php';
include 'includes/session.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $role = loginUser($username, $password);
    if ($role) {
        if ($role === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: chat.php");
        }
        exit(); // Make sure to exit after redirection
    } else {
        echo "<p>Error: Invalid username or password.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/inregstyles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Welcome Back!</h1>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
