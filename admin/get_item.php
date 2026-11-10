<?php

session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['username'])) {

    http_response_code(401);

    echo json_encode([
        "error" => "Unauthorized"
    ]);

    exit;
}

require_once "db.php";

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

    echo json_encode([]);

    exit;
}

$idColumn = $category . "_id";
$nameColumn = $category . "_name";
$typeColumn = $category . "_type";
$fromColumn = $category . "_available_from";
$toColumn = $category . "_available_to";
$imageColumn = $category . "_image";

$sql = "
    SELECT
        `$nameColumn`,
        `$typeColumn`,
        `$fromColumn`,
        `$toColumn`,
        `$imageColumn`
    FROM `$category`
    WHERE `$idColumn` = ?
    LIMIT 1
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $id
);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();

if (!$row) {

    echo json_encode([]);

    exit;
}

echo json_encode([
    "name" => $row[$nameColumn],
    "type" => strtolower($row[$typeColumn]),
    "from" => $row[$fromColumn],
    "to" => $row[$toColumn],
    "image" => $row[$imageColumn]
]);

$stmt->close();
$conn->close();