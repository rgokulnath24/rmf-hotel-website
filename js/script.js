document.addEventListener("DOMContentLoaded", () => {

    /* ================= NAVBAR ================= */

    const navbar = document.querySelector(".navbar");

    window.addEventListener("scroll", () => {

        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }

    });


    /* ================= REVEAL ================= */

    const revealElements =
        document.querySelectorAll(".reveal");

    const observer = new IntersectionObserver(
        entries => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {

                    entry.target.classList.add("active");

                    observer.unobserve(entry.target);

                }

            });

        },
        {
            threshold: 0.15
        }
    );

    revealElements.forEach(element => {
        observer.observe(element);
    });


    /* ================= MENU SLIDER ================= */

    if (document.querySelector(".menuSwiper")) {

        new Swiper(".menuSwiper", {

            loop: true,

            spaceBetween: 24,

            speed: 700,

            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },

            breakpoints: {

                0: {
                    slidesPerView: 1
                },

                768: {
                    slidesPerView: 2
                },

                992: {
                    slidesPerView: 3
                }

            }

        });

    }


    /* ================= MENU MODAL ================= */

    const menuCards =
        document.querySelectorAll(".open-modal");

    menuCards.forEach(card => {

        card.addEventListener("click", async () => {

            const category =
                card.dataset.category;

            const modal =
                new bootstrap.Modal(
                    document.getElementById("specialModal")
                );

            const modalTitle =
                document.getElementById("modalTitle");

            const modalContent =
                document.getElementById("modalContent");

            modalTitle.textContent =
                category.charAt(0).toUpperCase()
                + category.slice(1);

            modalContent.innerHTML = `
                <div class="loading-state">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    Loading menu...
                </div>
            `;

            modal.show();

            try {

                const response =
                    await fetch(
                        `fetch_special.php?category=${encodeURIComponent(category)}`
                    );

                const data =
                    await response.json();

                if (data.error) {

                    modalContent.innerHTML = `
                        <div class="alert alert-warning">
                            ${escapeHtml(data.error)}
                        </div>
                    `;

                    return;
                }

                modalContent.innerHTML =
                    data.description;

            } catch (error) {

                modalContent.innerHTML = `
                    <div class="alert alert-danger">
                        Unable to load menu.
                        Please try again.
                    </div>
                `;

            }

        });

    });


    /* ================= CONTACT FORM ================= */

    const contactForm =
        document.getElementById("contactForm");

    if (contactForm) {

        contactForm.addEventListener(
            "submit",
            async event => {

                event.preventDefault();

                const button =
                    contactForm.querySelector(
                        ".submit-btn"
                    );

                const status =
                    document.getElementById(
                        "formStatus"
                    );

                button.disabled = true;

                button.innerHTML = `
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    Sending...
                `;

                try {

                    const response =
                        await fetch(
                            "submit_contact_form.php",
                            {
                                method: "POST",
                                body: new FormData(contactForm)
                            }
                        );

                    const data =
                        await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(
                            data.message ||
                            "Submission failed"
                        );
                    }

                    contactForm.reset();

                    status.textContent =
                        "Message sent successfully.";

                    status.style.color =
                        "#536f45";

                } catch (error) {

                    status.textContent =
                        error.message ||
                        "Something went wrong.";

                    status.style.color =
                        "#c0392b";

                } finally {

                    button.disabled = false;

                    button.innerHTML = `
                        Send Message
                        <i class="fa-solid fa-paper-plane"></i>
                    `;

                }

            }
        );

    }


    /* ================= HELPERS ================= */

    function escapeHtml(value) {

        const div =
            document.createElement("div");

        div.textContent = value;

        return div.innerHTML;

    }

});