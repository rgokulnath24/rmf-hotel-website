document.addEventListener("DOMContentLoaded", () => {

    const imageInput =
        document.getElementById("image");

    const preview =
        document.getElementById("preview");

    const form =
        document.getElementById("dishForm");


    imageInput?.addEventListener("change", event => {

        const file =
            event.target.files[0];

        if (!file) return;

        const allowedTypes = [
            "image/jpeg",
            "image/png",
            "image/webp"
        ];

        if (!allowedTypes.includes(file.type)) {

            alert(
                "Please select a JPG, PNG or WEBP image."
            );

            imageInput.value = "";

            return;
        }

        if (file.size > 5 * 1024 * 1024) {

            alert(
                "Image size must be less than 5MB."
            );

            imageInput.value = "";

            return;
        }

        const reader =
            new FileReader();

        reader.onload = event => {

            preview.src =
                event.target.result;

            preview.style.display =
                "block";

        };

        reader.readAsDataURL(file);

    });


    form?.addEventListener("submit", event => {

        const from =
            document.getElementById(
                "available_from"
            ).value;

        const to =
            document.getElementById(
                "available_to"
            ).value;

        if (from >= to) {

            event.preventDefault();

            alert(
                "Available To must be later than Available From."
            );

        }

    });

});