<?php
session_start();

if (!isset($_SESSION['otp']) || !isset($_SESSION['pending_user_login']) || !isset($_SESSION['otp_time'])) {
    header('Location: login.php');
    exit();
}
$errors = [];

if (isset($_POST['verify_login_otp_button'])) {

    if (time() - $_SESSION['otp_time'] > 300) {
        $errors[] = "OTP expired. Please login again.";
        unset($_SESSION['otp']);
        unset($_SESSION['otp_time']);
        unset($_SESSION['pending_user_login']);
        echo '<script>alert("OTP expired. Please login again."); window.location.href = "login.php";</script>';
        exit();
    }

    $entered_otp = $_POST['otp'];
    if ($entered_otp == $_SESSION['otp']) {
        // OTP 
        $_SESSION['userid'] = $_SESSION['pending_user_login']['user_id'];
        $_SESSION['user_type'] = $_SESSION['pending_user_login']['user_type'];

        unset($_SESSION['otp']);
        unset($_SESSION['otp_time']);
        unset($_SESSION['pending_user_login']);

        if ($_SESSION['user_type'] == "customer") {
            echo '<script>alert("Login successful! Redirecting to profile..."); window.location.href = "user_profile.php";</script>';
        } else if ($_SESSION['user_type'] == "admin") {
            echo '<script>alert("Welcome Admin!"); window.location.href = "admin.php";</script>';
        }
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

    <form method="POST" action="verify_login_otp.php">
        <div class="input-div">
            <input class="otp-input" name="otp" type="text" placeholder="Enter the OTP sent to your email" required>
        </div>

        <div class="send-div">
            <button class="send-button" name="verify_login_otp_button" type="submit">Verify OTP</button>
        </div>
    </form>
    <div class="other-option">
<a  class="login-page-a" href="login.php">back to login </a>
</div>
</div>

</body>
</html>
