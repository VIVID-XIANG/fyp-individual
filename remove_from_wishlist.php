<?php
session_start();
require 'db.php';

if (!isset($_SESSION['userid'])) {
    echo '<script>alert("Please try to login again"); window.location.href="login.php";</script>';
    exit();
}

$userid = $_SESSION['userid'];
$productid = $_POST['product_id'];

// delete wishlist item
$delete_query = mysqli_query($connect, "DELETE FROM wishlist WHERE user_id = '$userid' AND product_id = '$productid'");


if ($delete_query) {
    echo '<script>alert("Removed from wishlist successfully!"); window.location.href="user_profile.php";</script>';
} else {
    echo '<script>alert("Failed to remove item."); window.location.href="user_profile.php";</script>';
}
?>
