<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil semua payments
$payments = mysqli_query($conn, "SELECT p.*, r.rental_id, c.first_name, c.last_name, m.title FROM payments p
    JOIN rentals r ON p.rental_id=r.rental_id
    JOIN customers c ON r.customer_id=c.customer_id
    JOIN movies m ON r.movie_id=m.movie_id
    ORDER BY p.payment_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Payments</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
<h2>Manage Payments</h2>
<a href="index.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

<table class="table table-bordered">
<thead>
<tr>
<th>ID</th><th>Rental ID</th><th>Customer</th><th>Movie</th><th>Amount</th><th>Date</th><th>Method</th>
</tr>
</thead>
<tbody>
<?php while($p = mysqli_fetch_assoc($payments)) { ?>
<tr>
<td><?= $p['payment_id'] ?></td>
<td><?= $p['rental_id'] ?></td>
<td><?= $p['first_name'] ?> <?= $p['last_name'] ?></td>
<td><?= $p['title'] ?></td>
<td>$<?= $p['amount'] ?></td>
<td><?= $p['payment_date'] ?></td>
<td><?= $p['payment_method'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</body>
</html>
