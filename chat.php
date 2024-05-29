<?php
include_once 'includes/session.php';
include_once 'includes/db.php';
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="css/chatstyles.css">
    <script src="js/chat.js" defer></script>
</head>
<body data-userid="<?php echo htmlspecialchars($userid); ?>">
    <div id="chat-container">
        <div id="user-list-container">
            <div id="user-list">
                <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1><br>
                <h2>Users:</h2>
                <ul id="users">
                    <!-- User list will be populated here by JavaScript -->
                </ul>
            </div>
            <a href="logout.php" id="logout">Logout</a>
        </div>
        <div id="chat-box">
            <h2 id="chat-with">Select a user to chat</h2>
            <div id="messages">
                <!-- Messages will be populated here by JavaScript -->
            </div>
            <form id="message-form">
                <input type="text" id="message-input" placeholder="Type a message" required>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</body>
</html>
