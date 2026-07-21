# LibararyManagementSystem

How to Run the Application
1. Clone the Repostry
2. create a db.php file Conatinng Your Database Info
   ```
   <?php
// config/db.php

$host = "localhost";
$user = "root";
$password = "";
$database = "library_db";

// Creating the connection variable $conn
$conn = new mysqli($host, $user, $password, $database);

// Check if connection failed
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
   ```
3. Create Database Using Query In res folder
4. dummy user Login  'admin','admin123'