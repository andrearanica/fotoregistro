<?php

$host = '127.0.0.1';
$user = 'root';
$password = '';
$db = 'my_andrearanica';

$connection = new mysqli($host, $user, $password, $db);

if ($connection) {
    
} else {
    die;
}

$email = $_GET['email'];
$pwd = $_GET['password'];

$query = "SELECT * FROM students WHERE email='$email' AND password='$pwd';";
$response = $connection->query($query);
if ($response->num_rows > 0) {
    echo true;
}

?>