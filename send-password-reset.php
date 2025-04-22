<?php
require 'db.php';
$email=$_POST["email"];

/* //check whether the email have an account or no
$query = "SELECT * FROM `user` WHERE email='$email'";
$result = mysqli_query($connect, $query);
if($result && mysqli_num_rows($result) ==1){
    
}else{
    echo '<script>alert("This email does not have an account");
    window.location.href = "forgot password.php";</script>';
    exit(); 
}*/

    $token=bin2hex(random_bytes(16)) ;

    $token_hash=hash("sha256",$token);

    $expiry=date("Y-m-d H:i:s",time()+60*30);

    $mysqli = require __DIR__ . "/db.php";

    $sql = "UPDATE user SET reset_token_hash=?, reset_token_expires_at=? WHERE email=?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $token_hash, $expiry, $email);

    $stmt->execute();

    if($mysqli->affected_rows){
    $mail=require __DIR__ ."/mailer.php";

    $mail->setFrom("ckxchuakaixiang@gmail.com");
    $mail->addAddress($email);
    $mail->Subject="Password Reset";
    $mail->Body = <<<END
    Click <a href="http://localhost/fyp-individual/fyp-individual/reset_password.php?token=$token">here</a> to reset your password.
    
    END;
    try{
        $mail->send();
    echo"Message sent,please check your inbox.";
    }catch(Exception $e){
        echo"Message culd not be send.Mailer error:{$mail->ErrorInfo}";
    }
    }

?>