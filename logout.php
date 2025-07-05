<?php
// logout.php

// Check if session is not started, then start it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: login.php');
exit();
?>

// I first checked if a session was already active to avoid warnings
// Then I cleared all session data and destroyed it to log out the user securely
// Finally, I redirected the user back to login.php

