<?php
session_start();
include 'connect.php';

// Hanya customer yang bisa akses
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}

// Ambil ID customer dari session
$customer_id = $_SESSION['user_id'];

// Ambil data customer dari database
$customer = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM customers WHERE customer_id='$customer_id'"));
if (!$customer) {
    echo "Movie rented successfully!";
    exit;
}

// Ambil movie_id dari GET
if (!isset($_GET['id'])) {
    echo "Film tidak ditemukan!";
    exit;
}
$movie_id = $_GET['id'];

// Ambil data movie
$movie = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM movies WHERE movie_id='$movie_id'"));
if (!$movie) {
    echo "Film tidak ditemukan!";
    exit;
}

// Proses rental ketika tombol sewa diklik
if (isset($_POST['sewa'])) {
    $rental_date = date("Y-m-d H:i:s");
    $return_date = date("Y-m-d H:i:s", strtotime("+3 days")); // default 3 hari rental
    $status = "Rented";
    $late_fee = 0;

    $insert = mysqli_query($conn, "INSERT INTO rentals (customer_id, movie_id, rental_date, return_date, status, late_fee) 
                                  VALUES ('$customer_id', '$movie_id', '$rental_date', '$return_date', '$status', '$late_fee')");
    
    if ($insert) {
        echo "<script>alert('Film berhasil disewa!'); window.location='customer_home.php';</script>";
        exit;
    } else {
        echo "Terjadi kesalahan saat menyewa film: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Detail Film</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2><?php echo $movie['title']; ?></h2>
    <p>Genre: <?php echo $movie['genre']; ?> | Tahun: <?php echo $movie['year']; ?></p>
    <p>Rating: <?php echo $movie['rating']; ?> | Harga: $<?php echo $movie['price']; ?></p>
    <img src="uploads/<?php echo $movie['poster']; ?>" alt="Poster" class="img-fluid mb-3">

    <form method="POST">
        <button type="submit" name="sewa" class="btn btn-success">Sewa Film</button>
    </form>

    <a href="customer_home.php" class="btn btn-secondary mt-2">Kembali ke Daftar Film</a>
</div>
</body>
</html>
