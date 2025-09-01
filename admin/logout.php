<?php
session_start();
session_destroy();

// setcookie("remember_user", "", time() - 3600, "/"); // delete cookie
// setcookie("remember_user",'$username',time()+(86400*7)))
header("Location: login.php");
exit;
?>
