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

    $wishlist_query = mysqli_query($connect, "
SELECT product.product_id, product.name, product.image_url, product.price ,product.description,product.stock
FROM wishlist 
JOIN product ON wishlist.product_id = product.product_id 
WHERE wishlist.user_id = '$userid'
");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>User Profile</title>

<link rel="stylesheet" href="user profile.css">
<link rel="stylesheet" href="my profile.css">
    
</head>
<body>
    
<div class="userprofile-page-div">

<?php 
require 'userprofile_navbar.php';
?>
<style>
    .My_Profile{
    color: orange;
    
}
</style>



<div class="userprofile-navigation-page-div">
    <h2>My Profile</h2>
<form method="post" action="user_profile.php">
    <div class="user_info" >
    <p><strong>Name:</strong> <?php echo $customer_data['first_name'] . ' ' . $customer_data['last_name']; ?></p>
    <p><strong>Email:</strong> <?php echo $user_data['email']; ?></p>
    <p><strong>id:</strong> <?php echo $userid; ?></p>
</div>
</form>
    <div>
<a href="my wishlist.php" class="my_wishlisy" >My Wishlist</a> 
</div>
    <div class="wishlist-container">
       
    <?php while ($product = mysqli_fetch_assoc($wishlist_query)): ?>
        <div class="wishlist-item">
            <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>">
            <h3><?= $product['name'] ?></h3>
            <p class="product-description"><?= $product['description'] ?></p>
            <p>RM <?= $product['price'] ?></p>

            <form method="POST" action="remove_from_wishlist.php">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

            
<a href="product.php?product_id=<?= $product['product_id'] ?>" class="view-button">View</a>
                <button type="submit" class="remove-button">Remove</button>
                
            </form>
        </div>
    <?php endwhile; ?>
    </div>




</div>




</div>
</body>
</html>