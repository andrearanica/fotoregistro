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

$email = $_POST['email'];
$password = $_POST['password'];

$cleanEmail = clean($email);
$cleanPassword = clean($password);

$query = "SELECT * FROM students WHERE email='$cleanEmail' AND password='$cleanPassword';";
$result = $connection->query($query);
if ($result->num_rows > 0) {
    $response['message'] = 'ok';
    echo json_encode($response);
} else {
    $response['message'] = 'user not found';
    echo json_encode($response);
}

?>