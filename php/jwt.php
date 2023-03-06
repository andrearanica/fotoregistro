<?php

ini_set('display_errors', true);
require('connection.php');

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

// $headers = array('alg' => 'HS256', 'typ' => 'JWT');
// $payload = array('sub' => '1234567890', 'name' => 'Andrea', 'surname' => 'Ranica');

//$jwt = jwt($headers, $payload);

if (isset($_GET['check'])) {
    check($_GET['check']);
} else if (isset($_POST['token']) && isset($_GET['type']))  {
    getInfo($_POST['token'], $_GET['type']);
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

function getInfo ($token, $type) {
    $host = '127.0.0.1';
    $user = 'root';
    $password = '';
    $db = 'my_andrearanica';
    
    $connection = new mysqli($host, $user, $password, $db);

    $tokenParts = explode('.', $token);
    $payload = $tokenParts[1];
    $payload = json_encode(base64_decode($payload));

    echo json_decode($payload);
    
    /*$email = explode(':', $payload);
    $email = $email[1];
    echo $email;
    $query = "SELECT * FROM $type WHERE email='$email'";
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()){
            // echo json_encode($row);
        }
    } else {
        // echo json_encode(array('message' => 'user not found'));
    }*/
}

?>