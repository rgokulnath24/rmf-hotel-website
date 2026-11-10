<?php
$conn = new mysqli("localhost", "root", "", "hotel");
if ($conn->connect_error) {
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}
?>