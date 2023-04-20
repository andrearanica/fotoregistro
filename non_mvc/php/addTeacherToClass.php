<?php

include('connection.php');

$teacher_id = $_POST['teacher_id'];
$class_id = $_POST['class_id'];

$query = "INSERT INTO teaches VALUES ('$class_id', '$teacher_id')";
$stmt = $connection->prepare($query);
$stmt->execute();

echo json_encode(array('message' => 'ok'));

?>