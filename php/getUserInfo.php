<?php

ini_set('display_errors', 1);

$host = '127.0.0.1';
$user = 'root';
$password = '';
$db = 'my_andrearanica';

$connection = new mysqli($host, $user, $password, $db);

$id = $_GET['classId'];

$query = "SELECT * FROM classes WHERE class_id='$id';";
$stmt = $connection->prepare($query);

$stmt->execute();

$result = $stmt->get_result();

echo json_encode($result);

?>