<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");

include 'config.php';

$headers = getallheaders();

if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode(["message" => "Access denied"]);
    exit();
}

$authHeader = $headers['Authorization'];
$arr = explode(" ", $authHeader);
$jwt = $arr[1];

$decoded = verifyJWT($jwt, $key);

if (!$decoded) {
    http_response_code(401);
    echo json_encode(["message" => "Access denied"]);
    exit();
}

http_response_code(200);
echo json_encode([
    "message" => "Access granted",
    "user" => array(
        "id" => $decoded['data']['id'],
        "username" => $decoded['data']['username']
    )
]);
?>