<?php

require('connection.php');

if ($connection) {
    
} else {
    die;
}

if (isset($_GET['teacher_id'])) {
    $teacherId = $_GET['teacher_id'];
    $query = "SELECT * FROM teaches INNER JOIN classes ON classes.class_id=teaches.class_id WHERE teacher_id='$teacherId'";
} else {
    $query = "SELECT * FROM classes";
}
$result = $connection->query($query);

// var_dump($result);

$array = array();
$n = 0;

while ($row = $result->fetch_assoc()) {
    $array[$n] = $row;
    $n++;
}

echo json_encode($array);

// $result = mysql_fetch_array($result);
// var_dump($result);

?>