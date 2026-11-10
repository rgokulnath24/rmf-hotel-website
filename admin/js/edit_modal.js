async function editItem(category, id) {

    const modal =
        document.getElementById("editModal");

    modal.classList.add("active");

    document.getElementById(
        "editCategory"
    ).value = category;

    document.getElementById(
        "editId"
    ).value = id;

    try {

        const formData =
            new URLSearchParams();

        formData.append(
            "category",
            category
        );

        formData.append(
            "id",
            id
        );

        const response =
            await fetch(
                "get_item.php",
                {
                    method: "POST",
                    headers: {
                        "Content-Type":
                            "application/x-www-form-urlencoded"
                    },
                    body: formData
                }
            );

        const item =
            await response.json();

        if (!item.name) {

            throw new Error(
                "Unable to load item."
            );

        }

        document.getElementById(
            "editName"
        ).value = item.name;

        document.getElementById(
            "editType"
        ).value =
            item.type.toLowerCase();

        document.getElementById(
            "editFrom"
        ).value = item.from;

        document.getElementById(
            "editTo"
        ).value = item.to;

        document.getElementById(
            "existingImage"
        ).src = item.image;

    } catch (error) {

        closeModal();

        Swal.fire(
            "Error",
            "Unable to load menu item.",
            "error"
        );

    }

}


function closeModal() {

    document
        .getElementById("editModal")
        .classList.remove("active");

}


async function deleteItem(category, id) {

    const result =
        await Swal.fire({

            title: "Remove menu item?",

            text:
                "This item will no longer appear on the public menu.",

            icon: "warning",

            showCancelButton: true,

            confirmButtonText:
                "Yes, remove it",

            cancelButtonText:
                "Cancel",

            reverseButtons: true

        });


    if (!result.isConfirmed) {
        return;
    }


    try {

        const body =
            new URLSearchParams();

        body.append(
            "category",
            category
        );

        body.append(
            "id",
            id
        );

        const response =
            await fetch(
                "delete_item.php",
                {
                    method: "POST",
                    headers: {
                        "Content-Type":
                            "application/x-www-form-urlencoded"
                    },
                    body
                }
            );

        const message =
            await response.text();

        if (!response.ok) {
            throw new Error(message);
        }

        await Swal.fire(
            "Removed",
            message,
            "success"
        );

        location.reload();

    } catch (error) {

        Swal.fire(
            "Error",
            error.message ||
            "Unable to remove item.",
            "error"
        );

    }

}


/* ================= EDIT SUBMIT ================= */

document
    .getElementById("editForm")
    ?.addEventListener(
        "submit",
        async event => {

            event.preventDefault();

            const from =
                document.getElementById(
                    "editFrom"
                ).value;

            const to =
                document.getElementById(
                    "editTo"
                ).value;

            if (from >= to) {

                Swal.fire(
                    "Invalid time",
                    "Available To must be later than Available From.",
                    "warning"
                );

                return;
            }

            const form =
                event.target;

            const button =
                form.querySelector(
                    ".save-btn"
                );

            button.disabled = true;

            button.textContent =
                "Saving...";


            try {

                const response =
                    await fetch(
                        "update_item.php",
                        {
                            method: "POST",
                            body:
                                new FormData(form)
                        }
                    );

                const message =
                    await response.text();

                if (!response.ok) {
                    throw new Error(message);
                }

                await Swal.fire(
                    "Updated",
                    message,
                    "success"
                );

                location.reload();

            } catch (error) {

                Swal.fire(
                    "Update failed",
                    error.message ||
                    "Unable to update item.",
                    "error"
                );

            } finally {

                button.disabled = false;

                button.textContent =
                    "Save Changes";

            }

        }
    );


/* ================= CLOSE ON OUTSIDE CLICK ================= */

document
    .getElementById("editModal")
    ?.addEventListener(
        "click",
        event => {

            if (
                event.target.id ===
                "editModal"
            ) {
                closeModal();
            }

        }
    );