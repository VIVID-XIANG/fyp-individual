<?php
session_start();
require 'db.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM Customer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $error = "";

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($password === $row['password']) { 
            $_SESSION['customer_id'] = $row['customer_id'];
            $_SESSION['email'] = $row['email'];
            header("Location: homepage.html"); 
            exit();
        } else {
            $error = "wrong password";
        }
    } else {
        $error = "emial does not exist";
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


<?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
<form action="" method="POST">
<div class="login-div">
<div>
    <p class="login-p">Login</p>
</div>

<div class="input-div">
<input class="email-input"   name="email" placeholder="Email">



<input class="password-input" name="password" placeholder="Password">

</div>

<div class="sign-in-div">
    <button class="sign-in-button"  type="submit">Sign in</button>
    
</div>
<div class="other-login-option-div">
<a href="forgot password.html" class="fotgot-password-a" >Forgot password?</a>
<a href="registration.html" class="register-a">Register</a>
</div>
    
</div>


</form>
    
</body>
</html>