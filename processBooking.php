<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['CustEmail'])) {
    require_once "database_connection.php";

    $CustEmail = $_SESSION['CustEmail'];
    $roomType = $_POST['roomType'];
    $checkInDate = $_POST['check-in'];
    $checkOutDate = $_POST['check-out'];
    $noOccupant = $_POST['adult-age'];
    $specialRequest = $_POST['special-request'];
    $totalPrice = $_POST['totalPrice'];

    // Calculate the new ID
    $newID = generateNewID($conn);

    if ($newID === null) {
        // Handle the case where generating a new ID fails
        echo "Error generating a new ID.";
        exit();
    }

    // Initialize an array to store facility choices
    $facilityChoices = [];

    // Check if 'facilities' and 'facilityHours' arrays are set in the POST data
    if (isset($_POST['facilities'])) {
        $facilities = $_POST['facilities'];
        $facilityHours = $_POST['facilityHours'];

        // Initialize an array to store facility choices (facility type and hours)
        $facilityChoiceArray = [];

        // Loop through the selected facilities
        foreach ($facilities as $facilityType) {
            $hours = $facilityHours[$facilityType];
            $facilityChoiceArray[] = "$facilityType($hours)";
        }

        // Combine the facility choices into a single string
        $facilityChoiceString = implode(', ', $facilityChoiceArray);

        // Set the status to "pending"
        $status = 'pending';

        // Insert data into the 'bookinghistory' table, including the new ID and status
        $sql = "INSERT INTO bookinghistory (BookingID, CustEmail, CheckInDate, CheckOutDate, NoOccupant, FacilityChoice, SpecialReq, TotalPrice, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssssssds", $newID, $CustEmail, $checkInDate, $checkOutDate, $noOccupant, $facilityChoiceString, $specialRequest, $totalPrice, $status);

            if ($stmt->execute()) {
                // Data inserted successfully
                echo "Data inserted successfully.<br>";
                header('Location: customerHomepage.php');
                exit();
            } else {
                // Handle the case where the insertion fails
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            // Handle the case where the prepare failed
            echo "Prepare statement failed: " . $conn->error;
        }
    } else {
        // Handle cases where facilities were not selected
        echo "No facilities selected.";
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle cases where the user is not logged in or the form was not submitted
    header('Location: LogIn.php');
    exit();
}

// Function to generate a new ID
function generateNewID($conn) {
    // Get the current highest ID from the database
    $sql = "SELECT MAX(BookingID) FROM bookinghistory";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_row()) {
        $highestID = $row[0];
    } else {
        // Handle the case where querying the highest ID fails
        return null;
    }

    // Extract the numeric part and increment it
    $numericPart = (int)substr($highestID, 4); // Assuming "HDH" is constant
    $numericPart++;

    // Create the new ID by combining "HDH" and the incremented numeric part
    $newID = "HDH" . sprintf('%02d', $numericPart); // Padded to two digits

    return $newID;
}
?>