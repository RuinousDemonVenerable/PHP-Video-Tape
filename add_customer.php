<?php
include 'connect.php';
session_start();

// cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";
if (isset($_POST['add'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // hash password
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $join_date = date('Y-m-d');

    $insert = mysqli_query($conn, "INSERT INTO customers (first_name, last_name, email, password, phone, address, join_date)
        VALUES ('$first_name', '$last_name', '$email', '$password', '$phone', '$address', '$join_date')");

    if ($insert) {
        $message = "Customer berhasil ditambahkan!";
    } else {
        $message = "Gagal menambahkan customer: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Tambah Customer</h3>
    <?php if ($message) { ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php } ?>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Depan</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama Belakang</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="address" class="form-control">
        </div>
        <button type="submit" name="add" class="btn btn-success">Tambah Customer</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
