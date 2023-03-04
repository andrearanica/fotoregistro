<?php

ini_set('display_errors', 1);
require('./clearInput.php');

require('connection.php');

if ($connection) {
    
} else {
    die;
}

$email = $_POST['email'];
$password = $_POST['password'];

$cleanEmail = clean($email);
$cleanPassword = clean($password);

$stmt = $connection->prepare("SELECT * FROM students WHERE email='$cleanEmail' AND password='$cleanPassword';");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['enabled'] == true) {
            echo json_encode($row);
        } else {
            $return['message'] = 'user not enabled';
            echo json_encode($return);
        }
    }
} else {
    $response['message'] = 'user not found';
    echo json_encode($response);
}

?>