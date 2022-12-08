<?php
$ip = '127.0.0.1';
$username = 'root';
$pwd = '';
$database = 'test';
$connection = new mysqli($ip, $username, $pwd, $database);

$sql = 'CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    class VARCHAR(255) NOT NULL,
    admin BIT NOT NULL DEFAULT 0
);';

$connection->query($sql);

$connection->close();
?>