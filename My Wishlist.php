<?php
require 'db.php';

session_start();
$userid = $_SESSION['userid'];
    $wishlist_query = mysqli_query($connect, "
    SELECT product.product_id, product.name, product.image_url, product.price ,product.description,product.stock
    FROM wishlist 
    JOIN product ON wishlist.product_id = product.product_id 
    WHERE wishlist.user_id = '$userid'
    ");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    

    <title>My Wishlist</title>
    
<link rel="stylesheet" href="my wishlist.css">
<link rel="stylesheet" href="user profile.css">
</head>
<body>
 <div class='userprofile-page-div'>  
  <?php 
require 'userprofile_navbar.php';
?>
<style>
    .my_wishlist{
    color: orange;
    
}
</style>
<div>
<h1  class="" >My Wishlist</h1>
    <div class="wishlist-container">
    
    <?php while ($product = mysqli_fetch_assoc($wishlist_query)): ?>
        <div class="wishlist-item">
            <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>">
            <h3><?= $product['name'] ?></h3>
            <p class="product-description"><?= $product['description'] ?></p>
            <p>RM <?= $product['price'] ?></p>

            <form method="POST" action="remove_from_wishlist.php">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                <button href="" class="view-button">View</button>
                <button type="submit" class="remove-button">Remove</button>
            </form>
        </div>
    <?php endwhile; ?>
    </div>
</div>

</div> 
</body>
</html>

