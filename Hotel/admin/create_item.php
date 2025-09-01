<?php
session_start();
if(!isset($_SESSION['username']))
{
header("Location: login.php");
}
$username=$_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/png" href="../images/logo-short.png"/>
  <title>Dashboard - RMF</title>
  <!--font awesome cdn file-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="css/sidebar.css"/>
<link rel="stylesheet" href="css/create_item.css"/>
<script src="js/sidebar-toggle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
 <?php include("sidebar.php")?>

  <!-- Main Content -->
  <div class="main-content" id="mainContent">
  <div class="logo-container">
  <div class="logo-zoom-wrapper">
    <img src="../images/logo.png" alt="logo" class="logo-image"/>
  </div>
</div>
    <form id="dishForm" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">Dish Name</label>
        <input type="text" id="name" name="name" required maxlength="40"/>
      </div>

      <div class="form-group">
        <label for="type">Type</label>
        <select id="type" name="type" required>
          <option value="">-- Select Type --</option>
          <option value="breakfast">Breakfast</option>
          <option value="lunch">Lunch</option>
          <option value="snacks">Snacks</option>
          <option value="dinner">Dinner</option>
        </select>
      </div>

      <div class="form-group">
        <label for="veg_type">Veg / Non-Veg</label>
        <select id="veg_type" name="veg_type" required>
          <option value="">-- Select Category --</option>
          <option value="veg">Veg</option>
          <option value="non-veg">Non-Veg</option>
        </select>
      </div>

      <div class="form-group">
        <label for="available_from">Available From</label>
        <input type="time" id="available_from" name="available_from" 
   value="10:00" required/>
      </div>

      <div class="form-group">
        <label for="available_to">Available To</label>
        <input type="time" id="available_to" name="available_to" 
        value="18:00" required/>
      </div>

      <div class="form-group">
        <label for="image">Image</label>
        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)" required/>
        <img id="preview" class="image-preview" />
      </div>

      <button type="submit">Submit</button>
    </form>
  </div>
</body>
<script src="js/create_item.js"></script>
</html>
