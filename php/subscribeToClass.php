<?php

include('connection.php');

$classId = $_POST['classId'];
$studentId = $_POST['studentId'];

$query = "UPDATE students SET class_id='$classId' WHERE student_id='$studentId'";
$stmt = $connection->prepare($query);
$stmt->execute();

$query = "SELECT * FROM classes WHERE class_id='$classId';";
$stmt = $connection->prepare($query);
$stmt->execute();

$result = $stmt->get_result();

echo json_encode(array('message' => 'ok', 'info' => $result->fetch_assoc()))

?>