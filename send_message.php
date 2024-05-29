<?php
include_once 'includes/db.php';
include_once 'includes/session.php';

if (!isLoggedIn()) {
    http_response_code(403);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$senid = $_SESSION['userid'];
$recid = intval($data['recid']);
$message = $data['message'];

$stmt = $conn->prepare("INSERT INTO messages (senid, recid, message) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $senid, $recid, $message);
$stmt->execute();
