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
    // Check if the form was submitted with the "EDIT CONTACT US" button
    if (isset($_POST['edit_contact'])) {
        // Retrieve the contact data from the form and sanitize them
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // Update the contact data in the database
        $sql = "UPDATE contactus SET 
            phone = '$phone',
            email = '$email'
            WHERE address = '$address'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Contact data updated successfully
            header('Location: ContactUsEdit.php'); // Replace with the actual page name
            exit();
        } else {
            // Error occurred while updating contact data
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>