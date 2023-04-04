<?php

ini_set('display_errors', true);
require('connection.php');

$student_id = $_POST['student_id'];

if (isset($_GET['remove'])) {
    $query = "UPDATE students SET photo=0 WHERE student_id='$student_id';";
    $stmt = $connection->prepare($query);
    $stmt->execute();
} else {
    define('UPLOAD_DIR', '../photos/');
    $image_parts = explode(';base64,', $_POST['photo']);
    $image_type_aux = explode('image/', $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file = UPLOAD_DIR . "$student_id.png";
    file_put_contents($file, $image_base64);
    
    $query = "UPDATE students SET photo=1 WHERE student_id='$student_id';";
    $stmt = $connection->prepare($query);
    $stmt->execute();
}



?>