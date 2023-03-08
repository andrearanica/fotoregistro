<?php

ini_set('display_errors', 1);

require('connection.php');

$className = $_POST['className'];
$classDescription = $_POST['classDescription'];
$classAccessType = $_POST['classAccessType'];

$query = "INSERT INTO classes (name, access_type) VALUES ('$className', $classAccessType);";
$stmt = $connection->prepare($query);

$stmt->execute();
$result = $stmt->get_result();

echo json_encode(array('message' => 'class created'));

?>