<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/png" href="../images/logo-short.png"/>
  <title>Dashboard - RMF</title>
  <link rel="stylesheet" href="css/dashboard-style.css" />
  <!--font awesome cdn file-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="css/sidebar.css"/>
<script src="js/sidebar-toggle.js"></script>
</head>
<body>
 <?php include("sidebar.php")?>

  <!-- Main content -->
  <div class="main-content" id="mainContent">
  <div class="main-content-welcome">
<img src="../images/logo.png" alt="logo" class="logo-image"/>
<h1>Welcome back,<span id="username"> <?php echo htmlspecialchars($username); ?></span></h1>
<p>You can manage your profile, update display details, and oversee the system settings here.</p>
  </div>
  </div>
</body>
</html>
