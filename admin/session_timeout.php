<?php
session_start();

// Set session timeout to 2 hours (7200 seconds)
$timeout_duration = 7200;

// Check if the session is set
if (isset($_SESSION['last_activity'])) {
    // Calculate the session lifetime
    $elapsed_time = time() - $_SESSION['last_activity'];

    // If the session has expired (more than 2 hours), destroy it
    if ($elapsed_time > $timeout_duration) {
        session_unset();     // Unset session variables
        session_destroy();   // Destroy the session
        header("Location: ../index.php?timeout=true"); // Redirect to login page
        exit();
    }
}

// Update the last activity time stamp
$_SESSION['last_activity'] = time();
?>
