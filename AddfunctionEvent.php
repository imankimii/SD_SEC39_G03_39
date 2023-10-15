<?php
session_start();
require_once "database_connection.php";

if (isset($_POST['add_event'])) {
    // Retrieve form data
    $eventType = $_POST['eventType'];
    $eventPrice = $_POST['eventPrice'];
    $eventAvailable = $_POST['eventAvailable'];
    $eventDescription = $_POST['eventDescription'];

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO events (eventType, eventPrice, eventAvailable, eventDescription) 
            VALUES (?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameters to the statement
        mysqli_stmt_bind_param($stmt, "ssss", $eventType, $eventPrice, $eventAvailable, $eventDescription);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Insertion successful, redirect to the same page or another page
            header("Location: eventEdit.php"); // Replace with the actual page name
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