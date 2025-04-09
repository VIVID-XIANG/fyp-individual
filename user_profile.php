<?php

require 'db.php';
session_start();


if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];

    //get user data
    $user_query = mysqli_query($connect, "SELECT * FROM user WHERE user_id = '$userid'");
    $user_data = mysqli_fetch_assoc($user_query);

    //get customer data
    $customer_query = mysqli_query($connect, "SELECT * FROM customer WHERE customer_id = '$userid'");
    $customer_data = mysqli_fetch_assoc($customer_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>User Profile</title>

<link rel="stylesheet" href="user profile.css">

    
</head>
<body>
    
<div class="userprofile-page-div">

<?php 
require 'userprofile_navbar.php';
?>

<div class="userprofile-navigation-page-div">
    <h2>My Profile</h2>
<form method="post" action="user_profile.php">
    <div class="user_info" >
    <p><strong>Name:</strong> <?php echo $customer_data['first_name'] . ' ' . $customer_data['last_name']; ?></p>
    <p><strong>Email:</strong> <?php echo $user_data['email']; ?></p>
</div>
</form>
    <h1 href="" class="" >My Wishlist</h1>
    






</div>




</div>
</body>
</html>