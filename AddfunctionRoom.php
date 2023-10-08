<?php
session_start();
require_once "database_connection.php";

if (isset($_POST['add_room'])) {
    // Retrieve form data
    $roomType = $_POST['roomType'];
    $roomNum = $_POST['roomNum'];
    $roomPrice = $_POST['roomPrice'];
    $roomQuantity = $_POST['roomQuantity'];
    $roomAvailable = $_POST['roomAvailable'];
    $roomDescription = $_POST['roomDescription'];

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO room (roomType, roomNum, roomPrice, roomQuantity, roomAvailable, roomDescription) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameters to the statement
        mysqli_stmt_bind_param($stmt, "ssiiis", $roomType, $roomNum, $roomPrice, $roomQuantity, $roomAvailable, $roomDescription);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Insertion successful, redirect to the same page or another page
            header("Location: RoomEdit.php"); // Replace with the actual page name
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
?>