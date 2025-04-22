<?php
require 'db.php';
session_start();

if (isset($_POST['verify_button'])) {
    $userid = $_POST['userid'];
    $entered_otp = $_POST['otp'];

    $query = mysqli_query($connect, "SELECT * FROM user WHERE user_id='$userid' AND otp_code='$entered_otp'");

    if (mysqli_num_rows($query) == 1) {
        // 验证成功
        mysqli_query($connect, "UPDATE user SET is_verified=1 WHERE user_id='$userid'");
        $_SESSION['userid'] = $userid;

        echo '<script>alert("OTP Verified. Welcome!");
        window.location.href = "user_profile.php";</script>';
    } else {
        echo '<script>alert("Invalid OTP. Try again.");
        window.history.back();</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
</head>
<body>
    <form method="POST" action="verify_otp.php">
        <input type="hidden" name="userid" value="<?= $_GET['userid'] ?>">
        <label>Enter the OTP sent to your email:</label>
        <input type="text" name="otp" required maxlength="6">
        <button type="submit" name="verify_button">Verify</button>
    </form>
</body>
</html>
