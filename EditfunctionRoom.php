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
    // Check if the form was submitted with the "EDIT ROOM" button
    if (isset($_POST['edit_room'])) {
        // Retrieve the room data from the form and sanitize them
        $roomType = mysqli_real_escape_string($conn, $_POST['roomType']);
        $roomNum = mysqli_real_escape_string($conn, $_POST['roomNum']);
        $roomPrice = mysqli_real_escape_string($conn, $_POST['roomPrice']);
        $roomQuantity = mysqli_real_escape_string($conn, $_POST['roomQuantity']);
        $roomAvailable = mysqli_real_escape_string($conn, $_POST['roomAvailable']);
        $roomDescription = mysqli_real_escape_string($conn, $_POST['roomDescription']);

        // Update the room data in the database
        $sql = "UPDATE room SET 
            roomNum = '$roomNum',
            roomPrice = '$roomPrice',
            roomQuantity = '$roomQuantity',
            roomAvailable = '$roomAvailable',
            roomDescription = '$roomDescription'
            WHERE roomType = '$roomType'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Room data updated successfully
            header('Location: RoomEdit.php'); // Replace with the actual page name
            exit();
        } else {
            // Error occurred while updating room data
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>