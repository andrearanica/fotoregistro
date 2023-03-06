<?php

ini_set('display_errors', true);

function jwt($headers, $payload, $secret = 'tia') {
    $headers_encoded = base64url_encode(json_encode($headers));
    $payload_encoded = base64url_encode(json_encode($payload));
    $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
    $signature_encoded = base64url_encode($signature);
    $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
    return $jwt;
}

function base64url_encode ($str) {
    return rtrim(strtr(base64_encode($str), '+/', '-'), '=');
}

$headers = array('alg' => 'HS256', 'typ' => 'JWT');
$payload = array('sub' => '1234567890', 'name' => 'Andrea', 'surname' => 'Ranica');

$jwt = jwt($headers, $payload);

if (isset($_GET['check'])) {
    check($_GET['check']);
}

function check ($jwt, $secret = 'tia') {
    $tokenParts = explode('.', $jwt);
    $header = base64_decode($tokenParts[0]);
    $payload = base64_decode($tokenParts[1]);
    $signature_provided = $tokenParts[2];

    $base64_url_header = base64url_encode($header);
    $base64_url_payload = base64url_encode($payload);
    $signature = hash_hmac('SHA256', $base64_url_header . '.' . $base64_url_payload, $secret, true);
    $base64_url_signature = base64url_encode($signature);
    $check = ($base64_url_signature === $signature_provided);

    if ($check) {
        echo json_encode(array('valid' => true));
    } else {
        echo json_encode(array('valid' => false));
    }
}

?>