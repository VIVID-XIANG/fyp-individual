<?php
session_start();
require 'db.php';
$errors = [];

// 如果用户没有从 registration 来，就重定向回注册页
if (!isset($_SESSION['otp']) || !isset($_SESSION['pending_user_register']) || !isset($_SESSION['otp_time'])) {
    header('Location: registration.php');
    exit();
}
if (time() - $_SESSION['otp_time'] > 300) {
    $errors[] = "OTP expired. Please register again.";
    // 清除相关 session
    unset($_SESSION['otp']);
    unset($_SESSION['otp_time']);
    unset($_SESSION['pending_user_register']);
    echo '<script>alert("OTP expired. Please register again."); window.location.href = "registration.php";</script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = trim($_POST['otp']);

    if ($enteredOtp == $_SESSION['otp']) {
        // OTP 正确，登录成功，设置正式登录状态
        $email=$_SESSION['pending_user_register']['email'];
        $password=$_SESSION['pending_user_register']['password'];
        $user_type=$_SESSION['pending_user_register']['user_type'];
        $first_name=$_SESSION['pending_user_register']['first_name'];
        $last_name=$_SESSION['pending_user_register']['last_name'];
$avatar='avatar.jpg';
        mysqli_query($connect,"INSERT INTO user (email,password,user_type,first_name,last_name,avatar) 
            VALUES ('$email','$password','$user_type','$first_name','$last_name','$avatar')");


  //get the new user id 
  $userid=mysqli_insert_id($connect);
  $_SESSION['userid'] = $userid;

        
       // $_SESSION['userid'] = $_SESSION['pending_user_register']['userid'];
        $_SESSION['user_type'] = $_SESSION['pending_user_register']['user_type'];

        // 清除临时注册数据
        unset($_SESSION['otp']);
        unset($_SESSION['otp_time']);
        unset($_SESSION['pending_user_register']);
        // 跳转到用户主页
        header("Location: user_profile.php?userid=" . $_SESSION['userid']);
        exit();

    } else {
        $errors[] = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="otp.css"> 
</head>
<body>

<div class="otp-div">
    <p class="otp-p">Enter OTP</p>

    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="verify_register_otp.php">
        <div class="input-div">
            <input class="otp-input" name="otp" type="text" placeholder="Enter the OTP sent to your email" required>
        </div>

        <div class="send-div">
            <button class="send-button" type="submit">Verify OTP</button>
        </div>
    </form>
    <div class="other-option">
<a  class="login-page-a" href="login.php">back to login </a>
</div>
</div>

</body>
</html>
