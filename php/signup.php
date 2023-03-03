<?php

ini_set('display_errors', 1);
require('./clearInput.php');

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

$host = '127.0.0.1';
$user = 'root';
$password = '';
$db = 'my_andrearanica';

$connection = new mysqli($host, $user, $password, $db);

if ($connection) {

} else {
    die;
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];

$cleanName = clean($name);
$cleanSurname = clean($surname);
$cleanEmail = clean($email);
$cleanPassword = clean($password);

$query = "INSERT INTO students (name, surname, email, password) VALUES ('$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";

$result = $connection->query($query);

$response['message'] = 'ok';

echo json_encode($response);

$mail = new PHPMailer(true);
$mail->IsSMTP();
$mail->Mailer = 'smtp';
$mail->SMTPDebug = 1;
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->Host = 'smtp.gmail.com';
$mail->Username = 'fotoregistro.it@gmail.com';
$mail->Password = 'fotoregistro1';

$mail->IsHTML(true);
$mail->AddAddress('andrearanica2004@gmail.com', 'Oggetto');
$mail->SetFrom('fotoregistro.it@gmail.com', 'Fotoregistro IT');
$mail->Subject = 'Y';
$content = 'OIjigsf';

$mail->MsgHTML($content);
if (!$mail->Send()) {
    echo 'Errore inviando email';
}

?>