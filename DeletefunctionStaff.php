<?php
session_start();
require_once "database_connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Debugging code to print the received 'id' value
    echo "ID to delete: " . $id;

    // Include your database connection code here

    // Perform the delete operation
    $sql = "DELETE FROM staff WHERE StaffID = '$id'"; // Replace with your table name
    if (mysqli_query($conn, $sql)) {
        // Deletion successful, redirect to the same page
        header("Location: Stafftable.php"); // Replace with the actual page name
        exit();
    } else {
        // Deletion failed, display an error message or handle it accordingly
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>