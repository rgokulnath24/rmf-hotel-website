<?php
// DB Connection
include("db.php");

// Get and sanitize form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$message = $_POST['message'] ?? '';
$created_private_ip = $_SERVER['REMOTE_ADDR'] ?? '';
$created_public_ip = file_get_contents("https://api.ipify.org"); // Gets public IP

// Prepare and bind
// mysqli_prepare(insert into table values(?,?,?));
$stmt = $mysqli->prepare("INSERT INTO customer_queries (name, email, phone, message, created_private_ip, created_public_ip) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    http_response_code(500);
    echo "Prepare failed: " . $mysqli->error;
    exit;
}

$stmt->bind_param("ssssss", $name, $email, $phone, $message, $created_private_ip, $created_public_ip);

// Execute and check
if ($stmt->execute()) {
    http_response_code(200);
    echo "Success";
} else {
    http_response_code(500);
    echo "Insert failed: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
