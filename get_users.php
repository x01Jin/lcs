<?php
include_once 'includes/db.php';
include_once 'includes/session.php';
if (!isLoggedIn()) {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("SELECT id, username, status, role FROM users");
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
echo json_encode($users);
