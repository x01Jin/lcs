<?php
include 'includes/db.php';
include 'includes/session.php';

if (!isLoggedIn()) {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("SELECT id, username, status FROM users");
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
echo json_encode($users);
?>
