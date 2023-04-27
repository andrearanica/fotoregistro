<?php

ini_set('display_errors', true);
require('connection.php');

$student_id = $_POST['student_id'];

if (isset($_GET['file'])) {
    unlink("../photos/$student_id.png");
    foreach ($_FILES as $file) {
        if (UPLOAD_ERR_OK === $file['error']) {
            $fileName = "$student_id.png";
            move_uploaded_file($file['tmp_name'], "../photos/$fileName");
        }
    }
    $query = "UPDATE students SET photo=1 WHERE student_id='$student_id';";
    $stmt = $connection->prepare($query);
    $stmt->execute();

    header('Location: ../public/students/');

} else if (isset($_GET['remove'])) {
    $query = "UPDATE students SET photo=0 WHERE student_id='$student_id';";
    $stmt = $connection->prepare($query);
    $stmt->execute();
    unlink("../photos/$student_id.png");
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