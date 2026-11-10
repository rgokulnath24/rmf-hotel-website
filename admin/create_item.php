<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Menu Item | RMF Admin</title>

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
        href="css/create_item.css"
    >

</head>

<body>

<?php include "sidebar.php"; ?>


<main class="main-content">

    <div class="form-page-header">

        <div>

            <span>MENU MANAGEMENT</span>

            <h1>Add Menu Item</h1>

            <p>
                Create a new dish and publish it to
                the customer menu.
            </p>

        </div>

    </div>


    <form
        id="dishForm"
        class="item-form"
        method="POST"
        action="insert_item.php"
        enctype="multipart/form-data"
    >

        <div class="form-section">

            <div class="form-section-title">

                <i class="fa-solid fa-utensils"></i>

                <div>
                    <h2>Basic information</h2>
                    <p>Enter the dish details.</p>
                </div>

            </div>


            <div class="form-grid">

                <div class="form-field full">

                    <label for="name">
                        Dish Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        maxlength="40"
                        placeholder="Example: Masala Dosa"
                        required
                    >

                </div>


                <div class="form-field">

                    <label for="type">
                        Menu Category
                    </label>

                    <select
                        id="type"
                        name="type"
                        required
                    >

                        <option value="">
                            Select category
                        </option>

                        <option value="breakfast">
                            Breakfast
                        </option>

                        <option value="lunch">
                            Lunch
                        </option>

                        <option value="snacks">
                            Snacks
                        </option>

                        <option value="dinner">
                            Dinner
                        </option>

                    </select>

                </div>


                <div class="form-field">

                    <label for="veg_type">
                        Food Type
                    </label>

                    <select
                        id="veg_type"
                        name="veg_type"
                        required
                    >

                        <option value="">
                            Select type
                        </option>

                        <option value="veg">
                            Veg
                        </option>

                        <option value="non-veg">
                            Non-Veg
                        </option>

                    </select>

                </div>

            </div>

        </div>


        <div class="form-section">

            <div class="form-section-title">

                <i class="fa-regular fa-clock"></i>

                <div>
                    <h2>Availability</h2>
                    <p>Set when this item is available.</p>
                </div>

            </div>


            <div class="form-grid">

                <div class="form-field">

                    <label for="available_from">
                        Available From
                    </label>

                    <input
                        type="time"
                        id="available_from"
                        name="available_from"
                        value="08:00"
                        required
                    >

                </div>


                <div class="form-field">

                    <label for="available_to">
                        Available To
                    </label>

                    <input
                        type="time"
                        id="available_to"
                        name="available_to"
                        value="11:00"
                        required
                    >

                </div>

            </div>

        </div>


        <div class="form-section">

            <div class="form-section-title">

                <i class="fa-regular fa-image"></i>

                <div>
                    <h2>Dish image</h2>
                    <p>
                        Upload a clear image of the dish.
                    </p>
                </div>

            </div>


            <div class="upload-box">

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    required
                >

                <label for="image">

                    <i class="fa-solid fa-cloud-arrow-up"></i>

                    <strong>
                        Click to upload image
                    </strong>

                    <span>
                        JPG, PNG or WEBP • Max 5MB
                    </span>

                </label>

                <img
                    id="preview"
                    class="image-preview"
                    alt="Image preview"
                >

            </div>

        </div>


        <div class="form-actions">

            <a
                href="item_grid.php"
                class="cancel-btn"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="submit-btn"
            >
                <i class="fa-solid fa-plus"></i>
                Create Menu Item
            </button>

        </div>

    </form>

</main>


<script src="js/create_item.js"></script>

</body>
</html>