<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['userid']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
