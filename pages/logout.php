<?php
session_start(); // Start a new session or resume the existing session
session_unset(); // Unset all session variables to clear any stored user data
session_destroy(); // Destroy the current session to log out the user
echo "You have been logged out."; // Display a logout confirmation message
header("Location: index.php"); // Redirect the user to the homepage after logging out
exit;
?>