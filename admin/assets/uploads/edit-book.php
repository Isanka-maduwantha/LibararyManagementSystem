<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['librarian_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();

if (isset($_POST['update_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];
    $copies = $_POST['copies'];
    
    $cover_image = $book['cover_image'];
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
        $img_name = time() . '_' . $_FILES['cover_image']['name'];
        $target = "../assets/uploads/" . $img_name;
        move_uploaded_file($_FILES['cover_image']['tmp_name'], $target);
        $cover_image = $img_name;
    }

    $update_stmt = $conn->prepare("UPDATE books SET title=?, author=?, isbn=?, genre=?, copies=?, cover_image=? WHERE id=?");
    $update_stmt->bind_param("ssssisi", $title, $author, $isbn, $genre, $copies, $cover_image, $id);
    
    if ($update_stmt->execute()) {
        header("Location: books.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Edit Book</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo $book['title']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Author</label>
            <input type="text" name="author" value="<?php echo $book['author']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>ISBN</label>
            <input type="text" name="isbn" value="<?php echo $book['isbn']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Genre</label>
            <input type="text" name="genre" value="<?php echo $book['genre']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Copies</label>
            <input type="number" name="copies" value="<?php echo $book['copies']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Cover Image</label>
            <input type="file" name="cover_image" class="form-control" accept="image/*">
        </div>
        <button type="submit" name="update_book" class="btn btn-primary">Update Book</button>
    </form>
</body>
</html>