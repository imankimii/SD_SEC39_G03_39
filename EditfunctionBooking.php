<?php
session_start();

if (!isset($_SESSION['AdminEmail'])) {
    header('Location: LogIn.php');
    exit();
}

require_once "database_connection.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_booking'])) {
    if(isset($_POST['bookingID']) && !empty($_POST['bookingID'])) {
        $bookingID = mysqli_real_escape_string($conn, $_POST['bookingID']);
    } else {
        echo "bookingID is not set or is invalid.";
        exit();
    }

    // Prepare and bind the SQL query
    $sql = "UPDATE bookinghistory SET 
        checkInDate = ?,
        checkOutDate = ?,
        noOccupant = ?,
        facilityChoice = ?,
        specialReq = ?,
        totalPrice = ?,
        status = ?
        WHERE bookingID = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssissdss", $checkInDate, $checkOutDate, $noOccupant, $facilityChoice, $specialReq, $totalPrice, $status, $bookingID);

        $checkInDate = $_POST['checkInDate'];
        $checkOutDate = $_POST['checkOutDate'];
        $noOccupant = $_POST['noOccupant'];
        $facilityChoice = $_POST['facilityChoice'];
        $specialReq = $_POST['specialReq'];
        $totalPrice = $_POST['totalPrice'];
        $status = $_POST['status'];

        if ($stmt->execute()) {
            // Booking history updated successfully
            $stmt->close();
            header('Location: roomBookingHistory.php');
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