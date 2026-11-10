<?php

require_once "db.php";

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$categories = [
    'breakfast',
    'lunch',
    'snacks',
    'dinner'
];

$data = [];

foreach ($categories as $category) {

    $idColumn = $category . "_id";
    $statusColumn = $category . "_status";

    $sql = "
        SELECT *
        FROM `$category`
        WHERE `$statusColumn` = 1
        ORDER BY `$idColumn` DESC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        continue;
    }

    while ($row = $result->fetch_assoc()) {

        $row['category'] = $category;

        $row['display_category'] =
            ucfirst($category);

        $typeColumn =
            $category . "_type";

        $row['display_type'] =
            ucfirst(
                $row[$typeColumn]
            );

        $data[] = $row;
    }
}

$conn->close();