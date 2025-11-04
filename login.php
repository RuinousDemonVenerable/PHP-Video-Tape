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
<title>Login - Random Play</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .container {
        display: flex;
        height: 100vh;
    }

    /* Left Section */
    .left {
        background-color: #000;
        color: #fff;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .left img {
        width: 360px;
        margin-bottom: 1px;
    }

    .left h2 {
        font-size: 24px;
        letter-spacing: 2px;
        margin-bottom: 20px;
    }

    .left p {
        font-size: 12px;
        position: absolute;
        bottom: 20px;
    }

    /* Right Section */
    .right {
        flex: 1;
        background-color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .login-box {
        width: 300px;
    }

    h2 {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
    }

    label {
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    button {
        width: 100%;
        padding: 10px;
        border: none;
        background-color: #000;
        color: #fff;
        font-size: 16px;
        border-radius: 3px;
        cursor: pointer;
    }

    button:hover {
        background-color: #333;
    }

    .signup-text {
        text-align: center;
        margin-top: 10px;
        font-size: 13px;
    }

    .signup-text a {
        color: red;
        text-decoration: none;
        font-weight: bold;
    }

    .signup-text a:hover {
        text-decoration: underline;
    }

    .error {
        color: red;
        text-align: center;
        font-size: 14px;
        margin-bottom: 10px;
    }
</style>
</head>
<body>
<div class="container">
    <div class="left">
        <img src="uploads/randomplay_logo.jpg" alt="Random Play Logo">
        <h2>RANDOM PLAY</h2>
        <p>copyright © 2024 Random Play All Rights Reserved</p>
    </div>

    <div class="right">
        <div class="login-box">
            <h2>LOGIN</h2>
            <form method="POST">
                <label>Email</label>
                <input type="email" name="email" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <button type="submit" name="login">Login</button>

                <?php if ($message): ?>
                    <p class="error"><?= $message ?></p>
                <?php endif; ?>

                <p class="signup-text">I don't have an account? <a href="register.php">Sign Up</a></p>
            </form>
        </div>
    </div>
</div>
</body>
</html>
