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

$id = '0';

$cleanName = clean($name);
$cleanSurname = clean($surname);
$cleanEmail = clean($email);
$cleanPassword = clean($password);

if ($_GET['type'] == 'students') {
    $id = uniqid('st_');
    $table = 'students';
    $query = "INSERT INTO $table (student_id, name, surname, email, password) VALUES ('$id', '$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";
} else {
    $id = uniqid('tc_');
    $table = 'teachers';
    $query = "INSERT INTO $table (teacher_id, name, surname, email, password) VALUES ('$id', '$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";
}

// $query = "INSERT INTO $table (student_id, name, surname, email, password) VALUES ('$id', '$cleanName', '$cleanSurname', '$cleanEmail', '$cleanPassword');";

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