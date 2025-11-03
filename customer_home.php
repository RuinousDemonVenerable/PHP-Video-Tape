<?php
session_start();
include 'connect.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'customer'){
    header("Location: login.php");
    exit();
}

// Ambil semua film
$movies = mysqli_query($conn, "SELECT * FROM movies ORDER BY movie_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Home Customer</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Welcome <?= $_SESSION['name'] ?></span>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<div class="container mt-4">
<h2>Halo <?= $_SESSION['name'] ?>!</h2>
<p>Selamat datang di Rental Movie!</p>

<hr>
<h3>Daftar Film</h3>
<div class="row mt-3">
    <?php while($m = mysqli_fetch_assoc($movies)) { ?>
        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="uploads/<?= $m['poster'] ?>" class="card-img-top" height="300">
                <div class="card-body">
                    <h5 class="card-title"><?= $m['title'] ?></h5>
                    <p class="card-text"><?= $m['genre'] ?> (<?= $m['year'] ?>)</p>
                    <a href="rental.php?id=<?= $m['movie_id'] ?>" class="btn btn-success w-100">Sewa Film</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
</div>
</body>
</html>
