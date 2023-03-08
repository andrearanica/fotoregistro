<?php

ini_set('display_errors', 1);

require('connection.php');

$teacherId = $_POST['teacherId'];
$classId = uniqid('cl_');
$className = $_POST['className'];
$classDescription = $_POST['classDescription'];
$classAccessType = $_POST['classAccessType'];
$classSchoolId = $_POST['classSchoolId'];

$query = "INSERT INTO classes (class_id, name, access_type, school_id) VALUES ('$classId', '$className', $classAccessType, $classSchoolId);";
$stmt = $connection->prepare($query);

$stmt->execute();
$result = $stmt->get_result();

$query = "INSERT INTO teaches (teacher_id, class_id) VALUES ('$teacherId', '$classId');";

$stmt = $connection->prepare($query);
$stmt->execute();



echo json_encode(array('message' => 'class created'));

?>