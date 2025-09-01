<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <link rel="icon" type="image/png" href="../images/logo-short.png">
  <title>RMF</title>
  <link rel="stylesheet" href="css/style.css"/>
  <script defer src="js/script.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>
  <div class="login-container">
    <form class="login-form" method="POST" action="login_credentials.php">
  <div class="logo-container">
     <div class="logo-zoom-wrapper">
     <img src="../images/logo.png" alt="logo" class="logo-image"/>
  </div>
  </div>
      <?php
           $username = $_COOKIE['remember_user'] ?? '';
      ?>

      <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="username" 
        value="<?php echo htmlspecialchars($username);?>" required />

      </div>

      <div class="input-group password-group">
        <label>Password</label>
        <input type="password" name="password1" id="password1" placeholder="password" required />
        <span class="toggle-password" onclick="togglePassword()">
          <i class="fas fa-eye"></i>
        </span>
      </div>

      <div class="options">
        <label id="remember"><input type="checkbox" name="remember">Remember Me</label>
        <!--<a href="#">Forgot Password?</a>-->
      </div>

      <button type="submit">Login</button>

      <!-- <p class="dark-mode-toggle">
       <i id="darkToggleIcon" class="fas fa-moon fa-lg toggle-icon"></i>
       </label>
      </p> -->
    </form>
  </div>
</body>
</html>
