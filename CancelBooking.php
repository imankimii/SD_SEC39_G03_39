<?php
// Include your database connection
require_once "database_connection.php";

if (isset($_POST['bookingID'])) {
    // Retrieve the bookingID from the POST data
    $bookingID = $_POST['bookingID'];

    // Update the status to "Cancelled" in the bookingHistory table
    $sql = "UPDATE bookinghistory SET status = 'cancelled' WHERE BookingID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $bookingID);
        if ($stmt->execute()) {
            echo "Booking has been cancelled successfully.";
        } else {
            echo "Error updating booking status: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing the SQL statement: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>