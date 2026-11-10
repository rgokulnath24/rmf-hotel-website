<?php include "display_grid.php"; ?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Manage Menu | RMF Admin</title>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="css/sidebar.css"
    >

    <link
        rel="stylesheet"
        href="css/item_grid.css"
    >

</head>

<body>

<?php include "sidebar.php"; ?>


<main class="main-content">

    <div class="page-header">

        <div>

            <span>MENU MANAGEMENT</span>

            <h1>Manage Menu</h1>

            <p>
                Update, organize and remove menu items.
            </p>

        </div>

        <a
            href="create_item.php"
            class="add-btn"
        >
            <i class="fa-solid fa-plus"></i>
            Add Item
        </a>

    </div>


    <?php if (empty($data)): ?>

        <div class="empty-state">

            <i class="fa-solid fa-utensils"></i>

            <h2>No menu items yet</h2>

            <p>
                Start by adding your first dish.
            </p>

            <a href="create_item.php">
                Add Menu Item
            </a>

        </div>

    <?php else: ?>

        <?php

        $grouped = [];

        foreach ($data as $item) {

            $category = $item['category'];
            $type = strtolower(
                $item['display_type']
            );

            $grouped[$category][$type][] = $item;
        }

        ?>

        <?php foreach ($grouped as $category => $types): ?>

            <section class="category-section">

                <div class="category-header">

                    <div>

                        <span>
                            MENU CATEGORY
                        </span>

                        <h2>
                            <?= ucfirst($category) ?>
                        </h2>

                    </div>

                    <div class="category-count">

                        <?php

                        $count = 0;

                        foreach ($types as $items) {
                            $count += count($items);
                        }

                        ?>

                        <?= $count ?> items

                    </div>

                </div>


                <?php foreach ($types as $type => $items): ?>

                    <div class="type-section">

                        <h3
                            class="<?= $type === 'veg'
                                ? 'veg'
                                : 'nonveg' ?>"
                        >
                            <span></span>
                            <?= ucfirst($type) ?>
                        </h3>


                        <div class="item-grid">

                            <?php foreach ($items as $item): ?>

                                <?php

                                $prefix =
                                    $item['category'] . "_";

                                $id =
                                    (int)$item[
                                        $prefix . "id"
                                    ];

                                $name =
                                    htmlspecialchars(
                                        $item[
                                            $prefix . "name"
                                        ],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );

                                $image =
                                    htmlspecialchars(
                                        $item[
                                            $prefix . "image"
                                        ],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );

                                $from = date(
                                    "h:i A",
                                    strtotime(
                                        $item[
                                            $prefix .
                                            "available_from"
                                        ]
                                    )
                                );

                                $to = date(
                                    "h:i A",
                                    strtotime(
                                        $item[
                                            $prefix .
                                            "available_to"
                                        ]
                                    )
                                );

                                ?>

                                <article
                                    class="item-card"
                                    data-category="<?= $item['category'] ?>"
                                    data-id="<?= $id ?>"
                                >

                                    <div class="item-image">

                                        <img
                                            src="<?= $image ?>"
                                            alt="<?= $name ?>"
                                            loading="lazy"
                                        >

                                        <span class="status-badge">
                                            Active
                                        </span>

                                    </div>


                                    <div class="item-card-body">

                                        <div class="item-card-heading">

                                            <h4>
                                                <?= $name ?>
                                            </h4>

                                            <span
                                                class="food-type <?= $type ?>"
                                            >
                                                <?= ucfirst($type) ?>
                                            </span>

                                        </div>


                                        <div class="item-time">

                                            <i class="fa-regular fa-clock"></i>

                                            <?= $from ?>
                                            –
                                            <?= $to ?>

                                        </div>


                                        <div class="item-actions">

                                            <button
                                                type="button"
                                                class="edit-btn"
                                                onclick="editItem(
                                                    '<?= $item['category'] ?>',
                                                    <?= $id ?>
                                                )"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                                Edit
                                            </button>


                                            <button
                                                type="button"
                                                class="delete-btn"
                                                onclick="deleteItem(
                                                    '<?= $item['category'] ?>',
                                                    <?= $id ?>
                                                )"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                        </div>

                                    </div>

                                </article>

                            <?php endforeach; ?>

                        </div>

                    </div>

                <?php endforeach; ?>

            </section>

        <?php endforeach; ?>

    <?php endif; ?>

</main>


<!-- ================= EDIT MODAL ================= -->

<div
    class="edit-modal"
    id="editModal"
>

    <div class="edit-modal-card">

        <button
            class="modal-close"
            onclick="closeModal()"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="modal-heading">

            <span>MENU MANAGEMENT</span>

            <h2>Edit Menu Item</h2>

        </div>


        <form
            id="editForm"
            enctype="multipart/form-data"
        >

            <input
                type="hidden"
                name="category"
                id="editCategory"
            >

            <input
                type="hidden"
                name="id"
                id="editId"
            >


            <div class="edit-form-grid">

                <div class="edit-field full">

                    <label>Dish Name</label>

                    <input
                        type="text"
                        name="name"
                        id="editName"
                        maxlength="40"
                        required
                    >

                </div>


                <div class="edit-field">

                    <label>Food Type</label>

                    <select
                        name="type"
                        id="editType"
                        required
                    >

                        <option value="veg">
                            Veg
                        </option>

                        <option value="non-veg">
                            Non-Veg
                        </option>

                    </select>

                </div>


                <div class="edit-field">

                    <label>Available From</label>

                    <input
                        type="time"
                        name="from"
                        id="editFrom"
                        required
                    >

                </div>


                <div class="edit-field">

                    <label>Available To</label>

                    <input
                        type="time"
                        name="to"
                        id="editTo"
                        required
                    >

                </div>


                <div class="edit-field full">

                    <label>Replace Image</label>

                    <input
                        type="file"
                        name="image"
                        id="editImage"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                </div>

            </div>


            <div class="existing-image">

                <span>Current image</span>

                <img
                    id="existingImage"
                    src=""
                    alt="Current dish"
                >

            </div>


            <div class="modal-actions">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeModal()"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="save-btn"
                >
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11"
></script>

<script src="js/edit_modal.js"></script>

</body>
</html>