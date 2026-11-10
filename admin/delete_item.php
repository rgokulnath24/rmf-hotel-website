<?php

session_start();

if (!isset($_SESSION['username'])) {

    http_response_code(401);

    echo "Unauthorized.";

    exit;
}

require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo "Invalid request.";

    exit;
}

$category =
    strtolower(
        trim($_POST['category'] ?? '')
    );

$id =
    filter_input(
        INPUT_POST,
        'id',
        FILTER_VALIDATE_INT
    );

$validTables = [
    'breakfast',
    'lunch',
    'snacks',
    'dinner'
];

if (
    !in_array($category, $validTables, true) ||
    !$id
) {

    http_response_code(400);

    echo "Invalid request.";

    exit;
}

$idColumn = $category . "_id";
$statusColumn = $category . "_status";

$sql = "
    UPDATE `$category`
    SET `$statusColumn` = 0
    WHERE `$idColumn` = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $id
);

if (!$stmt->execute()) {

    http_response_code(500);

    echo "Unable to delete item.";

    exit;
}

if ($stmt->affected_rows === 0) {

    echo "Item was already removed.";

} else {

    echo "Item removed successfully.";
}

$stmt->close();
$conn->close();