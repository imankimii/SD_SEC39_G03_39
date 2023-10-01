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
    // Check if the form was submitted
    if (isset($_POST['edit_customer'])) {
        // Retrieve the customer data from the form
        $CustEmail = $_POST['email'];
        $CustName = $_POST['name'];
        $Gender = $_POST['gender'];
        $Race = $_POST['race'];
        $NoPhone = $_POST['noPhone'];
        $State = $_POST['state'];

        // Update the customer data in the database
        $sql = "UPDATE customer SET CustName = '$CustName', Gender = '$Gender', Race = '$Race', NoPhone = '$NoPhone', State = '$State' WHERE CustEmail = '$CustEmail'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Customer data updated successfully
            header('Location: customertable.php');
            exit();
        } else {
            // Error occurred while updating customer data
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>