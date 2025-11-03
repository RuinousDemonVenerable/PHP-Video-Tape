<?php
session_start();
include 'connect.php';

// Cek kalau bukan customer, redirect ke login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data rental customer + info film
$query = "
    SELECT r.id as rental_id, m.title, m.genre, m.year, m.price, m.poster, r.rental_date, r.status
    FROM rentals r
    JOIN movies m ON r.movie_id = m.id
    WHERE r.user_id = '$user_id'
    ORDER BY r.rental_date DESC
";
$rentals = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Rentals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="customer_home.php" class="navbar-brand">Rental Movie</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Riwayat Sewa Saya</h2>
    <div class="row mt-3">
        <?php if(mysqli_num_rows($rentals) > 0): ?>
            <?php while($r = mysqli_fetch_assoc($rentals)): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="uploads/<?php echo $r['poster']; ?>" class="card-img-top" height="300">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $r['title']; ?></h5>
                            <p class="card-text"><?php echo $r['genre']; ?> (<?php echo $r['year']; ?>)</p>
                            <p>Status: <?php echo $r['status']; ?></p>
                            <p>Tanggal Sewa: <?php echo date('d M Y H:i', strtotime($r['rental_date'])); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">Belum ada film yang disewa.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

<?php if($r['status'] == 'rented'): ?>
    <a href="return_movie.php?id=<?php echo $r['rental_id']; ?>" class="btn btn-warning w-100 mt-2">Kembalikan</a>
<?php else: ?>
    <span class="badge bg-success mt-2">Sudah Dikembalikan</span>
<?php endif; ?>

<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['user_id'];

$query = "
    SELECT r.rental_id, m.title, m.genre, m.year, m.poster, r.rental_date, r.return_date, r.status, r.late_fee
    FROM rentals r
    JOIN movies m ON r.movie_id = m.id
    WHERE r.customer_id='$customer_id'
    ORDER BY r.rental_date DESC
";
$rentals = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Rentals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="customer_home.php" class="navbar-brand">Rental Movie</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Riwayat Sewa Saya</h2>
    <div class="row mt-3">
        <?php if(mysqli_num_rows($rentals) > 0): ?>
            <?php while($r = mysqli_fetch_assoc($rentals)): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="uploads/<?php echo $r['poster']; ?>" class="card-img-top" height="300">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $r['title']; ?></h5>
                            <p class="card-text"><?php echo $r['genre']; ?> (<?php echo $r['year']; ?>)</p>
                            <p>Status: <?php echo $r['status']; ?></p>
                            <p>Tanggal Sewa: <?php echo date('d M Y H:i', strtotime($r['rental_date'])); ?></p>
                            <p>Tanggal Kembali: <?php echo date('d M Y H:i', strtotime($r['return_date'])); ?></p>
                            <p>Denda Keterlambatan: Rp <?php echo number_format($r['late_fee'],0,',','.'); ?></p>

                            <?php if($r['status'] == 'rented'): ?>
                                <a href="return_movie.php?id=<?php echo $r['rental_id']; ?>" class="btn btn-warning w-100 mt-2">Kembalikan</a>
                            <?php else: ?>
                                <span class="badge bg-success mt-2">Sudah Dikembalikan</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">Belum ada film yang disewa.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
