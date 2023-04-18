<?php

ini_set('display_errors', 1);
require('./clearInput.php');

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

$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
mail($email, 'Benvenuto su fotoregistro', "Ciao $name! Per confermare il tuo account clicca <a href='andrearanica.altervista.org/fotoregistro/php/enableAccount.php?id=$id'>questo link</a>", $headers);

if ($result) {
    $response['message'] = 'ok';
    echo json_encode($response);
} else {
    $response['message'] = 'errore';
    $message = json_encode($response);
    die;
}

?>