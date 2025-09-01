<?php include("display_grid.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="../images/logo-short.png" />
<title>Dashboard - RMF</title>
<link rel="stylesheet" href="css/sidebar.css"/>
<link rel="stylesheet" href="css/item_grid.css"/>
<script src="js/sidebar-toggle.js"></script>
<script src="js/edit_modal.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
  <?php include("sidebar.php") ?>
  <div class="main-content" id="mainContent">
    <div class="logo-container">
      <div class="logo-zoom-wrapper">
        <img src="../images/logo.png" alt="logo" class="logo-image" />
      </div>
    </div>
    <div class="meals-container" id="mealsContainer"></div>
  </div>

 </body>
<script>
    const meals = <?php echo json_encode($data); ?>;
    const container = document.getElementById("mealsContainer");
    const grouped = {};

    meals.forEach(meal => {
      const { category, type } = meal;
      if (!grouped[category]) grouped[category] = {};
      if (!grouped[category][type]) grouped[category][type] = [];
      grouped[category][type].push(meal);
    });

    for (let category in grouped) {
      const categoryDiv = document.createElement("div");
      categoryDiv.innerHTML = `<h2>${category}</h2>`;

      for (let type in grouped[category]) {
        const typeWrapper = document.createElement("div");
        const typeHeading=document.createElement("h3");
        typeHeading.className = type.toLowerCase() === "veg" ? "veg-heading" : "nonveg-heading";
// typeDiv.innerHTML = `<h3 class="${typeClass.trim()}">${type}</h3><br>`;

        typeHeading.textContent = type;
        const typeDiv=document.createElement("div");
        typeDiv.className='grid';
        grouped[category][type].forEach(item => {
          const name = item[category.toLowerCase() + "_name"];
          const img = item[category.toLowerCase() + "_image"];
          const id = item[category.toLowerCase() + "_id"];
        function formatTime24To12(timeStr) {
          const [hour, minute] = timeStr.split(":");
          let h = parseInt(hour);
          const ampm = h >= 12 ? "PM" : "AM";
          h = h % 12 || 12; // Convert 0 to 12
          const formattedHour = h.toString().padStart(2, '0');
          const formattedMinute = minute.padStart(2, '0');
          return `${formattedHour}:${formattedMinute} ${ampm}`;
        }

          const rawFrom = item[category.toLowerCase() + "_available_from"];
          const rawTo = item[category.toLowerCase() + "_available_to"];
          const avail_from = formatTime24To12(rawFrom);
          const avail_to = formatTime24To12(rawTo);
          typeDiv.innerHTML += `
            <div class="card">
              <img src="${img}" alt="${name}">
             <p><strong>${name}</strong></p>
             <p><strong><label class="avail-from">Avail From:</label></strong> ${avail_from}</p>
             <p><strong><label class="avail-to">Avail To:</label></strong> ${avail_to}</p>
              <div class="actions">
                <button onclick="editItem('${category}', ${id})">Edit</button>
                <button onclick="deleteItem('${category}', ${id})">Delete</button>
              </div>
            </div>
          `;
        });
        typeWrapper.appendChild(typeHeading);
        typeWrapper.appendChild(typeDiv);
        categoryDiv.appendChild(typeWrapper);
      }

      container.appendChild(categoryDiv);
    }

  
    function deleteItem(category, id) {
      Swal.fire({
        title: "Are you sure?",
        text: "Delete this item?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("delete_item.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `category=${category}&id=${id}`
          })
          .then(res => res.text())
          .then(data => {
            Swal.fire("Deleted!", data, "success").then(() => location.reload());
          });
        }
      });
    }

</script>
<div id="editModal" class="modal">
  <div class="modal-content">
    <span onclick="closeModal()" class="close-btn1">&times;</span>
    <h2><center>Edit Meal</center></h2>
    <form id="editForm" method="post" enctype="multipart/form-data">
      <input type="hidden" name="category" id="editCategory">
      <input type="hidden" name="id" id="editId">

      <label for="editName">Name:</label>
      <input type="text" name="name" id="editName" required maxlength="40">

      <label for="editType">Type:</label>
      <select name="type" id="editType" required>
        <option value="Veg">Veg</option>
        <option value="Non-Veg">Non-Veg</option>
      </select>

      <label for="editFrom">Available From:</label>
      <input type="time" name="from" id="editFrom" required>

      <label for="editTo">Available To:</label>
      <input type="time" name="to" id="editTo" required>

     <label for="editImage">Image:</label>
    <input type="file" name="image" id="editImage" onchange="previewImage(event)">

    <!-- Old image preview -->
    <div id="oldImagePreview" style="margin-top: 10px;">
      <p><strong>Current Image:</strong></p>
      <br>
      <img id="existingImage" src="" alt="No image">
      <br>
    </div>

      <div class="button-group">
        <button type="submit" class="update-btn">Update</button>
        <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

</div>
</html>