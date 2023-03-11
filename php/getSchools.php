<?php

require('connection.php');
$query = 'SELECT * FROM schools';

$stmt = $connection->prepare($query);
$stmt->execute();

$array = array();
$n = 0;

$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $array[$n] = $row;
    $n++;
}

echo json_encode($array);

?>