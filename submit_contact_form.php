<?php

header("Content-Type: application/json");

require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);

    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $phone === '' || $message === '') {

    http_response_code(422);

    echo json_encode([
        'success' => false,
        'message' => 'Please fill all required fields.'
    ]);

    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    http_response_code(422);

    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address.'
    ]);

    exit;
}

if (!preg_match('/^[0-9]{10}$/', $phone)) {

    http_response_code(422);

    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid 10-digit phone number.'
    ]);

    exit;
}

if (strlen($name) > 50 || strlen($message) > 500) {

    http_response_code(422);

    echo json_encode([
        'success' => false,
        'message' => 'Input exceeds the allowed length.'
    ]);

    exit;
}

$privateIp = $_SERVER['REMOTE_ADDR'] ?? '';

$stmt = $conn->prepare("
    INSERT INTO customer_queries
    (
        name,
        email,
        phone,
        message,
        created_private_ip
    )
    VALUES (?, ?, ?, ?, ?)
");

if (!$stmt) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Unable to process your request.'
    ]);

    exit;
}

$stmt->bind_param(
    "sssss",
    $name,
    $email,
    $phone,
    $message,
    $privateIp
);

if (!$stmt->execute()) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Unable to save your message.'
    ]);

    $stmt->close();
    $conn->close();

    exit;
}

$stmt->close();
$conn->close();

echo json_encode([
    'success' => true,
    'message' => 'Your message has been sent successfully.'
]);