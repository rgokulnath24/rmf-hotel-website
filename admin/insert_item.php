<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: create_item.php");
    exit;
}

$name = trim($_POST['name'] ?? '');
$tableType = strtolower(trim($_POST['type'] ?? ''));
$vegType = strtolower(trim($_POST['veg_type'] ?? ''));
$availableFrom = $_POST['available_from'] ?? '';
$availableTo = $_POST['available_to'] ?? '';

$allowedTables = [
    'breakfast',
    'lunch',
    'snacks',
    'dinner'
];

$allowedFoodTypes = [
    'veg',
    'non-veg'
];

if (
    $name === '' ||
    !in_array($tableType, $allowedTables, true) ||
    !in_array($vegType, $allowedFoodTypes, true)
) {
    die("Invalid form data.");
}

if ($availableFrom >= $availableTo) {
    die("Invalid availability time.");
}

if (
    !isset($_FILES['image']) ||
    $_FILES['image']['error'] !== UPLOAD_ERR_OK
) {
    die("Please upload an image.");
}

$file = $_FILES['image'];

if ($file['size'] > 5 * 1024 * 1024) {
    die("Image must be less than 5MB.");
}

$imageInfo = getimagesize($file['tmp_name']);

if ($imageInfo === false) {
    die("Invalid image file.");
}

$allowedMimeTypes = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp'
];

if (!isset($allowedMimeTypes[$imageInfo['mime']])) {
    die("Only JPG, PNG and WEBP images are allowed.");
}

$extension = $allowedMimeTypes[$imageInfo['mime']];

$uploadDir = __DIR__ . "/items_images/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$fileName =
    bin2hex(random_bytes(16))
    . "."
    . $extension;

$filePath = $uploadDir . $fileName;

if (!move_uploaded_file(
    $file['tmp_name'],
    $filePath
)) {
    die("Unable to upload image.");
}

$prefix = $tableType . "_";

$nameColumn = $prefix . "name";
$typeColumn = $prefix . "type";
$fromColumn = $prefix . "available_from";
$toColumn = $prefix . "available_to";
$imageColumn = $prefix . "image";
$statusColumn = $prefix . "status";

$sql = "
    INSERT INTO `$tableType`
    (
        `$nameColumn`,
        `$typeColumn`,
        `$fromColumn`,
        `$toColumn`,
        `$imageColumn`,
        `$statusColumn`
    )
    VALUES (?, ?, ?, ?, ?, 1)
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    unlink($filePath);
    die("Unable to prepare database request.");
}

$relativePath = "items_images/" . $fileName;

$stmt->bind_param(
    "sssss",
    $name,
    $vegType,
    $availableFrom,
    $availableTo,
    $relativePath
);

if (!$stmt->execute()) {

    unlink($filePath);

    $stmt->close();
    $conn->close();

    die("Unable to create menu item.");
}

$stmt->close();
$conn->close();

header("Location: item_grid.php?created=1");
exit;