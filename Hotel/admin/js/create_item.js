function previewImage(event) {
  const preview = document.getElementById("preview");
  preview.src = URL.createObjectURL(event.target.files[0]);
  preview.style.display = "block";
}

document.getElementById("dishForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = document.getElementById("dishForm");
  const formData = new FormData(form);

  fetch("insert_item.php", {
    method: "POST",
    body: formData,
  })
    .then(response => response.text())
    .then(data => {
      // Normalize text (remove HTML tags if present)
      const cleanText = data.replace(/<[^>]*>/g, "").trim();

      // ✅ If PHP sent an error (contains 'error', 'invalid', 'failed', or <p style="red">)
      if (
        data.toLowerCase().includes("error") ||
        data.toLowerCase().includes("invalid") ||
        data.toLowerCase().includes("failed") ||
        data.toLowerCase().includes("❌") ||
        data.toLowerCase().includes("red")
      ) {
        Swal.fire({
          title: "Error!",
          text: cleanText,
          icon: "error",
          confirmButtonColor: "#e74c3c"
        });
      } else {
        Swal.fire({
          title: "Success!",
          text: cleanText,
          icon: "success",
          confirmButtonColor: "#2ecc71"
        });

        // Clear form only on success
        form.reset();
        document.getElementById("preview").style.display = "none";
      }
    })
    .catch(error => {
      console.error("Error:", error);
      Swal.fire({
        title: "Error!",
        text: "Something went wrong. Please try again.",
        icon: "error",
        confirmButtonColor: "#e74c3c"
      });
    });
});
