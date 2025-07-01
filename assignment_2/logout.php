<?php
// Start session to access session variables
session_start();

// Clear all session variables
session_unset();
session_destroy();

// Redirect to home page
header('Location: index.php');
exit();
?>
