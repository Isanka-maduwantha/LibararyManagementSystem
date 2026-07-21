<?php
require_once 'config/db.php';
$searchTearm = isset($_GET['search']) ? trim($_GET['search']) : "";

if (!empty($searchTearm)) {
    $sql = "SELECT * from books where title LIKE ?  OR author LIKE  ? or isbn LIKE ?";
    $statement = $conn->prepare($sql);
    $param = "%" . $searchTearm . "%";
    $statement->bind_param("sss", $param, $param, $param);
    $statement->execute();
    $result = $statement->get_result();
} else {
    // Default query to show all books when no search is performed
    $sql = "SELECT * FROM books ORDER BY id DESC";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav>
            <h1>Library System</h1> <a href="">Admin Login</a>
        </nav>
    </header>
    <main>
        <div class="search-container">
            <form action="index.php" method="GET" class="row g-3 mb-4">
                <div class="col-md-8">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by Title, Author, or ISBN..."
                        value="
                        <?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                        >
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                    
                    <?php if (isset($_GET['search']) && $_GET['search'] !== ''): ?>
                        <a href="index.php" class="btn btn-secondary">Clear</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <div class="books-container">
            <div class="row">
                <?php 
                    
                if ($result && $result->num_rows > 0): ?>
                    <?php while ($book = $result->fetch_assoc()): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img
                                    src="assets/uploads/<?php echo htmlspecialchars($book['cover_image']); ?>"
                                    class="card-img-top"
                                    alt="Book Cover"
                                    style="height: 250px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                                    <p class="card-text text-muted">By <?php echo htmlspecialchars($book['author']); ?></p>
                                    <p class="badge bg-info"><?php echo htmlspecialchars($book['genre']); ?></p>

                                    <p class="card-text">
                                        <strong>Available:</strong> <?php echo $book['available_copies']; ?>
                                    </p>

                                    <?php if ($book['copies'] > 0): ?>
                                        <button
                                            class="btn btn-success w-100"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reserveModal"
                                            data-book-id="<?php echo $book['id']; ?>"
                                            data-book-title="<?php echo htmlspecialchars($book['title']); ?>">
                                            Reserve Now
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            No books found matching "<strong><?php echo htmlspecialchars($searchTearm); ?></strong>".
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <footer></footer>

</body>

</html>