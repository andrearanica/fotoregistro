<?php

require('connection.php');
require('checkToken.php');

$student_id = $_POST['student_id'];

$query = "UPDATE students SET class_id=null WHERE student_id='$student_id';";
$stmt = $connection->prepare($query);
$stmt->execute();

?>