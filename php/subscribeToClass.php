<?php

include('connection.php');

$classId = $_POST['classId'];
$studentId = $_POST['studentId'];

$query = "UPDATE students SET class_id='$classId' WHERE student_id='$studentId'";
$stmt = $connection->prepare($query);
$stmt->execute();

echo json_encode(array('message' => 'ok'))

?>