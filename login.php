<?php
session_start();
include 'connect.php';
$message = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // --- Cek Admin ---
    $query_admin = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password=md5('$password') AND role='admin'");
    $admin = mysqli_fetch_assoc($query_admin);

    if ($admin) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['name'] = $admin['name'];
        $_SESSION['role'] = 'admin';
        header("Location: admin_dashboard.php");
        exit();
    }

    // --- Cek Customer ---
    $query_customer = mysqli_query($conn, "SELECT * FROM customers WHERE email='$email' AND password=md5('$password')");
    $customer = mysqli_fetch_assoc($query_customer);

    if ($customer) {
        $_SESSION['user_id'] = $customer['customer_id'];
        $_SESSION['name'] = $customer['first_name'];
        $_SESSION['role'] = 'customer';
        header("Location: customer_home.php");
        exit();
    }

    // Jika tidak ada yang cocok
    $message = "Email atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 400px;">
        <h3 class="text-center">Login</h3>
        <form method="POST">
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
        <?php if($message): ?>
            <p class="text-danger text-center mt-2"><?= $message ?></p>
        <?php endif; ?>
        <p class="text-center mt-3">Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
</div>
</body>
</html>
