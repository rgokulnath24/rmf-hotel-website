<?php
include("db.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get category and id from POST
    $category = $_POST['category'] ?? '';
    $category = strtolower($category); 
    //strtolower Convert to lowercase
    $id = $_POST['id'] ?? '';
//   if(!array($category,$validtables))
//   {
//   echo "Not valid format";
// exit();
//   }
    // Whitelist valid table names to prevent SQL injection
    $validTables = ['breakfast', 'lunch', 'dinner', 'snacks'];
    if (!in_array($category, $validTables)) {
        echo "Invalid category.";
        exit();
    }

    // Build column name (e.g., breakfast_id)
    $idColumn = $category . "_id";
    $statusColumn = $category . "_status";

    // Connect to DB


    // Prepare and bind
    $stmt = $conn->prepare("update $category SET $statusColumn = 0 WHERE $idColumn = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Item deleted successfully.";
    } else {
        echo "Failed to delete item.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
