// document.querySelectorAll('.scroll-link').forEach(link => {
//     link.addEventListener('click', function(e) {
//         e.preventDefault(); // prevent default # in URL
//         const targetID = this.getAttribute('href').substring(1); // remove #
//         const targetElement = document.getElementById(targetID);
//         if(targetElement){
//             targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
//         }
//     });
// });
document.addEventListener("DOMContentLoaded", () => {
  /* ========== Underline Animation on Scroll ========== */
  const underlines = document.querySelectorAll(".underline-animate");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("active"); // trigger animation
        }
      });
    },
    { threshold: 0.5 } // trigger when 50% is visible
  );

  underlines.forEach(el => observer.observe(el));

  /* ========== Contact Form AJAX Submit ========== */
  const contactForm = document.getElementById("contactForm");
  if (contactForm) {
    contactForm.addEventListener("submit", function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      
      fetch("submit_contact_form.php", {
        method: "POST",
        body: formData
      })
      .then(response => {
        if (!response.ok) throw new Error("Something went wrong");
        return response.text();
      })
      .then(data => {
        Swal.fire("Thank You!", "Your response has been recorded.", "success");
        this.reset();
      })
      .catch(() => {
        Swal.fire("Oops!", "Submission failed. Try again later.", "error");
      });
    });
  }

  /* ========== Swiper Slider ========== */
  if (document.querySelector(".mySwiper")) {
    const swiper = new Swiper(".mySwiper", {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 20,
      speed: 800,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        768: { slidesPerView: 2 },
        992: { slidesPerView: 3 },
      },
    });
  }

  /* ========== Specials Modal Fetch ========== */
  document.querySelectorAll('.open-modal').forEach(card => {
    card.addEventListener('click', () => {
      const category = card.getAttribute('data-category');
      
      fetch('fetch_special.php?category=' + category)
        .then(response => response.json())
        .then(data => {
          document.getElementById('modalContent').innerHTML = `
            <img src="images/${data.image}" class="img-fluid mb-3" alt="${data.title}" />
            <p>${data.description}</p>
          `;
          const modal = new bootstrap.Modal(document.getElementById('specialModal'));
          modal.show();
        });
    });
  });

  /* ========== Hero Background Slideshow with Fade ========== */
  const hero = document.querySelector('.hero-section');
  if (hero) {
    const images = [
      "images/content-1.jpeg",
      "images/content-2.jpeg",
      "images/content-3.jpeg"
    ];
    let index = 0;

    const fadeLayer = document.createElement('div');
    fadeLayer.style.position = 'absolute';
    fadeLayer.style.inset = '0';
    fadeLayer.style.backgroundSize = 'cover';
    fadeLayer.style.backgroundPosition = 'center';
    fadeLayer.style.transition = 'opacity 1s ease-in-out';
    fadeLayer.style.zIndex = '0';
    fadeLayer.style.opacity = '0';
    hero.appendChild(fadeLayer);

    // First image
    hero.style.backgroundImage = `url('${images[index]}')`;

    setInterval(() => {
      fadeLayer.style.backgroundImage = `url('${images[(index + 1) % images.length]}')`;
      fadeLayer.style.opacity = '1';

      setTimeout(() => {
        hero.style.backgroundImage = fadeLayer.style.backgroundImage;
        fadeLayer.style.opacity = '0';
      }, 1000);

      index = (index + 1) % images.length;
    }, 4000);
  }
});
