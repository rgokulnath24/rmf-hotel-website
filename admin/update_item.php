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

$name =
    trim(
        $_POST['name'] ?? ''
    );

$type =
    strtolower(
        trim($_POST['type'] ?? '')
    );

$from =
    $_POST['from'] ?? '';

$to =
    $_POST['to'] ?? '';

$validTables = [
    'breakfast',
    'lunch',
    'snacks',
    'dinner'
];

if (
    !in_array($category, $validTables, true) ||
    !$id ||
    $name === ''
) {

    http_response_code(400);

    echo "Invalid data.";

    exit;
}

if (
    !in_array(
        $type,
        ['veg', 'non-veg'],
        true
    )
) {

    http_response_code(400);

    echo "Invalid food type.";

    exit;
}

if ($from >= $to) {

    http_response_code(400);

    echo "Invalid availability time.";

    exit;
}

$prefix = $category . "_";

$idColumn = $prefix . "id";
$nameColumn = $prefix . "name";
$typeColumn = $prefix . "type";
$fromColumn = $prefix . "available_from";
$toColumn = $prefix . "available_to";
$imageColumn = $prefix . "image";

$imagePath = null;


/* ================= IMAGE ================= */

if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
) {

    if (
        $_FILES['image']['error']
        !== UPLOAD_ERR_OK
    ) {

        die("Image upload failed.");
    }

    if (
        $_FILES['image']['size']
        > 5 * 1024 * 1024
    ) {

        die("Image must be less than 5MB.");
    }

    $imageInfo =
        getimagesize(
            $_FILES['image']['tmp_name']
        );

    if ($imageInfo === false) {
        die("Invalid image.");
    }

    $allowedMimeTypes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];

    if (
        !isset(
            $allowedMimeTypes[
                $imageInfo['mime']
            ]
        )
    ) {

        die(
            "Only JPG, PNG and WEBP images are allowed."
        );
    }

    $extension =
        $allowedMimeTypes[
            $imageInfo['mime']
        ];

    $uploadDir =
        __DIR__ . "/items_images/";

    if (!is_dir($uploadDir)) {

        mkdir(
            $uploadDir,
            0755,
            true
        );
    }

    $fileName =
        bin2hex(
            random_bytes(16)
        )
        . "."
        . $extension;

    $fullPath =
        $uploadDir . $fileName;

    if (
        !move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $fullPath
        )
    ) {

        die("Unable to upload image.");
    }

    $imagePath =
        "items_images/" . $fileName;
}


/* ================= UPDATE ================= */

if ($imagePath !== null) {

    $sql = "
        UPDATE `$category`
        SET
            `$nameColumn` = ?,
            `$typeColumn` = ?,
            `$fromColumn` = ?,
            `$toColumn` = ?,
            `$imageColumn` = ?
        WHERE `$idColumn` = ?
    ";

    $stmt =
        $conn->prepare($sql);

    $stmt->bind_param(
        "sssssi",
        $name,
        $type,
        $from,
        $to,
        $imagePath,
        $id
    );

} else {

    $sql = "
        UPDATE `$category`
        SET
            `$nameColumn` = ?,
            `$typeColumn` = ?,
            `$fromColumn` = ?,
            `$toColumn` = ?
        WHERE `$idColumn` = ?
    ";

    $stmt =
        $conn->prepare($sql);

    $stmt->bind_param(
        "ssssi",
        $name,
        $type,
        $from,
        $to,
        $id
    );
}


if (!$stmt->execute()) {

    http_response_code(500);

    echo "Unable to update item.";

    exit;
}

$stmt->close();
$conn->close();

echo "Item updated successfully.";