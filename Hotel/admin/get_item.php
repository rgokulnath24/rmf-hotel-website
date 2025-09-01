<?php
include("db.php");

$category = strtolower($_POST['category'] ?? '');
$id = $_POST['id'] ?? '';

$validTables = ['breakfast', 'lunch', 'dinner', 'snacks'];
if (!in_array($category, $validTables)) {
  echo json_encode([]);
  exit();
}


$idCol = $category . "_id";
$sql = "SELECT * FROM $category WHERE $idCol = $id LIMIT 1";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
  echo json_encode([
    "name" => $row[$category . "_name"],
    "type" => ucfirst($row[$category . "_type"]),
    "from" => $row[$category . "_available_from"],
    "to" => $row[$category . "_available_to"],
    "image"=>$row[$category."_image"],
    "available_from"=>$row[$category."_available_from"],
    "available_to"=>$row[$category."_available_to"]
  ]);
} else {
  echo json_encode([]);
}
$conn->close();
?>
