<?php

function base64url_encode1 ($str) {
    return rtrim(strtr(base64_encode($str), '+/', '-'), '=');
}

$headers = getallheaders();
$token = explode(' ', $headers['Authorization'])[1];

$secret = 'tia';
$tokenParts = explode('.', $token);
$header = base64_decode($tokenParts[0]);
$payload = base64_decode($tokenParts[1]);
$signature_provided = $tokenParts[2];

$base64_url_header = base64url_encode1($header);
$base64_url_payload = base64url_encode1($payload);
$signature = hash_hmac('SHA256', $base64_url_header . '.' . $base64_url_payload, $secret, true);
$base64_url_signature = base64url_encode1($signature);
$check = ($base64_url_signature === $signature_provided);

if (!$check) {
    echo json_encode(array('message' => 'token not valid'));
    die;
}

?>