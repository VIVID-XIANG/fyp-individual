<?php
session_start();
require 'db.php'; 


$user_id = $_SESSION['userid'];

// get user address
$result = mysqli_query($connect, "SELECT * FROM address WHERE user_id = '$user_id'");

if(isset($_GET["delete_address"])){
    $address_id = intval($_GET['delete_address']);  
    mysqli_query($connect, "DELETE FROM address WHERE address_id='$address_id' AND user_id='$user_id'");
   
    header("Location: address_page.php");
    exit();
}




?>

<!DOCTYPE html>

<head>

    <title>Manage Address</title>
    <link rel="stylesheet" href="user profile.css";
</head>
<body>
<div class="userprofile-page-div">
 
<?php 
require 'userprofile_navbar.php';
?>
<style>
    .My_addresses{
    color: orange;
}
</style>


    <div class="userprofile-navigation-page-div">
        <h1>Manage Your Addresses</h1>

        <a href="add_address_form.php">
            <button class="add_address">Add New Address</button>
        </a>

        <hr>

        <!-- list all addresses-->
        <div style="height:80vh; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                
                <p><strong>Building Name:</strong> <?= htmlspecialchars($row['building_name']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($row['address']) ?></p>
                <p><strong>Postcode:</strong> <?= htmlspecialchars($row['postcode']) ?></p>
                <p><strong>City:</strong> <?= htmlspecialchars($row['city']) ?></p>
                <p><strong>State/Territory:</strong> <?= htmlspecialchars($row['state_territory']) ?></p>
                
                <?php if ($row['is_default']): ?>
                    <p style="color: green;"><strong>Default Address</strong></p>
                <?php else: ?>
                    <a href="set_default_address.php?address_id=<?= $row['address_id'] ?>">Set as Default</a>
                <?php endif; ?>
                <a href="edit_address_form.php?address_id=<?= $row['address_id'] ?>" class="btn btn-secondary" style="margin-right: 10px;">Edit</a>
<a href="address_page.php?delete_address=<?= $row['address_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this address?');">Delete</a>
            </div>
        <?php endwhile; ?>
    </div>
    </div>
</div>
</body>
</html>
