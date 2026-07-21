<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['librarian_id'])) {
    header("Location: login.php");
    exit();
}

$books_res = $conn->query("SELECT COUNT(*) AS total_books, IFNULL(SUM(copies), 0) AS total_copies FROM books");
$books_data = $books_res->fetch_assoc();

$res_count_res = $conn->query("SELECT COUNT(*) AS total_reservations FROM reservations");
$res_data = $res_count_res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Librarian Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Library Admin</a>
            <div class="navbar-nav">
                <a class="nav-link active" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="books.php">Manage Books</a>
                <a class="nav-link" href="add-book.php">Add Book</a>
                <a class="nav-link" href="reservations.php">Reservations</a>
                <a class="nav-link text-danger" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Dashboard Metrics</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Unique Books</h5>
                        <p class="card-text fs-2"><?php echo $books_data['total_books']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Book Copies</h5>
                        <p class="card-text fs-2"><?php echo $books_data['total_copies']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Reservations</h5>
                        <p class="card-text fs-2"><?php echo $res_data['total_reservations']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>