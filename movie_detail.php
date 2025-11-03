<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'connect.php';

// Hanya customer yang bisa akses
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}

// Pastikan id dikirim
if (!isset($_GET['id'])) {
    header("Location: customer_home.php");
    exit();
}

$movie_id = $_GET['id'];

// Ambil data film berdasarkan movie_id
$movie = mysqli_query($conn, "SELECT * FROM movies WHERE movie_id='$movie_id'");
$data = mysqli_fetch_assoc($movie);

// Jika film tidak ditemukan
if (!$data) {
    echo "<div class='container mt-5'><h3>Film tidak ditemukan!</h3><a href='customer_home.php'>Kembali ke Home</a></div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Film - <?php echo $data['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="customer_home.php" class="navbar-brand">Rental Movie</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <img src="uploads/<?php echo $data['poster']; ?>" class="img-fluid rounded">
        </div>
        <div class="col-md-8">
            <h2><?php echo $data['title']; ?></h2>
            <p>Genre: <?php echo $data['genre']; ?></p>
            <p>Tahun: <?php echo $data['year']; ?></p>
            <p>Rating: <?php echo $data['rating']; ?></p>
            <h4>Harga Sewa: Rp <?php echo number_format($data['price'], 0, ',', '.'); ?></h4>
            <p>Stok Tersedia: <?php echo $data['copies_available']; ?></p>

            <?php if ($data['copies_available'] > 0) { ?>
                <a href="rental.php?id=<?php echo $data['movie_id']; ?>" class="btn btn-success mb-2">Sewa Film</a>
            <?php } else { ?>
                <button class="btn btn-secondary mb-2" disabled>Film Habis</button>
            <?php } ?>

            <a href="customer_home.php" class="btn btn-secondary mb-2">Kembali</a>
        </div>
    </div>
</div>

</body>
</html>
