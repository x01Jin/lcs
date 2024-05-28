<?php
include 'includes/db.php';
include 'includes/functions.php';
include 'includes/session.php';

if (!isLoggedIn() || !isAdmin()) {
    header("Location: chat.php");
    exit();
}

function handleAdminAction() {
    global $conn;

    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Delete user
        if ($action == 'delete_user' && isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            echo "<p>User deleted successfully.</p>";
        }

        // Modify user
        if ($action == 'modify_user' && isset($_POST['user_id'], $_POST['username'], $_POST['role'])) {
            $user_id = $_POST['user_id'];
            $username = $_POST['username'];
            $role = $_POST['role'];
            $stmt = $conn->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
            $stmt->bind_param("ssi", $username, $role, $user_id);
            $stmt->execute();
            echo "<p>User updated successfully.</p>";
        }

        // Delete message
        if ($action == 'delete_message' && isset($_POST['message_id'])) {
            $message_id = $_POST['message_id'];
            $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
            $stmt->bind_param("i", $message_id);
            $stmt->execute();
            echo "<p>Message deleted successfully.</p>";
        }

        // Modify message
        if ($action == 'modify_message' && isset($_POST['message_id'], $_POST['message'])) {
            $message_id = $_POST['message_id'];
            $message = $_POST['message'];
            $stmt = $conn->prepare("UPDATE messages SET message = ? WHERE id = ?");
            $stmt->bind_param("si", $message, $message_id);
            $stmt->execute();
            echo "<p>Message updated successfully.</p>";
        }
    }
}

handleAdminAction();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/adminstyles.css">
</head>
<body>
    <h1>Admin Panel</h1>
    <form id="logout-form" method="post" action="logout.php" style="display: inline;">
        <button type="submit">Logout</button>
    </form>

    <div class="tabs">
        <button class="tablinks" onclick="openTab(event, 'users')">Users</button>
        <button class="tablinks" onclick="openTab(event, 'messages')">Messages</button>
        <button class="tablinks" onclick="openTab(event, 'logs')">Logs</button>
    </div>

    <div id="users" class="tabcontent" style="display:none;">
        <h2>Users</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT id, username, role FROM users");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['role']}</td>";
                echo "<td>
                    <form method='post' style='display:inline-block;'>
                        <input type='hidden' name='action' value='delete_user'>
                        <input type='hidden' name='user_id' value='{$row['id']}'>
                        <input type='submit' value='Delete'>
                    </form>
                    <form method='post' style='display:inline-block;'>
                        <input type='hidden' name='action' value='modify_user'>
                        <input type='hidden' name='user_id' value='{$row['id']}'>
                        Username: <input type='text' name='username' value='{$row['username']}'>
                        Role: 
                        <select name='role'>
                            <option value='user' ".($row['role'] == 'user' ? 'selected' : '').">User</option>
                            <option value='admin' ".($row['role'] == 'admin' ? 'selected' : '').">Admin</option>
                        </select>
                        <input type='submit' value='Update'>
                    </form>
                    </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <div id="messages" class="tabcontent" style="display:none;">
        <h2>Messages</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Message</th>
                <th>Timestamp</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT m.id, u1.username AS sender, u2.username AS receiver, m.message, m.timestamp FROM messages m INNER JOIN users u1 ON m.senid = u1.id INNER JOIN users u2 ON m.recid = u2.id");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['sender']}</td>";
                echo "<td>{$row['receiver']}</td>";
                echo "<td>{$row['message']}</td>";
                echo "<td>{$row['timestamp']}</td>";
                echo "<td>
                    <form method='post' style='display:inline-block;'>
                        <input type='hidden' name='action' value='delete_message'>
                        <input type='hidden' name='message_id' value='{$row['id']}'>
                        <input type='submit' value='Delete'>
                    </form>
                    <form method='post' style='display:inline-block;'>
                        <input type='hidden' name='action' value='modify_message'>
                        <input type='hidden' name='message_id' value='{$row['id']}'>
                        <textarea name='message'>{$row['message']}</textarea>
                        <input type='submit' value='Update'>
                    </form>
                    </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <div id="logs" class="tabcontent" style="display:block;">
        <h2>Logs</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Action</th>
                <th>Timestamp</th>
            </tr>
            <?php
            $result = $conn->query("SELECT id, username, action, timestamp FROM inoutlog");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['action']}</td>";
                echo "<td>{$row['timestamp']}</td>";
                echo "</tr>";
                }
            ?>
        </table>
    </div>
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Prevent resubmission warning
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>
</html>

