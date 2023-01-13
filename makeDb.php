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
    role INT NOT NULL
);';

$connection->query($sql);

$sql = 'INSERT INTO users (name, surname, email, password, class, role) VALUES
("admin", "admin", "admin", "21232f297a57a5a743894a0e4a801fc3", "", "1");';

$connection->query($sql);

$connection->close();
?>