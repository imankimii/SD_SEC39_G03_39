<?php
session_start();
require_once "database_connection.php";

// Check if facilityType is set in the POST data
if (isset($_POST['facilityType'])) {
    $facilityType = $_POST['facilityType'];

    // Construct the SQL DELETE statement
    $sql = "DELETE FROM facilities WHERE facilityType = '$facilityType'";

    // Execute the DELETE query
    if (mysqli_query($conn, $sql)) {
        echo "facility deleted successfully.";
    } else {
        echo "Error deleting facility: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>