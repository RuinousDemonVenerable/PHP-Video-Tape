<?php
include 'connect.php';
session_start();

// Cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil movie_id dari URL
if (!isset($_GET['id'])) {
    echo "Film tidak ditemukan!";
    exit();
}

$movie_id = $_GET['id'];

// Ambil data film
$query = mysqli_query($conn, "SELECT * FROM movies WHERE movie_id='$movie_id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Film tidak ditemukan!";
    exit();
}

// Proses update
$message = "";
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    $copies = $_POST['copies_available'];

    // Upload poster jika ada
    if (isset($_FILES['poster']) && $_FILES['poster']['name'] != "") {
        $poster_name = time() . "_" . $_FILES['poster']['name'];
        move_uploaded_file($_FILES['poster']['tmp_name'], "uploads/" . $poster_name);
    } else {
        $poster_name = $data['poster']; // tetap poster lama
    }

    $update = mysqli_query($conn, "UPDATE movies SET 
        title='$title',
        genre='$genre',
        year='$year',
        rating='$rating',
        price='$price',
        copies_available='$copies',
        poster='$poster_name'
        WHERE movie_id='$movie_id'");

    if ($update) {
        $message = "Film berhasil diperbarui!";
        // refresh data
        $query = mysqli_query($conn, "SELECT * FROM movies WHERE movie_id='$movie_id'");
        $data = mysqli_fetch_assoc($query);
    } else {
        $message = "Terjadi kesalahan saat memperbarui film!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Film</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Edit Film: <?php echo $data['title']; ?></h3>
    <?php if ($message) { ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php } ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Judul Film</label>
            <input type="text" name="title" class="form-control" value="<?php echo $data['title']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Genre</label>
            <input type="text" name="genre" class="form-control" value="<?php echo $data['genre']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Tahun</label>
            <input type="number" name="year" class="form-control" value="<?php echo $data['year']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Rating</label>
            <input type="text" name="rating" class="form-control" value="<?php echo $data['rating']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $data['price']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Jumlah Salinan</label>
            <input type="number" name="copies_available" class="form-control" value="<?php echo $data['copies_available']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Poster (opsional)</label>
            <input type="file" name="poster" class="form-control">
            <img src="uploads/<?php echo $data['poster']; ?>" width="120" class="mt-2">
        </div>
        <button type="submit" name="update" class="btn btn-success">Update Film</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
