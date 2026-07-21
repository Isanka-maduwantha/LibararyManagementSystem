<?php
// config/db.php

$host = "localhost";
$user = "root";
$password = "RootPass123!";
$database = "library_db";

// Creating the connection variable $conn
$conn = new mysqli($host, $user, $password, $database);

// Check if connection failed
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>