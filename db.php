<?php
// DB Connection
$mysqli = new mysqli("localhost", "root", "pass@123", "hotel");

if ($mysqli->connect_error) {
    http_response_code(500);
    echo "Database connection failed: " . $mysqli->connect_error;
    exit;
}
?>