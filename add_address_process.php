<?php
session_start();
require 'db.php';

$user_id = $_SESSION['userid'];

$building_name = mysqli_real_escape_string($connect, $_POST['building_name']);
$address_line = mysqli_real_escape_string($connect, $_POST['address_line']);
$city = mysqli_real_escape_string($connect, $_POST['city']);
$state_code = mysqli_real_escape_string($connect, $_POST['state_code']);
$postcode = mysqli_real_escape_string($connect, $_POST['postcode']);
$is_default = isset($_POST['is_default']) ? 1 : 0;

// 查询对应的 state_name
$state_query = mysqli_query($connect, "SELECT state_name FROM state WHERE state_code = '$state_code'");
$state_row = mysqli_fetch_assoc($state_query);
$state_name = $state_row['state_name'] ?? '';

// 查询对应的 postcode 是否存在
$postcode_query = mysqli_query($connect, "SELECT * FROM postcode WHERE postcode = '$postcode' AND state_code = '$state_code'");
if (mysqli_num_rows($postcode_query) == 0) {
    echo '<script>alert("Invalid postcode for selected state!"); window.history.back();</script>';
    exit();
}

if ($is_default) {
    mysqli_query($connect, "UPDATE address SET is_default = 0 WHERE user_id = '$user_id'");
}

$insert_query = "INSERT INTO address (user_id, building_name, address_line, postcode, city, state_territory, is_default)
                 VALUES ('$user_id', '$building_name', '$address_line', '$postcode', '$city', '$state_name', '$is_default')";

if (mysqli_query($connect, $insert_query)) {
    echo '<script>alert("Address added successfully!"); window.location.href="manage_address.php";</script>';
} else {
    echo "Error: " . mysqli_error($connect);
}
?>
