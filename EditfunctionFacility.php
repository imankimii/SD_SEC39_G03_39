<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['AdminEmail'])) {
    header('Location: LogIn.php');
    exit();
}

// Include the database connection script
require_once "database_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form was submitted with the "EDIT FACILITY" button
    if (isset($_POST['edit_facility'])) {
        // Retrieve the facility data from the form and sanitize them
        $facilityType = mysqli_real_escape_string($conn, $_POST['facilityType']);
        $facilityPrice = mysqli_real_escape_string($conn, $_POST['facilityPrice']);
        $facilityAvailable = mysqli_real_escape_string($conn, $_POST['facilityAvailable']);
        $facilityDescription = mysqli_real_escape_string($conn, $_POST['facilityDescription']);

        // Update the facility data in the database
        $sql = "UPDATE facilities SET 
            facilityPrice = '$facilityPrice',
            facilityAvailable = '$facilityAvailable',
            facilityDescription = '$facilityDescription'
            WHERE facilityType = '$facilityType'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Facility data updated successfully
            header('Location: FacilityEdit.php'); // Replace with the actual page name
            exit();
        } else {
            // Error occurred while updating facility data
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>