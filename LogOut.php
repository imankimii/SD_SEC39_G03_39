<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['CustEmail'])) {
    // User is logged in, so we can log them out
    session_destroy(); // Destroy the session data
    header("Location: index.php"); // Redirect to the homepage or any other desired page after logout
    exit(); // Make sure no further code execution happens after the redirect
} else {
    // If the user is not logged in, there's no need to log them out
    header("Location: index.php"); // Redirect to the homepage or any other desired page
    exit(); // Make sure no further code execution happens after the redirect
}
?>