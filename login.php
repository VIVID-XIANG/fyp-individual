
<?php

require'db.php';
if(isset($_POST['sign_in_button'])){


$email = mysqli_real_escape_string($connect, $_POST['email']);
$password = mysqli_real_escape_string($connect, $_POST['password']);

$errors = [];

 // check the email is valid or no
 $query = "SELECT * FROM `user` WHERE email='$email'";
 $result = mysqli_query($connect, $query);


 if($result && mysqli_num_rows($result) == 1){
    // if valid check the password
    $user = mysqli_fetch_assoc($result);
    if($password === $user['password']){
        // if valid go to the userprofile
      
        if(empty($errors)){
      session_start();
$_SESSION['userid'] = $user['user_id'];
$_SESSION['user_type'] = $user['user_type'];


            if(strcmp($_SESSION['user_type'],"customer")==0){
//for customer table
                echo '<script>alert("User login successfully!");
                window.location.href = "user_profile.php";</script>';
           //when user register successfully it can go to their user profile 

           //admin
            }else if(strcmp($_SESSION['user_type'],"admin")==0){
                echo '<script>alert("GO to admin page");
                window.location.href = "admin.php";
                </script>';
                

            }else{
                echo '<script>alert("ERROR");
                 window.history.back();</script>';
                 exit();
            }
            
           }
      


    } else {
        
        $errors[]= 'Invalid password or email';
    }
} else {
   
    $errors[] = 'User not found';
}





}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  
    <title>Login</title>

<link rel="stylesheet" href="login.css" >


</head>
<body>



<form action="login.php" method="POST">
<div class="login-div">
<div>
    <p class="login-p">Login</p>
    <?php if (!empty($errors)): ?>
    <div class="error-message">
       
        <ul >Login failed!
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
</div>

<div class="input-div">
<input class="email-input"   name="email" placeholder="Email" required>



<input class="password-input" name="password" placeholder="Password" required>

</div>

<div class="sign-in-div">
    <button class="sign-in-button"  type="submit" name="sign_in_button">Sign in</button>
    
</div>
<div class="other-login-option-div">
<a href="forgot password.php" class="fotgot-password-a" >Forgot password?</a>
<a href="registration.php" class="register-a">Register</a>
</div>
    
</div>


</form>
    
</body>
</html>