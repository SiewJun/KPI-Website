<?php
session_start();

// Clear the "Remember me" cookie
setcookie('remember_user', '', time() - 3600, '/'); // Set the expiration time to the past

// Destroy the session
session_destroy();
session_regenerate_id(true);

header("Location: login.php");
exit();
?>
