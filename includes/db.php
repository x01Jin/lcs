<?php
$servername = "localhost";
$username = "root"; // use your database username
$password = ""; // use your database password
$dbname = "lcsdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
