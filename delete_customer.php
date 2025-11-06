<?php
include 'connect.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM customers WHERE customer_id=$id");
header("Location: admin_dashboard.php");
exit();
?>
