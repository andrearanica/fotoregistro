<?php

ini_set('display_errors', 1);
require('./clearInput.php');

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

?>