
<?php

require'db.php';
if(isset($_POST['create_button'])){
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);

$email = trim($_POST['email']);  
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$user_type="customer";

$errors = [];
if (strlen($password) < 4) {
    $errors[] = "Password must be at least 4 characters.";
}
if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
}


$email_check=mysqli_query($connect,"SELECT * FROM user WHERE email='$email'");
if(mysqli_num_rows($email_check)>0){
    echo '<script>alert("This email is already registered. Please use a different email.");
    window.history.back();</script>';
    exit();
}
if(empty($errors)){
  

  mysqli_query($connect,"INSERT INTO user (email,password,user_type) 
            VALUES ('$email','$password','$user_type')");
  //get the new user id 
$userid=mysqli_insert_id($connect);
            
 if(strcmp($user_type,"customer")==0){
    mysqli_query($connect,"INSERT INTO customer (customer_id,first_name,last_name) 
            VALUES ('$userid','$first_name','$last_name')");
 }
 session_start();
 $_SESSION['userid'] = $userid;

echo '<script>alert("User registered successfully!");
window.location.href = "user_profile.php?userid=' . $userid . '";</script>'; 
//when user register successfully it can go to their user profile  
}


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
   
    
    <title>Account Registration</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    
<div class="registration-div">
    <div>
        <p class="register-p">Account Registration</p>
    </div>
    <form method="POST" action="registration.php">
    <?php if (!empty($errors)): ?>
    <div class="error-message">
       
        <ul >User registration failed!
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

    <div class="input-div">
    
    <input class="first-name-input" name="first_name" placeholder="First name" required>  
    <input class="last-name-input" name="last_name" placeholder="Last name" required>
    <input class="email-input" name="email" type="email" placeholder="Email" required>
    <input class="password-input" name="password" type="password" placeholder="Password" required>
    <input class="comfirm-password-input" name="confirm_password" type="password" placeholder="Confirm Password" required>
    
    </div>
    
    <div class="create-div">
        <button class="create-button" type="submit" name="create_button">Create Account</button>
        
    </div>
</form>
<div class="other-option">
<a  class="login-page-a" href="login.php">Already have an account? </a>
</div>

</div>

    
</body>
</html>
