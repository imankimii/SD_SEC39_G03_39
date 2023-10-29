<?php
session_start();

if (!isset($_SESSION['AdminEmail'])) {
    header('Location: LogIn.php');
    exit();
}

require_once "database_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_booking'])) {
    if (isset($_POST['bookingID']) && !empty($_POST['bookingID'])) {
        $bookingID = mysqli_real_escape_string($conn, $_POST['bookingID']);
    } else {
        echo "bookingID is not set or is invalid.";
        exit();
    }

    // Update the booking in the database using a prepared statement
    $sql = "UPDATE facilityhistory SET 
        walkInDate = ?,
        noPerson = ?,
        hours = ?,
        totalPrice = ?,
        status = ?
        WHERE bookfacilityID = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $walkInDate = $_POST['walkInDate'];
        $noPerson = $_POST['noPerson'];
        $hours = $_POST['hours'];
        $totalPrice = $_POST['totalPrice'];
        $status = $_POST['status'];

        $stmt->bind_param("siddss", $walkInDate, $noPerson, $hours, $totalPrice, $status, $bookingID);

        if ($stmt->execute()) {
            // Booking history updated successfully
            $stmt->close();
            header('Location: facilityBookingHistory.php');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error in preparing the SQL statement: " . $conn->error;
    }
}

// Close the database connection if not already closed
$conn->close();
?>