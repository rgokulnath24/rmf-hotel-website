<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

$category =
    trim($_GET['category'] ?? '');

$allowed =
    [
        'breakfast',
        'lunch',
        'snacks',
        'dinner'
    ];


if (!in_array(
    $category,
    $allowed,
    true
)) {

    http_response_code(400);

    header(
        "Content-Type: application/json"
    );

    echo json_encode([
        "success" => false,
        "message" => "Invalid category."
    ]);

    exit;
}


$id =
    $category . "_id";

$name =
    $category . "_name";

$type =
    $category . "_type";

$from =
    $category . "_available_from";

$to =
    $category . "_available_to";

$image =
    $category . "_image";

$status =
    $category . "_status";


$sql = "
    SELECT
        `$id`,
        `$name`,
        `$type`,
        `$from`,
        `$to`,
        `$image`
    FROM `$category`
    WHERE `$status` = 1
    ORDER BY `$id` ASC
";


$result =
    $conn->query($sql);


if (!$result) {

    http_response_code(500);

    header(
        "Content-Type: application/json"
    );

    echo json_encode([
        "success" => false,
        "message" => "Unable to load menu."
    ]);

    exit;
}


$items = [];


while (
    $row = $result->fetch_assoc()
) {

    $items[] = [

        "id" =>
            (int)$row[$id],

        "name" =>
            $row[$name],

        "type" =>
            strtolower(
                $row[$type] ?? ''
            ),

        "available_from" =>
            date(
                "h:i A",
                strtotime(
                    $row[$from]
                )
            ),

        "available_to" =>
            date(
                "h:i A",
                strtotime(
                    $row[$to]
                )
            ),

        "image" =>
            "admin/items_images/" .
            basename(
                $row[$image]
            )
    ];
}


header(
    "Content-Type: application/json; charset=utf-8"
);


echo json_encode(
    [
        "success" => true,
        "category" =>
            ucfirst($category),
        "count" =>
            count($items),
        "items" =>
            $items
    ],
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES
);
?>