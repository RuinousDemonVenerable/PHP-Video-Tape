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
        $message = "Email is already registered!";
    } else {
        $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $query)) {
            $message = "Registration successful! Please login.";
        } else {
            $message = "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign Up - Random Play</title>
<style>
    * {
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        margin: 0;
        background: #fff;
    }

    .container {
        display: flex;
        height: 100vh;
    }

    .left {
        flex: 1;
        background: #000;
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .left img {
        width: 360px;
        margin-bottom: 1px;
    }

    .left h2 {
        font-size: 24px;
        font-weight: bold;
    }

    .left p {
        position: absolute;
        bottom: 10px;
        font-size: 12px;
    }

    .right {
        flex: 1;
        background: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .form-box {
        width: 350px;
    }

    h2 {
        text-align: center;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 25px;
    }

    input[type="text"], input[type="email"], input[type="password"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        width: 100%;
        padding: 12px;
        border: none;
        background: #000;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background: #333;
    }

    .message {
        color: red;
        text-align: center;
        margin-top: 10px;
    }

    .link {
        text-align: center;
        margin-top: 15px;
    }

    .link a {
        color: #000;
        text-decoration: none;
        font-weight: bold;
    }

    .link a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<div class="container">
    <!-- Left section -->
    <div class="left">
        <img src="uploads/randomplay_logo.jpg" alt="Random Play Logo">
        <h2>RANDOM PLAY</h2>
        <p>copyright © 2024 Random Play All Rights Reserved</p>
    </div>

    <!-- Right section -->
    <div class="right">
        <div class="form-box">
            <h2>SIGN UP</h2>
            <form method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="register">Sign Up</button>
            </form>
            <?php if ($message): ?>
                <p class="message"><?= $message ?></p>
            <?php endif; ?>
            <div class="link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
