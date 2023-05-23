<?php

namespace App\utilities;

class Jwt {
    private const SECRET = 'f@t@r3g1str@';

    public static function base64url_encode ($str) {
        return rtrim(strtr(base64_encode($str), '+/', '-'), '=');
    }

    public static function createToken ($headers, $payload, $secret = 'f@t@r3g1str@') {
        $headers_encoded = Jwt::base64url_encode(json_encode($headers));
        $payload_encoded = Jwt::base64url_encode(json_encode($payload));
        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
        $signature_encoded = Jwt::base64url_encode($signature);
        $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
        return $jwt;
    }

    public static function checkToken ($token, $secret = 'f@t@r3g1str@') : bool {
        $tokenParts = explode('.', $token);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];

        $base64_url_header = Jwt::base64url_encode($header);
        $base64_url_payload = Jwt::base64url_encode($payload);
        $signature = hash_hmac('SHA256', $base64_url_header . '.' . $base64_url_payload, $secret, true);
        $base64_url_signature = Jwt::base64url_encode($signature);
        $check = ($base64_url_signature === $signature_provided);

        if ($check) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function getInfo ($token) {
        $tokenParts = explode('.', $token);
        $payload = $tokenParts[1];
        $payload = json_encode(base64_decode($payload));
        return $payload;
    }
}

?>