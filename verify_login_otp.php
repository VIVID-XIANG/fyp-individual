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
        // OTP 正确，完成登录
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
<html>
<head><title>Verify OTP</title></head>
<body>
<h2>OTP Verification</h2>
<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <?php foreach ($errors as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form method="POST">
    <input type="text" name="otp" placeholder="Enter OTP" required>
    <button type="submit" name="verify_login_otp_button">Verify</button>
</form>
</body>
</html>
