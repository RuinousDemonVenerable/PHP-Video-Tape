<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Tambah film
if (isset($_POST['add_movie'])) {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    $copies = $_POST['copies'];
    $poster = $_FILES['poster']['name'];
    move_uploaded_file($_FILES['poster']['tmp_name'], "assets/poster/".$poster);
    mysqli_query($conn, "INSERT INTO movies (title, genre, year, rating, price, copies_available, poster, created_at)
        VALUES ('$title','$genre','$year','$rating','$price','$copies','$poster',NOW())");
    header("Location: movies.php");
}

// Ambil semua movies
$movies = mysqli_query($conn, "SELECT * FROM movies ORDER BY movie_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Movies</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
<h2>Manage Movies</h2>
<a href="index.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

<!-- Form tambah movie -->
<form method="POST" enctype="multipart/form-data" class="mb-4">
    <div class="row">
        <div class="col"><input type="text" name="title" class="form-control" placeholder="Title" required></div>
        <div class="col"><input type="text" name="genre" class="form-control" placeholder="Genre" required></div>
        <div class="col"><input type="number" name="year" class="form-control" placeholder="Year" required></div>
        <div class="col"><input type="text" name="rating" class="form-control" placeholder="Rating" required></div>
        <div class="col"><input type="number" step="0.01" name="price" class="form-control" placeholder="Price" required></div>
        <div class="col"><input type="number" name="copies" class="form-control" placeholder="Copies" required></div>
        <div class="col"><input type="file" name="poster" class="form-control" required></div>
        <div class="col"><button type="submit" name="add_movie" class="btn btn-primary">Add Movie</button></div>
    </div>
</form>

<!-- Table movies -->
<table class="table table-bordered">
<thead>
<tr>
<th>ID</th><th>Title</th><th>Genre</th><th>Year</th><th>Rating</th><th>Price</th><th>Copies</th><th>Poster</th>
</tr>
</thead>
<tbody>
<?php while($m = mysqli_fetch_assoc($movies)) { ?>
<tr>
<td><?= $m['movie_id'] ?></td>
<td><?= $m['title'] ?></td>
<td><?= $m['genre'] ?></td>
<td><?= $m['year'] ?></td>
<td><?= $m['rating'] ?></td>
<td><?= $m['price'] ?></td>
<td><?= $m['copies_available'] ?></td>
<td><img src="assets/poster/<?= $m['poster'] ?>" width="60"></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</body>
</html>
