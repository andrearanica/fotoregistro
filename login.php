<?php

$host = '127.0.0.1';
$user = 'root';
$password = '';
$db = 'my_andrearanica';

$connection = new mysqli($host, $user, $password, $db);

if ($connection) {
    echo 'Connessione';
} else {
    die;
}

$query = 'SELECT * FROM students WHERE email="' . $_GET['email'] . '" AND password"=' $_GET['password'] . '";';
$connection->sql($query);