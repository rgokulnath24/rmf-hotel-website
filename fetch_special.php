<?php

header("Content-Type: application/json");

require_once "db.php";

$category = strtolower(trim($_GET['category'] ?? ''));

$allowedCategories = [
    'breakfast',
    'lunch',
    'snacks',
    'dinner'
];

if (!in_array($category, $allowedCategories, true)) {

    http_response_code(400);

    echo json_encode([
        'error' => 'Invalid menu category.'
    ]);

    exit;
}

$idColumn = $category . "_id";
$nameColumn = $category . "_name";
$typeColumn = $category . "_type";
$fromColumn = $category . "_available_from";
$toColumn = $category . "_available_to";
$imageColumn = $category . "_image";
$statusColumn = $category . "_status";

$sql = "
    SELECT
        `$idColumn`,
        `$nameColumn`,
        `$typeColumn`,
        `$fromColumn`,
        `$toColumn`,
        `$imageColumn`
    FROM `$category`
    WHERE `$statusColumn` = 1
    ORDER BY `$idColumn` ASC
";

$result = $conn->query($sql);

if (!$result) {

    http_response_code(500);

    echo json_encode([
        'error' => 'Unable to load menu.'
    ]);

    exit;
}

if ($result->num_rows === 0) {

    echo json_encode([
        'error' => 'No menu items available right now.'
    ]);

    exit;
}

$itemsHtml = "";

while ($row = $result->fetch_assoc()) {

    $name = htmlspecialchars(
        $row[$nameColumn],
        ENT_QUOTES,
        'UTF-8'
    );

    $type = htmlspecialchars(
        $row[$typeColumn],
        ENT_QUOTES,
        'UTF-8'
    );

    $image = htmlspecialchars(
        $row[$imageColumn],
        ENT_QUOTES,
        'UTF-8'
    );

    $from = date(
        "h:i A",
        strtotime($row[$fromColumn])
    );

    $to = date(
        "h:i A",
        strtotime($row[$toColumn])
    );

    $itemsHtml .= "
        <article class='menu-result-card'>

            <img
                src='admin/$image'
                alt='$name'
                loading='lazy'
            >

            <div class='menu-result-content'>

                <div class='menu-result-top'>

                    <h4>$name</h4>

                    <span class='food-badge $type'>
                        $type
                    </span>

                </div>

                <div class='menu-time'>

                    <span>
                        <i class='fa-regular fa-clock'></i>
                        Available
                    </span>

                    <strong>
                        $from - $to
                    </strong>

                </div>

            </div>

        </article>
    ";
}

echo json_encode([
    'title' => ucfirst($category),
    'description' => "
        <div class='menu-results'>
            $itemsHtml
        </div>
    "
]);

$conn->close();