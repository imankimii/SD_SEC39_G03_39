<?php
// Include your database connection
require_once "database_connection.php";

if (isset($_POST['bookfacilityID'])) {
    // Retrieve the bookfacilityID from the POST data
    $bookfacilityID = $_POST['bookfacilityID'];

    // Update the status to "Cancelled" in the bookinghistory table
    $sql = "UPDATE facilityhistory SET status = 'cancelled' WHERE bookfacilityID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $bookfacilityID);
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