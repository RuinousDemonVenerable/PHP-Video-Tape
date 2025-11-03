<?php
session_start();
include 'connect.php';

// Cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Welcome, <?php echo $_SESSION['name']; ?> (Admin)</h2>
    <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

    <!-- TAB MENU -->
    <ul class="nav nav-tabs mb-3" id="adminTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="customers-tab" data-bs-toggle="tab" data-bs-target="#customers" type="button" role="tab">Customers</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="movies-tab" data-bs-toggle="tab" data-bs-target="#movies" type="button" role="tab">Movies</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="rentals-tab" data-bs-toggle="tab" data-bs-target="#rentals" type="button" role="tab">Rentals</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab">Payments</button>
      </li>
    </ul>

    <div class="tab-content" id="adminTabContent">
        <!-- Customers Tab -->
        <div class="tab-pane fade show active" id="customers" role="tabpanel">
            <a href="add_customer.php" class="btn btn-success mb-2">Tambah Customer</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th><th>Nama</th><th>Email</th><th>Phone</th><th>Address</th><th>Join Date</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY customer_id ASC");
                    while($c = mysqli_fetch_assoc($customers)) { ?>
                        <tr>
                            <td><?php echo $c['customer_id']; ?></td>
                            <td><?php echo $c['first_name'] . ' ' . $c['last_name']; ?></td>
                            <td><?php echo $c['email']; ?></td>
                            <td><?php echo $c['phone']; ?></td>
                            <td><?php echo $c['address']; ?></td>
                            <td><?php echo $c['join_date']; ?></td>
                            <td>
                                <a href="edit_customer.php?id=<?php echo $c['customer_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_customer.php?id=<?php echo $c['customer_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Movies Tab -->
        <div class="tab-pane fade" id="movies" role="tabpanel">
            <a href="add_movie.php" class="btn btn-success mb-2">Tambah Movie</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th><th>Title</th><th>Genre</th><th>Year</th><th>Rating</th><th>Price</th><th>Copies</th><th>Poster</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $movies = mysqli_query($conn, "SELECT * FROM movies ORDER BY movie_id ASC");
                    while($m = mysqli_fetch_assoc($movies)) { ?>
                        <tr>
                            <td><?php echo $m['movie_id']; ?></td>
                            <td><?php echo $m['title']; ?></td>
                            <td><?php echo $m['genre']; ?></td>
                            <td><?php echo $m['year']; ?></td>
                            <td><?php echo $m['rating']; ?></td>
                            <td><?php echo $m['price']; ?></td>
                            <td><?php echo $m['copies_available']; ?></td>
                            <td><img src="uploads/<?php echo $m['poster']; ?>" width="50"></td>
                            <td>
                                <a href="edit_movie.php?id=<?php echo $m['movie_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_movie.php?id=<?php echo $m['movie_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Rentals Tab -->
        <div class="tab-pane fade" id="rentals" role="tabpanel">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th><th>Customer</th><th>Movie</th><th>Rental Date</th><th>Return Date</th><th>Status</th><th>Late Fee</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rentals = mysqli_query($conn, "SELECT r.*, c.first_name, c.last_name, m.title FROM rentals r 
                        JOIN customers c ON r.customer_id=c.customer_id 
                        JOIN movies m ON r.movie_id=m.movie_id 
                        ORDER BY r.rental_id ASC");
                    while($r = mysqli_fetch_assoc($rentals)) { ?>
                        <tr>
                            <td><?php echo $r['rental_id']; ?></td>
                            <td><?php echo $r['first_name'].' '.$r['last_name']; ?></td>
                            <td><?php echo $r['title']; ?></td>
                            <td><?php echo $r['rental_date']; ?></td>
                            <td><?php echo $r['return_date']; ?></td>
                            <td><?php echo $r['status']; ?></td>
                            <td><?php echo $r['late_fee']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Payments Tab -->
        <div class="tab-pane fade" id="payments" role="tabpanel">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th><th>Rental ID</th><th>Amount</th><th>Payment Date</th><th>Payment Method</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $payments = mysqli_query($conn, "SELECT * FROM payments ORDER BY payment_id ASC");
                    while($p = mysqli_fetch_assoc($payments)) { ?>
                        <tr>
                            <td><?php echo $p['payment_id']; ?></td>
                            <td><?php echo $p['rental_id']; ?></td>
                            <td><?php echo $p['amount']; ?></td>
                            <td><?php echo $p['payment_date']; ?></td>
                            <td><?php echo $p['payment_method']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
