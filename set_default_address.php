<?php
session_start();
require 'db.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['userid'];

if (isset($_GET['address_id'])) {
    $address_id = intval($_GET['address_id']);

    // 将此用户的所有地址设为非默认
    mysqli_query($connect, "UPDATE address SET is_default = 0 WHERE user_id = '$user_id'");

    // 将选中的地址设为默认
    mysqli_query($connect, "UPDATE address SET is_default = 1 WHERE address_id = '$address_id' AND user_id = '$user_id'");
}

header("Location: address_page.php");
exit();
?>
