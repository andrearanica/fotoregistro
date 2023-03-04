<?php

ini_set('display_errors', 1);
require('./clearInput.php');

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

require('connection.php');

if ($connection) {

} else {
    die;
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];

$id = uniqid('st_');
$cleanName = clean($name);
$cleanSurname = clean($surname);
$cleanEmail = clean($email);
$cleanPassword = clean($password);

$query = "INSERT INTO students (student_id, name, surname, email, password) VALUES ('$id', '$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";

$result = $connection->query($query);

if ($result) {
    $response['message'] = 'ok';
    echo json_encode($response);
} else {
    $response['message'] = 'errore';
    $message = json_encode($response);
    die;
}

?>