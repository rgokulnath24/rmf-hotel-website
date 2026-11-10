<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

require_once "db.php";

$username = $_SESSION['username'];

$categories = [
    'breakfast',
    'lunch',
    'snacks',
    'dinner'
];

$stats = [];

$totalItems = 0;

foreach ($categories as $category) {

    $statusColumn = $category . "_status";

    $result = $conn->query(
        "SELECT COUNT(*) AS total
         FROM `$category`
         WHERE `$statusColumn` = 1"
    );

    $count = 0;

    if ($result) {
        $row = $result->fetch_assoc();
        $count = (int)$row['total'];
    }

    $stats[$category] = $count;

    $totalItems += $count;
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard | RMF Admin</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="css/sidebar.css"
    >

    <link
        rel="stylesheet"
        href="css/dashboard-style.css"
    >

    <script
        src="js/sidebar-toggle.js"
        defer
    ></script>

</head>

<body>

<?php include "sidebar.php"; ?>


<main class="main-content">

    <div class="page-header">

        <div>

            <span class="page-eyebrow">
                OVERVIEW
            </span>

            <h1>
                Good morning,
                <span><?= htmlspecialchars($username) ?></span>
            </h1>

            <p>
                Manage your restaurant menu and keep
                today's offerings up to date.
            </p>

        </div>

        <a
            href="create_item.php"
            class="header-action"
        >
            <i class="fa-solid fa-plus"></i>
            Add Menu Item
        </a>

    </div>


    <section class="stats-grid">

        <div class="stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-utensils"></i>
            </div>

            <div>

                <span>
                    Active Menu Items
                </span>

                <strong>
                    <?= $totalItems ?>
                </strong>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-mug-hot"></i>
            </div>

            <div>

                <span>Breakfast</span>

                <strong>
                    <?= $stats['breakfast'] ?>
                </strong>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-bowl-food"></i>
            </div>

            <div>

                <span>Lunch</span>

                <strong>
                    <?= $stats['lunch'] ?>
                </strong>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-moon"></i>
            </div>

            <div>

                <span>Dinner</span>

                <strong>
                    <?= $stats['dinner'] ?>
                </strong>

            </div>

        </div>

    </section>


    <section class="quick-section">

        <div class="section-title">

            <div>
                <span>QUICK ACTIONS</span>
                <h2>Manage your menu</h2>
            </div>

        </div>


        <div class="quick-grid">

            <a
                href="create_item.php"
                class="quick-card"
            >

                <div>
                    <i class="fa-solid fa-plus"></i>
                </div>

                <h3>Add new item</h3>

                <p>
                    Add a dish to your menu with image,
                    category and availability.
                </p>

                <span>
                    Create item
                    <i class="fa-solid fa-arrow-right"></i>
                </span>

            </a>


            <a
                href="item_grid.php"
                class="quick-card"
            >

                <div>
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>

                <h3>Manage menu</h3>

                <p>
                    Edit existing dishes, update timings
                    or remove unavailable items.
                </p>

                <span>
                    Manage items
                    <i class="fa-solid fa-arrow-right"></i>
                </span>

            </a>


            <a
                href="../"
                target="_blank"
                class="quick-card"
            >

                <div>
                    <i class="fa-solid fa-globe"></i>
                </div>

                <h3>View website</h3>

                <p>
                    Preview the customer-facing website
                    and verify your menu updates.
                </p>

                <span>
                    Open website
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </span>

            </a>

        </div>

    </section>

</main>

</body>
</html>