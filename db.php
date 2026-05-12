<?php
// Database Configuration

$host = "localhost";
$user = "root";
$password = "";
$database = "feedback_db";

// Create Connection
$conn = new mysqli($host, $user, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>