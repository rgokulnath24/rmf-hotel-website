<?php
$conn = new mysqli("localhost", "root", "pass@123", "hotel");
if ($conn->connect_error) {
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}
?>