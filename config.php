<?php
$key = "your_secret_key_here";

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function generateJWT($payload, $secret) {
    $header = base64url_encode(json_encode(array("alg" => "HS256", "typ" => "JWT")));
    $payload = base64url_encode(json_encode($payload));
    $signature = base64url_encode(hash_hmac('sha256', "$header.$payload", $secret, true));
    return "$header.$payload.$signature";
}

function verifyJWT($token, $secret) {
    $parts = explode('.', $token);
    if (count($parts) !== 3) return false;

    $header = $parts[0];
    $payload = $parts[1];
    $signature = $parts[2];

    $valid = base64url_encode(hash_hmac('sha256', "$header.$payload", $secret, true));

    if ($signature !== $valid) return false;

    $data = json_decode(base64_decode($payload), true);
    if ($data['exp'] < time()) return false;

    return $data;
}
?>