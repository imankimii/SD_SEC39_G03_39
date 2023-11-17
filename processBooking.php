<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['CustEmail'])) {

    require_once "database_connection.php";
    require_once 'toyyibpay/toyyibpay_key.php';

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

        // initiate bill
        $post_data = array(
            'userSecretKey' => $secret_key,
            'categoryCode' => $category_code,
            'billName' => 'Room Bill',
            'billDescription' => "Bill " . $roomType,
            'billPriceSetting' => 1,
            'billPayorInfo' => 0,
            'billAmount' => $totalPrice * 100,
            'billReturnUrl' => 'http://localhost/diploma/ddwd3723/SD_Project/SD_SEC39_G03_39/toyyibpay/response.php',
            'billExternalReferenceNo' => time() . rand(),
            'billTo' => '',
            'billEmail' => $CustEmail,
            'billPhone' => '',
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => 0,
        );

        // php curl to post data to payment gateway
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        $result = json_decode($result, true);

        $bill_code = $result[0]['BillCode'];

        // Insert data into the 'bookinghistory' table, including the new ID and status
        $sql = "INSERT INTO bookinghistory (BookingID, CustEmail, roomType, CheckInDate, CheckOutDate, NoOccupant, FacilityChoice, SpecialReq, TotalPrice, billCode, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssssssdss", $newID, $CustEmail, $roomType, $checkInDate, $checkOutDate, $noOccupant, $facilityChoiceString, $specialRequest, $totalPrice, $bill_code, $status);


            if ($stmt->execute()) {
                // Data inserted successfully
                echo "Data inserted successfully.<br>";
                header('Location: toyyibpay/index.php');
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
function generateNewID($conn)
{
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
    $numericPart = (int) substr($highestID, 3); // Assuming "HDH" is constant
    $numericPart++;

    // Create the new ID by combining "HDH" and the incremented numeric part with leading zeros
    $newID = "HDH" . sprintf('%02d', $numericPart); // Padded to two digits

    return $newID;
}