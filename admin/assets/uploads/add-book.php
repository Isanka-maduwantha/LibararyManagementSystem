<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['librarian_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];
    $copies = $_POST['copies'];
    
    $cover_image = null;
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
        $img_name = time() . '_' . $_FILES['cover_image']['name'];
        $target = "../assets/uploads/" . $img_name;
        move_uploaded_file($_FILES['cover_image']['tmp_name'], $target);
        $cover_image = $img_name;
    }

    $stmt = $conn->prepare("INSERT INTO books (title, author, isbn, genre, copies, cover_image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $title, $author, $isbn, $genre, $copies, $cover_image);
    
    if ($stmt->execute()) {
        header("Location: books.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Add New Book</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Author</label>
            <input type="text" name="author" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Genre</label>
            <input type="text" name="genre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Copies</label>
            <input type="number" name="copies" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Cover Image</label>
            <input type="file" name="cover_image" class="form-control" accept="image/*">
        </div>
        <button type="submit" name="add_book" class="btn btn-primary">Save Book</button>
    </form>
</body>
</html>