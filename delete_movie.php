<?php
session_start();
include 'connect.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// Hapus poster juga (biar folder tidak penuh gambar sisa)
$getPoster = mysqli_query($conn, "SELECT poster FROM movies WHERE id='$id'");
$data = mysqli_fetch_assoc($getPoster);
if ($data['poster'] != "default.jpg") {
    unlink("uploads/" . $data['poster']);
}

// Hapus data film
mysqli_query($conn, "DELETE FROM movies WHERE id='$id'");

header("Location: admin_movies.php");
?>
