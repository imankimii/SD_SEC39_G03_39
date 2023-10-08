<?php
session_start();
require_once "database_connection.php";

// Check if roomType is set in the POST data
if (isset($_POST['roomType'])) {
    $roomType = $_POST['roomType'];

    // Construct the SQL DELETE statement
    $sql = "DELETE FROM room WHERE roomType = '$roomType'";

    // Execute the DELETE query
    if (mysqli_query($conn, $sql)) {
        echo "Room deleted successfully.";
    } else {
        echo "Error deleting room: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>