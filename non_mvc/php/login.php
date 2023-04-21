<?php

ini_set('display_errors', 1);
require('./clearInput.php');

require('connection.php');
require('jwt.php');

if ($connection) {
    
} else {
    die;
}

$email = $_POST['email'];
$password = $_POST['password'];

$cleanEmail = clean($email);
$cleanPassword = clean($password);

if ($_GET['type'] == 'students') {
    $table = 'students';    
} else {
    $table = 'teachers';
}

$query = "SELECT * FROM $table WHERE email='$cleanEmail';";

$stmt = $connection->prepare($query);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (password_verify($cleanPassword, $row['password'])) {
            if ($row['enabled'] == true) {
                $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                if ($_GET['type'] == 'students') {
                    $payload = array('id' => $row['student_id'], 'name' => $row['name'], 'surname' => $row['surname'], 'email' => $row['email'], 'photo' => $row['photo'], 'class_id' => $row['class_id']);
                } else {
                    $payload = array('id' => $row['teacher_id'], 'name' => $row['name'], 'surname' => $row['surname'], 'email' => $row['email']);
                }
                $message['message'] = jwt($headers, $payload);
            } else {
                $message['message'] = 'user not enabled';   
            }
            echo json_encode($message);
        } else {
            $message['message'] = 'user not found'; 
            echo json_encode($message); 
        }
    }
} else {
    $response['message'] = 'user not found';
    echo json_encode($response);
}

?>