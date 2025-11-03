<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil total movies, customers, rentals, payments
$total_movies = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM movies"))['total'];
$total_customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM customers"))['total'];
$total_rentals = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rentals"))['total'];
$total_payments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM payments"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Admin Dashboard</span>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>
<div class="container mt-4">
    <h2>Welcome, Admin!</h2>
    <div class="row mt-4">
        <div class="col-md-3"><div class="card p-3 text-center bg-primary text-white">Movies<br><?= $total_movies ?></div></div>
        <div class="col-md-3"><div class="card p-3 text-center bg-success text-white">Customers<br><?= $total_customers ?></div></div>
        <div class="col-md-3"><div class="card p-3 text-center bg-warning text-white">Rentals<br><?= $total_rentals ?></div></div>
        <div class="col-md-3"><div class="card p-3 text-center bg-info text-white">Payments<br><?= $total_payments ?></div></div>
    </div>
    <hr>
    <a href="movies.php" class="btn btn-primary">Manage Movies</a>
    <a href="customers.php" class="btn btn-success">Manage Customers</a>
    <a href="rentals.php" class="btn btn-warning">Manage Rentals</a>
    <a href="payments.php" class="btn btn-info">Manage Payments</a>
</div>
</body>
</html>
