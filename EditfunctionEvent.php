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
    // Check if the form was submitted with the "EDIT event" button
    if (isset($_POST['edit_event'])) {
        // Retrieve the event data from the form and sanitize them
        $eventType = mysqli_real_escape_string($conn, $_POST['eventType']);
        $eventPrice = mysqli_real_escape_string($conn, $_POST['eventPrice']);
        $eventAvailable = mysqli_real_escape_string($conn, $_POST['eventAvailable']);
        $eventDescription = mysqli_real_escape_string($conn, $_POST['eventDescription']);

        // Update the event data in the database
        $sql = "UPDATE events SET 
            eventPrice = '$eventPrice',
            eventAvailable = '$eventAvailable',
            eventDescription = '$eventDescription'
            WHERE eventType = '$eventType'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // event data updated successfully
            header('Location: eventEdit.php'); // Replace with the actual page name
            exit();
        } else {
            // Error occurred while updating event data
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>