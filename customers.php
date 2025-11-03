<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Tambah customer
if (isset($_POST['add_customer'])) {
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    mysqli_query($conn, "INSERT INTO customers (first_name,last_name,email,phone,address,join_date)
        VALUES ('$first','$last','$email','$phone','$address',NOW())");
    header("Location: customers.php");
}

// Ambil semua customer
$customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY customer_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Customers</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
<h2>Manage Customers</h2>
<a href="index.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

<!-- Form tambah customer -->
<form method="POST" class="mb-4">
<div class="row">
    <div class="col"><input type="text" name="first_name" class="form-control" placeholder="First Name" required></div>
    <div class="col"><input type="text" name="last_name" class="form-control" placeholder="Last Name" required></div>
    <div class="col"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
    <div class="col"><input type="text" name="phone" class="form-control" placeholder="Phone"></div>
    <div class="col"><input type="text" name="address" class="form-control" placeholder="Address"></div>
    <div class="col"><button type="submit" name="add_customer" class="btn btn-primary">Add Customer</button></div>
</div>
</form>

<!-- Table customers -->
<table class="table table-bordered">
<thead>
<tr>
<th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Join Date</th>
</tr>
</thead>
<tbody>
<?php while($c = mysqli_fetch_assoc($customers)) { ?>
<tr>
<td><?= $c['customer_id'] ?></td>
<td><?= $c['first_name'] ?></td>
<td><?= $c['last_name'] ?></td>
<td><?= $c['email'] ?></td>
<td><?= $c['phone'] ?></td>
<td><?= $c['address'] ?></td>
<td><?= $c['join_date'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</body>
</html>
