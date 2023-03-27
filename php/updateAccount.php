<?php

require('connection.php');

$table = $_GET['type'];

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['username'];
$password = $_POST['password'];

$query = "UPDATE $table SET name='$name', surname='$surname', password='$password' WHERE email='$email';";
$stmt = $connection->prepare($query);
$stmt->exec();

echo 'ok';

?>