<?php
session_start();
include 'connect.php';

// Check admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - Random Play</title>
<style>
    * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    body { margin: 0; background: #fff; color: #000; }
    header {
        background: #000;
        color: #fff;
        padding: 20px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    header h1 { font-size: 20px; letter-spacing: 2px; }
    header a {
        background: #fff; color: #000; text-decoration: none;
        padding: 8px 16px; border-radius: 4px; border: 1px solid #000;
        transition: 0.3s; font-size: 14px;
    }
    header a:hover { background: #000; color: #fff; }
    .container { padding: 30px 50px; }
    nav { display: flex; gap: 15px; margin-bottom: 25px; border-bottom: 2px solid #000; padding-bottom: 10px; }
    nav button {
        background: none; border: none; color: #000; font-size: 16px;
        font-weight: bold; cursor: pointer; padding: 8px 16px; border-radius: 4px; transition: 0.3s;
    }
    nav button.active, nav button:hover { background: #000; color: #fff; }
    .tab { display: none; animation: fade 0.3s ease-in-out; }
    .tab.active { display: block; }
    @keyframes fade { from {opacity: 0; transform: translateY(10px);} to {opacity: 1; transform: translateY(0);} }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 10px; text-align: left; }
    th { background: #000; color: #fff; }
    tr:nth-child(even) { background: #f8f8f8; }
    .btn {
        padding: 5px 10px; border-radius: 3px; text-decoration: none; font-size: 13px; color: #fff; transition: 0.2s;
        display: inline-block;
    }
    .btn-edit { background: #28a745; }
    .btn-delete { background: #dc3545; }
    .btn-add {
        background: #000; color: #fff; text-decoration: none;
        padding: 8px 14px; border-radius: 4px; display: inline-block; margin-bottom: 15px;
    }
    .btn-add:hover { background: #333; }
</style>
<script>
    function showTab(tabName) {
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('nav button').forEach(btn => btn.classList.remove('active'));
        document.getElementById(tabName).classList.add('active');
        document.getElementById(tabName + '-btn').classList.add('active');
    }
    window.onload = function() { showTab('movies'); };
</script>
</head>
<body>

<header>
    <h1>RANDOM PLAY | ADMIN DASHBOARD</h1>
    <a href="logout.php">Logout</a>
</header>

<div class="container">
    <nav>
        <button id="movies-btn" onclick="showTab('movies')">Movies</button>
        <button id="customers-btn" onclick="showTab('customers')">Customers</button>
        <button id="rentals-btn" onclick="showTab('rentals')">Rentals</button>
        <button id="payments-btn" onclick="showTab('payments')">Payments</button>
    </nav>

    <!-- MOVIES TAB -->
    <div id="movies" class="tab">
        <h2>Movies</h2>
        <a href="add_movie.php" class="btn-add">+ Add Movie</a>
        <table>
            <thead>
                <tr><th>ID</th><th>Title</th><th>Genre</th><th>Year</th><th>Rating</th><th>Price</th><th>Copies</th><th>Poster</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php
                $movies = mysqli_query($conn, "SELECT * FROM movies ORDER BY movie_id ASC");
                while ($m = mysqli_fetch_assoc($movies)) { ?>
                    <tr>
                        <td><?= $m['movie_id'] ?></td>
                        <td><?= $m['title'] ?></td>
                        <td><?= $m['genre'] ?></td>
                        <td><?= $m['year'] ?></td>
                        <td><?= $m['rating'] ?></td>
                        <td><?= $m['price'] ?></td>
                        <td><?= $m['copies_available'] ?></td>
                        <td><img src="uploads/<?= $m['poster'] ?>" width="50"></td>
                        <td>
                            <a href="edit_movie.php?id=<?= $m['movie_id'] ?>" class="btn btn-edit">Edit</a>
                            <a href="delete_movie.php?id=<?= $m['movie_id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this movie?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- CUSTOMERS TAB -->
    <div id="customers" class="tab">
        <h2>Customers</h2>
        <table>
            <thead>
                <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Join Date</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php
                $customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY customer_id ASC");
                while ($c = mysqli_fetch_assoc($customers)) { ?>
                    <tr>
                        <td><?= $c['customer_id'] ?></td>
                        <td><?= $c['first_name'] . ' ' . $c['last_name'] ?></td>
                        <td><?= $c['email'] ?></td>
                        <td><?= $c['phone'] ?></td>
                        <td><?= $c['address'] ?></td>
                        <td><?= $c['join_date'] ?></td>
                        <td>
                            <a href="edit_customer.php?id=<?= $c['customer_id'] ?>" class="btn btn-edit">Edit</a>
                            <a href="delete_customer.php?id=<?= $c['customer_id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this customer?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- RENTALS TAB -->
    <div id="rentals" class="tab">
        <h2>Rentals</h2>
        <table>
            <thead>
                <tr><th>ID</th><th>Customer</th><th>Movie</th><th>Rental Date</th><th>Return Date</th><th>Status</th><th>Late Fee</th></tr>
            </thead>
            <tbody>
                <?php
                $rentals = mysqli_query($conn, "SELECT r.*, c.first_name, c.last_name, m.title FROM rentals r 
                    JOIN customers c ON r.customer_id=c.customer_id 
                    JOIN movies m ON r.movie_id=m.movie_id ORDER BY r.rental_id ASC");
                while ($r = mysqli_fetch_assoc($rentals)) { ?>
                    <tr>
                        <td><?= $r['rental_id'] ?></td>
                        <td><?= $r['first_name'] . ' ' . $r['last_name'] ?></td>
                        <td><?= $r['title'] ?></td>
                        <td><?= $r['rental_date'] ?></td>
                        <td><?= $r['return_date'] ?></td>
                        <td><?= $r['status'] ?></td>
                        <td><?= $r['late_fee'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- PAYMENTS TAB -->
    <div id="payments" class="tab">
        <h2>Payments</h2>
        <table>
            <thead>
                <tr><th>ID</th><th>Rental ID</th><th>Amount</th><th>Payment Date</th><th>Method</th></tr>
            </thead>
            <tbody>
                <?php
                $payments = mysqli_query($conn, "SELECT * FROM payments ORDER BY payment_id ASC");
                while ($p = mysqli_fetch_assoc($payments)) { ?>
                    <tr>
                        <td><?= $p['payment_id'] ?></td>
                        <td><?= $p['rental_id'] ?></td>
                        <td><?= $p['amount'] ?></td>
                        <td><?= $p['payment_date'] ?></td>
                        <td><?= $p['payment_method'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
