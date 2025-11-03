<?php
include 'connect.php';
$message = "";


if (isset($_POST['register'])) {
$name = $_POST['name'];
$email = $_POST['email'];
$password = md5($_POST['password']);
$role = "customer";


$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
if (mysqli_num_rows($check) > 0) {
$message = "Email sudah terdaftar!";
} else {
$query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
if (mysqli_query($conn, $query)) {
$message = "Registrasi berhasil, silakan login.";
} else {
$message = "Gagal daftar!";
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<div class="card shadow p-4 mx-auto" style="max-width: 400px;">
<h3 class="text-center">Register Akun</h3>
<form method="POST">
<input type="text" name="name" class="form-control mb-3" placeholder="Nama Lengkap" required>
<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
<button type="submit" name="register" class="btn btn-success w-100">Daftar</button>
</form>
<p class="text-danger mt-2 text-center"><?php echo $message; ?></p>
<p class="text-center mt-3">Sudah punya akun? <a href="login.php">Login</a></p>
</div>
</div>
</body>
</html>