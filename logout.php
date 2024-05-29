<?php
include_once 'includes/session.php';
include_once 'includes/functions.php';

if (isLoggedIn()) {
    $username = $_SESSION['username'];
    $userid = $_SESSION['userid'];
    updateStatus($userid, 'off');
    logAction($username, 'logout');
    session_destroy();
}
header("Location: login.php");
