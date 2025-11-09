<?php
// Resume session 
session_start();
// Clear all vaiables in current session
session_unset();
// Remove data session 
session_destroy();
// Return back to the login page
header("Location: admin_login.php");
exit;
?>