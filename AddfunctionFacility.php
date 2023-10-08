<?php
session_start();
require_once "database_connection.php";

if (isset($_POST['add_facility'])) {
    // Retrieve form data
    $facilityType = $_POST['facilityType'];
    $facilityPrice = $_POST['facilityPrice'];
    $facilityAvailable = $_POST['facilityAvailable'];
    $facilityDescription = $_POST['facilityDescription'];

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO facilities (facilityType, facilityPrice, facilityAvailable, facilityDescription) 
            VALUES (?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameters to the statement
        mysqli_stmt_bind_param($stmt, "ssss", $facilityType, $facilityPrice, $facilityAvailable, $facilityDescription);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Insertion successful, redirect to the same page or another page
            header("Location: FacilityEdit.php"); // Replace with the actual page name
            exit();
        } else {
            // Insertion failed, display an error message or handle it accordingly
            echo "Error: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Statement preparation failed, display an error message or handle it accordingly
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($conn);
?>