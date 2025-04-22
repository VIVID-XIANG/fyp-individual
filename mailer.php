<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//require "/vendor/autoload.php";
require 'C:/xampp/htdocs/fyp-individual/vendor/autoload.php';

$mail=new PHPMailer(true);

//$mail->SMTPDebug=SMTP::DEBUG SERVER;

$mail->isSMTP();
$mail->SMTPAuth=true;

$mail->Host="smtp.gmail.com";
$mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port=587;
$mail->Username="ckxchuakaixiang@gmail.com";
$mail->Password="vfvj pedt zpqk bxng";


$mail->isHtml(true);
return $mail;




?>



















