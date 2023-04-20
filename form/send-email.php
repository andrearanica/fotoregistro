<?php

$email = $_POST['email'];
$text  = $_POST['text'];

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->Username = 'fotoregistro.it@gmail.com';
$mail->Password = 'fotoregistro1*';

$mail->setFrom('fotoregistro.it@gmail.com', 'Fotoregistro IT');
$mail->addAddress('andrearanica2004@gmail.com');

$mail->Subject = 'Fotoregistro';
$mail->Body = $text;

$mail->Send();

echo 'Email Sent';

?>