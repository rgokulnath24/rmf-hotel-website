<?php

session_start();

require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$username =
    trim($_POST['username'] ?? '');

$password =
    $_POST['password'] ?? '';

$remember =
    isset($_POST['remember']);

if ($username === '' || $password === '') {

    header(
        "Location: index.php?error=1"
    );

    exit;
}

$stmt = $conn->prepare("
    SELECT username, password_1
    FROM login_credentials
    WHERE username = ?
    LIMIT 1
");

$stmt->bind_param(
    "s",
    $username
);

$stmt->execute();

$result =
    $stmt->get_result();

$user =
    $result->fetch_assoc();

$stmt->close();


if (
    !$user ||
    !password_verify(
        $password,
        $user['password_1']
    )
) {

    header(
        "Location: index.php?error=1"
    );

    exit;
}


/* Prevent session fixation */

session_regenerate_id(true);

$_SESSION['username'] =
    $user['username'];


if ($remember) {

    setcookie(
        "remember_user",
        $username,
        [
            'expires' =>
                time() + (86400 * 30),

            'path' => '/',

            'httponly' => true,

            'samesite' => 'Lax'
        ]
    );

}


header("Location: dashboard.php");

exit;