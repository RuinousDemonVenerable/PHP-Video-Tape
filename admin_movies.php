<?php
session_start();
include 'connect.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$movies = mysqli_query($conn, "SELECT * FROM movies");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Film - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Daftar Film</h2>
    <a href="add_movie.php" class="btn btn-success mb-3">+ Tambah Film</a>
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th>
            <th>Poster</th>
            <th>Judul</th>
            <th>Genre</th>
            <th>Tahun</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($movies)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><img src="uploads/<?php echo $row['poster']; ?>" width="60"></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['genre']; ?></td>
            <td><?php echo $row['year']; ?></td>
            <td>Rp <?php echo number_format($row['price']); ?></td>
            <td>
                <a href="edit_movie.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete_movie.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
