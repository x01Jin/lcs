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
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="">
            <h1>Login</h1>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
