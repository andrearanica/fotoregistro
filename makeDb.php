<?php
echo md5("admin");

$ip = '127.0.0.1';
$username = 'root';
$pwd = '';
$database = 'test';
$connection = new mysqli($ip, $username, $pwd, $database);

$sql = 'DROP TABLE users;';

$connection->query($sql);

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

$sql = 'INSERT INTO users (name, surname, email, password, class, admin) VALUES
("admin", "admin", "admin", "21232f297a57a5a743894a0e4a801fc3", "5ID", "1");';

$connection->query($sql);

$connection->close();
?>