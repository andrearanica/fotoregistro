<?php

require('connection.php');

if ($connection) {
    
} else {
    die;
}

$query = "SELECT * FROM classes";
$result = $connection->query($query);

var_dump($result);

// $result = mysql_fetch_array($result);
// var_dump($result);

?>