<?php
session_start();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $raw_password = $_POST['password'];
    $raw_confirm_password = $_POST['confirm_password'];

    if (strlen($raw_password) < 4) {
        $errors[] = "Password must be at least 4 characters.";
    }
    if ($raw_password !== $raw_confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (!isset($_POST["token"])) {
        die("No token provided.");
    }

    $token = $_POST["token"];
    $token_hash = hash("sha256", $token);

    $mysql = require __DIR__ . "/db.php";

    $sql = "SELECT * FROM user WHERE reset_token_hash = ?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("Invalid token.");
    }

    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        die("Token has expired.");
    }

    if (empty($errors)) {
        $password = password_hash($raw_password, PASSWORD_DEFAULT);

        $stmt = $mysql->prepare("UPDATE user SET password=?, reset_token_hash=NULL, reset_token_expires_at=NULL WHERE user_id=?");
        $stmt->bind_param("si", $password, $user["user_id"]);
        $stmt->execute();

      //  echo '<script>alert("Reset successfully!");window.location.href = "user_profile.php?userid=' . $user["user_id"] . '";</script>';
      echo '<script>alert("Reset successfully!");window.location.href = "login.php";</script>';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="reset_password.css">
</head>
<body>
    <h1>Reset Password</h1>

    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET["token"] ?? "") ?>">

        <label for="password">New password</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Repeat password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Reset</button>
    </form>
</body>
</html>
