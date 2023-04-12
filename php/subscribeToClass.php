<?php

include('connection.php');
include('jwt.php');

$headers = getallheaders();
$token = explode(' ', $headers['Authorization'])[1];

$secret = 'tia';
$tokenParts = explode('.', $token);
$header = base64_decode($tokenParts[0]);
$payload = base64_decode($tokenParts[1]);
$signature_provided = $tokenParts[2];

$base64_url_header = base64url_encode($header);
$base64_url_payload = base64url_encode($payload);
$signature = hash_hmac('SHA256', $base64_url_header . '.' . $base64_url_payload, $secret, true);
$base64_url_signature = base64url_encode($signature);
$check = ($base64_url_signature === $signature_provided);

if (!$check) {
    die;
}

$classId = $_POST['classId'];
$studentId = $_POST['studentId'];

$query = "UPDATE students SET class_id='$classId' WHERE student_id='$studentId'";
$stmt = $connection->prepare($query);
$stmt->execute();

$query = "SELECT * FROM classes WHERE class_id='$classId';";
$stmt = $connection->prepare($query);
$stmt->execute();

$result = $stmt->get_result();

echo json_encode(array('message' => 'ok', 'info' => $result->fetch_assoc()))

?>