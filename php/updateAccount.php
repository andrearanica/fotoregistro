<?php

require('connection.php');
require('checkToken.php');

$table = $_POST['type'];

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];

$query = "UPDATE $table SET name='$name', surname='$surname', password='$password' WHERE email='$email';";
$stmt = $connection->prepare($query);
$stmt->execute();

echo json_encode(array('message' => 'ok'));

?>