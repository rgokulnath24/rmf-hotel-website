document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("editForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("update_item.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.text())
    .then(data => {
      if (data.toLowerCase().includes("successfully")) {
        Swal.fire(" Success!", data, "success").then(() => {
          location.reload();
        });
      } else {
        Swal.fire("Error!", data, "error");
      }
    })
    .catch(error => {
      console.error("Fetch error:", error);
      Swal.fire("Error!", "Update failed", "error");
    });
  });
});


function editItem(category, id) {
  fetch("get_item.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `category=${category}&id=${id}`
  })
  .then(res => res.json())
  .then(data => {
    document.getElementById("editCategory").value = category;
    document.getElementById("editId").value = id;
    document.getElementById("editName").value = data.name;
    let rawType = data.type.trim().toLowerCase(); // normalize
    let finalType = (rawType.includes("non") ? "Non-Veg" : "Veg");

    document.getElementById("editType").value = finalType;
    document.getElementById("editFrom").value = data.from;
    document.getElementById("editTo").value = data.to;
    document.getElementById('existingImage').src=data.image;
    document.getElementById("editModal").style.display = "block";
  });
}
function closeModal() {
  document.getElementById("editModal").style.display = "none";
}
function previewImage(event) {
  const file = event.target.files[0];
  const reader = new FileReader();

  reader.onload = function(e) {
    document.getElementById('existingImage').src = e.target.result;
  };

  if (file) {
    reader.readAsDataURL(file);
  }

}

