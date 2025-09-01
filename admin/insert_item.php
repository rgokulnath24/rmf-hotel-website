<?php
include("db.php");

// Collect Form Inputs
$name = $_POST['name'] ?? '';
$table_type = $_POST['type'] ?? ''; // Table name: lunch, snacks, etc.
$dish_type = $_POST['dish_type'] ?? ''; // Actual dish type: starter, main, etc.
$veg_type = $_POST['veg_type'] ?? '';
$available_from = $_POST['available_from'] ?? '';
$available_to = $_POST['available_to'] ?? '';

// Allowed types and their column prefixes
$allowed_tables = [
  'breakfast' => 'breakfast_',
  'lunch'     => 'lunch_',
  'snacks'    => 'snacks_',
  'dinner'    => 'dinner_'
];

if (!array_key_exists($table_type, $allowed_tables)) {
  die("Invalid type selected.");
}

$prefix = $allowed_tables[$table_type];

// File Upload
$image_path = '';

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
  $target_dir = "items_images/";

  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
  }

  $image_name = basename($_FILES["image"]["name"]);
  $target_file = $target_dir . time() . "_" . $image_name;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  $valid_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
if (!in_array($imageFileType, $valid_extensions)) {
    // 🚨 Stop everything if extension is wrong
    echo "<p style='color: red;'>Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP files are allowed.</p>";
    $conn->close();
    exit; 
  }

  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $image_path = $target_file;
  } else {
    echo "<p style='color: red;'>Failed to upload image.</p>";
    $conn->close();
    exit;
  }

} else {
  echo "<p style='color: red;'>Image is required.</p>";
  $conn->close();
  exit;
}

// Check for existing dish with same name and status = 0
$check_sql = "SELECT * FROM `$table_type` WHERE {$prefix}name = '$name' AND {$prefix}status = 0";
$result = $conn->query($check_sql);

if ($result && $result->num_rows > 0) {
  // Update the existing record
  $update_sql = "UPDATE `$table_type` SET
    {$prefix}type = '$veg_type',
    {$prefix}available_from = '$available_from',
    {$prefix}available_to = '$available_to',
    {$prefix}image = '$image_path',
    {$prefix}status = 1
  WHERE {$prefix}name = '$name'";

  if ($conn->query($update_sql)) {
    echo "Updated existing dish: {$name} is now active in the {$table_type} menu.";
  } else {
    echo "<p style='color: red;'>Error updating record: " . $conn->error . "</p>";
  }

} else {
  // Insert new record
  $insert_sql = "INSERT INTO `$table_type` (
    {$prefix}name,
    {$prefix}type,
    {$prefix}available_from,
    {$prefix}available_to,
    {$prefix}image,
    {$prefix}status
  ) VALUES (
    '$name',
    '$veg_type',
    '$available_from',
    '$available_to',
    '$image_path',
    1
  )";

  if ($conn->query($insert_sql)) {
    echo "Great choice! {$name} has been added to the {$table_type} menu as a {$veg_type} delight.";
  } else {
    echo "<p style='color: red;'>Error inserting record: " . $conn->error . "</p>";
  }
}
$conn->close();
?>
