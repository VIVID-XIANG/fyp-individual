<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>

    <link rel="stylesheet" href="user profile.css">
    <link rel="stylesheet" href="My order.css">
</head>
<body>
    
<div class="userprofile-page-div">
    <?php include 'userprofile_navbar.php'; ?>

    <div class="userprofile-navigation-bar-div">
    
    
    
        <a href="user profile.html" >My Profile</a>
        <a href="userprofile_address.html">Addresses</a>
       <a href="my_order.html">My Orders</a>
        <a href="view_history.php">View History</a>
        <a href="reset_password.php">Reset Password</a>
    
         <a class="" href="">
            <img class="" src=""> My coupons
        </a>
        <a class="" href="">
            <img class="" src=""> Need Help?
        </a>
    
        <a class="log-out-a" href="">
            <img class="log_out_image" src="log_out.png"> Log out
        </a>
    
    
       
    
    </div>
    <div class="userprofile-navigation-page-div">
       
<div class="order-container">
    <!-- Order 1 -->
    <div class="order-card">
        <div class="order-header">
            <strong>Order #123456</strong>
            <span>Order Date: 2024-04-02</span>
        </div>
        <div class="order-items">
            <div class="item">
                <img src="GAN249 V2.webp" alt="Product 1">
                <span>Product Name </span>
            </div>
            <div class="item">
                <img src="GAN249 V2.webp" alt="Product 2">
                <span>Product Name </span>
            </div>
        </div>
        <p>Payment Status: Paid</p>
        <p>Fulfillment: <span class="status received">Received</span></p>
        <strong>Total: 99.99</strong>
    </div>

    <!-- Order 2 -->
    <div class="order-card">
        <div class="order-header">
            <strong>Order #789012</strong>
            <span>Order Date: 2024-04-02</span>
        </div>
        <div class="order-items">
            <div class="item">
                <img src="GAN249 V2.webp" alt="Product 3">
                <span>Product Name </span>
            </div>
        </div>
        <p>Payment Status: Pending</p>
        <p>Fulfillment: <span class="status processing">Processing</span></p>
        <strong>Total: 49.99</strong>
    </div>

    <!-- Order 3 -->
    <div class="order-card">
        <div class="order-header">
            <strong>Order #345678</strong>
            <span>Order Date: 2024-04-02</span>
        </div>
        <div class="order-items">
            <div class="item">
                <img src="GAN249 V2.webp" alt="Product 4">
                <span>Product Name </span>
            </div>
        </div>
        <p>Payment Status: Refunded</p>
        <p>Fulfillment: <span class="status cancelled">Cancelled</span></p>
        <strong>Total: 0.00</strong>
    </div>

</div>

       
    
    
    
    
    </div>
    
    
    
    
    </div>
</body>
</html>