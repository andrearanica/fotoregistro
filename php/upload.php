<?php

ini_set('display_errors', true);
require('connection.php');

$student_id = $_POST['student_id'];

if (isset($_GET['remove'])) {
    $query = "UPDATE students SET photo=0 WHERE student_id='$student_id';";
    $stmt = $connection->prepare($query);
    $stmt->execute();
} else {
    $dir = '../photos/';
    foreach ($_FILES as $file) {
        if (UPLOAD_ERR_OK === $file['error']) {
            $extension = explode('.', $file['name'])[1];
            $fileName = basename("$student_id.jpg");
            move_uploaded_file($file['tmp_name'], $dir.DIRECTORY_SEPARATOR.$fileName);
            
            // header('Location: ../public/students/index.html');
        } else {
            header('Location: ');
        }
    }
    
    $query = "UPDATE students SET photo=1 WHERE student_id='$student_id';";
    $stmt = $connection->prepare($query);
    $stmt->execute();
}



?>