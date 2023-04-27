<?php

$student_id = $_GET['student_id'];

require('connection.php');
require('checkToken.php');

$query = "SELECT * FROM students WHERE student_id='$student_id'";
$stmt = $connection->prepare($query);
$stmt->execute();

$result = $stmt->get_result();
$result = $result->fetch_assoc();

echo json_encode($result);

?>