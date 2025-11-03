<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    $copies = $_POST['copies_available'];

    if (isset($_FILES['poster']) && $_FILES['poster']['name'] != "") {
        $poster_name = time() . "_" . $_FILES['poster']['name'];
        move_uploaded_file($_FILES['poster']['tmp_name'], "uploads/" . $poster_name);
    } else {
        $poster_name = "default.jpg";
    }

    $insert = mysqli_query($conn, "INSERT INTO movies (title, genre, year, rating, price, copies_available, poster, created_at) 
        VALUES ('$title', '$genre', '$year', '$rating', '$price', '$copies', '$poster_name', NOW())");

    if ($insert) {
        $message = "Film berhasil ditambahkan!";
    } else {
        $message = "Gagal menambahkan film!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tambah Film</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<h3>Tambah Film Baru</h3>
<?php if ($message) { echo "<div class='alert alert-info'>$message</div>"; } ?>
<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Judul Film</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Genre</label>
        <input type="text" name="genre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tahun</label>
        <input type="number" name="year" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Rating</label>
        <input type="text" name="rating" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Harga</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Jumlah Salinan</label>
        <input type="number" name="copies_available" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Poster</label>
        <input type="file" name="poster" class="form-control">
    </div>
    <button type="submit" name="add" class="btn btn-success">Tambah Film</button>
    <a href="admin_dashboard.php" class="btn btn-secondary">Kembali</a>
</form>
</div>
</body>
</html>
