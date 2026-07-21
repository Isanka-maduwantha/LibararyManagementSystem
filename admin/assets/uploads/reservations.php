<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['librarian_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT reservations.*, books.title, books.isbn 
          FROM reservations 
          JOIN books ON reservations.book_id = books.id 
          ORDER BY reservations.created_at DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Book Reservations</h2>
    <table class="table table-striped table-bordered mt-3">
        <thead>
            <tr>
                <th>Book Title</th>
                <th>ISBN</th>
                <th>Student Name</th>
                <th>Phone</th>
                <th>Required Date</th>
                <th>Return Date</th>
                <th>Reserved At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['isbn']; ?></td>
                <td><?php echo $row['student_name']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['required_date']; ?></td>
                <td><?php echo $row['return_date']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>