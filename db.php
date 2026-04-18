<?php
$conn = new mysqli("localhost", "root", "", "jwt_api");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>