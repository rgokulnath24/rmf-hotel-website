<?php
include("db.php");

$category = strtolower($_POST['category'] ?? '');
$id = $_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$type = strtolower($_POST['type'] ?? '');
$from = $_POST['from'] ?? '';
$to = $_POST['to'] ?? '';

$validTables = ['breakfast', 'lunch', 'dinner', 'snacks'];
if (!in_array($category, $validTables)) {
    echo "Invalid category";
    exit;
}

$idCol   = $category . "_id";
$nameCol = $category . "_name";
$typeCol = $category . "_type";
$fromCol = $category . "_available_from";
$toCol   = $category . "_available_to";
$imageCol= $category . "_image";

// Allowed image extensions
$allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

if (!empty($_FILES['image']['name'])) {
    $imgName = basename($_FILES['image']['name']);
    $target  = "items_images/" . time() . "_" . $imgName; // unique filename
    $ext     = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

    // Validate extension
    if (!in_array($ext, $allowedExts)) {
        echo "❌ Invalid image format. Only JPG, JPEG, PNG, GIF, WEBP are allowed.";
        exit;
    }

    // Upload
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "❌ Image upload failed.";
        exit;
    }

    // Update with image
    $sql = "UPDATE $category SET 
              $nameCol = '$name',
              $typeCol = '$type',
              $fromCol = '$from',
              $toCol   = '$to',
              $imageCol= '$target'
            WHERE $idCol = '$id'";
} else {
    // Update without image
    $sql = "UPDATE $category SET 
              $nameCol = '$name',
              $typeCol = '$type',
              $fromCol = '$from',
              $toCol   = '$to'
            WHERE $idCol = '$id'";
}

// Run the update
if ($conn->query($sql) === TRUE) {
    echo "Item updated successfully!";
} else {
    echo "Update failed: " . $conn->error;
}

$conn->close();
?>
