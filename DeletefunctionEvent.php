<?php
session_start();
require_once "database_connection.php";

if (isset($_GET['eventType'])) {
    $eventType = $_GET['eventType'];

    // Include your database connection code here

    // Perform the delete operation
    $sql = "DELETE FROM events WHERE eventType = '$eventType'"; // Replace with your table name
    if (mysqli_query($conn, $sql)) {
        // Deletion successful, redirect to the same page or another page
        header("Location: eventEdit.php"); // Replace with the actual page name where your facilities table is displayed
        exit();
    } else {
        // Deletion failed, display an error message or handle it accordingly
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>