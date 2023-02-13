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



?>