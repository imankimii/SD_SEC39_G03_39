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
    // Check if the form was submitted with the "EDIT ABOUT US" button
    if (isset($_POST['edit_about'])) {
        // Retrieve the About Us data from the form and sanitize them
        $aboutDescription = mysqli_real_escape_string($conn, $_POST['aboutDescription']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);

        // Assuming you want to update the first (or a specific) row in the 'aboutus' table
        $sql = "UPDATE aboutus SET 
            AboutDescription = '$aboutDescription',
            date = '$date'
            LIMIT 1"; // Limit to updating only the first row

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // About Us data updated successfully
            header('Location: ContactUsEdit.php'); // Replace with the actual page name
            exit();
        } else {
            // Error occurred while updating About Us data
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>