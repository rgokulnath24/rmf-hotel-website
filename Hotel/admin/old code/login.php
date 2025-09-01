<?php
session_start();

// Database connection
$host = "localhost";
$db = "hotel";
$user = "root";
$pass = "pass@123"; 
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get input
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

// Prepare and bind statement
$stmt = $conn->prepare("SELECT password_1 FROM login_credentials WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($db_password);
    $stmt->fetch();

    if ($password === $db_password) {  // ⚠️ Use hashing in real apps
        $_SESSION['username'] = $username;

        if ($remember) {
            setcookie("remember_user", $username, time() + (86400 * 30), "/"); // 30 days
        }

        echo "Login successful! Welcome, $username.";
        // header("Location: dashboard.php"); // Uncomment if needed
    } else {
        echo "Invalid password.";
    }
} else {
    echo "Username not found.";
}

$stmt->close();
$conn->close();
?>
