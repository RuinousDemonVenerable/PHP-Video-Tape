<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}

$rental_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Update status sewa jadi 'returned'
$query = "UPDATE rentals SET status='returned' WHERE id='$rental_id' AND user_id='$user_id'";

if(mysqli_query($conn, $query)){
    echo "<script>alert('Film berhasil dikembalikan!'); window.location='my_rentals.php';</script>";
}else{
    echo "<script>alert('Gagal mengembalikan film!'); window.location='my_rentals.php';</script>";
}
?>

<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}

$rental_id = $_GET['id'];
$customer_id = $_SESSION['user_id'];

// Ambil return_date dari database
$result = mysqli_query($conn, "SELECT return_date FROM rentals WHERE rental_id='$rental_id' AND customer_id='$customer_id'");
$data = mysqli_fetch_assoc($result);

$now = new DateTime();
$return_date = new DateTime($data['return_date']);

$late_fee = 0;
if ($now > $return_date) {
    $diff = $now->diff($return_date);
    $days_late = $diff->days;
    $late_fee = $days_late * 5000; // misal Rp 5.000 per hari keterlambatan
}

// Update status dan late_fee
mysqli_query($conn, "UPDATE rentals SET status='returned', late_fee='$late_fee' WHERE rental_id='$rental_id' AND customer_id='$customer_id'");

echo "<script>alert('Film berhasil dikembalikan! Denda: Rp " . number_format($late_fee,0,',','.') . "'); window.location='my_rentals.php';</script>";
?>
