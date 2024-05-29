<?php
include_once 'includes/db.php';
include_once 'includes/session.php';
if (!isLoggedIn()) {
    echo json_encode([]);
    exit;
}

$recid = intval($_GET['recid']);
$senid = $_SESSION['userid'];

$stmt = $conn->prepare("SELECT m.message, m.timestamp, u.username AS sender FROM messages m JOIN users u ON m.senid = u.id WHERE (m.senid = ? AND m.recid = ?) OR (m.senid = ? AND m.recid = ?) ORDER BY m.timestamp");
$stmt->bind_param("iiii", $senid, $recid, $recid, $senid);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
echo json_encode($messages);
