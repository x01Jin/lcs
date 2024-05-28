<?php
include 'db.php';

function loginUser($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['userid'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            updateStatus($id, 'on');
            logAction($username, 'login');
            return $role; // Return the role
        }
    }
    return false;
}

function registerUser($username, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    return $stmt->execute();
}

function logAction($username, $action) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO inoutlog (username, action) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $action);
    $stmt->execute();
}

function updateStatus($userid, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $userid);
    $stmt->execute();
}
