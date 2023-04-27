<?php

require('connection.php');
require('checkToken.php');

if ($connection) {
    
} else {
    die;
}

if (isset($_GET['students'])) {
    $classId = $_GET['class_id'];
    $query = "SELECT * FROM students WHERE class_id='$classId' ORDER BY surname ASC;";
} else if (isset($_GET['teacher_id'])) {  
    $teacherId = $_GET['teacher_id'];
    $query = "SELECT * FROM teaches INNER JOIN classes ON classes.class_id=teaches.class_id WHERE teacher_id='$teacherId'";
} else if (isset($_GET['class_id'])) {
    $classId = $_GET['class_id'];
    $query = "SELECT * FROM classes WHERE class_id='$classId'";  
} else {
    $query = "SELECT * FROM classes";
}
$stmt = $connection->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// var_dump($result);

$array = array();
$n = 0;

while ($row = $result->fetch_assoc()) {
    $array[$n] = $row;
    $n++;
}

if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
    $query = "SELECT * FROM teachers JOIN teaches ON teachers.teacher_id=teaches.teacher_id WHERE teaches.class_id='$class_id';";
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $row = $result->fetch_assoc();
}

echo json_encode($array);

// $result = mysql_fetch_array($result);
// var_dump($result);

?>