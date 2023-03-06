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

$query = "SELECT * FROM $table WHERE email='$cleanEmail' AND password='$cleanPassword';";

$stmt = $connection->prepare($query);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['enabled'] == true) {
            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array('email' => $row['email']);
            $message['message'] = jwt($headers, $payload);
            echo json_encode($message);
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