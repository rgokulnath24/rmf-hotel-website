<?php
include("db.php");
$category = $_GET['category'] ?? '';
$allowed_categories = ['breakfast', 'lunch', 'snacks', 'dinner'];

if (!in_array($category, $allowed_categories)) {
    echo json_encode(['error' => 'Invalid category']);
    exit;
}


$table = $conn->real_escape_string($category);
$field_prefix = $category;

$sql = "SELECT * FROM `$table` WHERE `{$field_prefix}_status` = 1 ORDER BY `{$field_prefix}_id` ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $items_html = '';

    while ($row = $result->fetch_assoc()) {
        $from=$row["{$field_prefix}_available_from"];
        $to=$row["{$field_prefix}_available_to"];
        $fromformatted=date("h:i A",strtotime($from));
        $toformatted=date("h:i A",strtotime($to));
        $items_html .= "
        <div class='col-md-4 mb-3'>
            <div class='card h-100'>
                <img src='admin/{$row["{$field_prefix}_image"]}' class='card-img-top' alt='{$row["{$field_prefix}_name"]}' style='height: 200px; object-fit: cover;'>
                <div class='card-body'>
                    <h4 class='heading'>{$row["{$field_prefix}_name"]}</h4>
                    <p><strong class='avail-add'>Avail From: </strong> {$fromformatted}</p>
                    <p><strong class='avail-add'>Avail To: </strong>{$toformatted}<p>
                </div>
            </div>
        </div>";
    }

    echo json_encode([
        'title' => ucfirst($category),
        'description' => "<div class='row'>$items_html</div>"
    ]);
} else {
    echo json_encode(['error' => 'No data found']);
}

$conn->close();
?>
