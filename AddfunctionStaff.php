<?php
session_start();
require_once "database_connection.php";

if (isset($_POST['add_staff'])) { // Check if the form was submitted with the "ADD STAFF" button
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $race = $_POST['race'];
    $noPhone = $_POST['noPhone'];
    $state = $_POST['state'];

    // Validate and sanitize user inputs here (e.g., using filter_var)

    // Function to generate a unique random ID
    function generateUniqueID($conn) {
        $prefix = 'HSDS';
        $maxNumber = 300; // Maximum number (adjust as needed)

        do {
            $randomNumber = mt_rand(1, $maxNumber);
            $staffID = $prefix . str_pad($randomNumber, strlen((string)$maxNumber), '0', STR_PAD_LEFT);

            // Check if the generated ID already exists in the database
            $checkQuery = "SELECT StaffID FROM staff WHERE StaffID = '$staffID'";
            $result = mysqli_query($conn, $checkQuery);

            if (mysqli_num_rows($result) === 0) {
                // The ID doesn't exist in the database, break out of the loop
                break;
            }
        } while (true);

        return $staffID;
    }

    // Generate a unique random staff ID
    $staffID = generateUniqueID($conn);
	$hashedPassword = password_hash($staffID, PASSWORD_DEFAULT);
	
    // Insert data into the database (assuming you have a 'staff' table)
    $sql = "INSERT INTO staff (StaffID, StaffName, StaffEmail, password, Gender, Race, NoPhone, State) 
            VALUES ('$staffID', '$name', '$email', '$hashedPassword', '$gender', '$race', '$noPhone', '$state')";

    if (mysqli_query($conn, $sql)) {
        // Insertion successful, redirect to the same page or another page
        header("Location: Stafftable.php"); // Replace with the actual page name
        exit();
    } else {
        // Insertion failed, display an error message or handle it accordingly
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>