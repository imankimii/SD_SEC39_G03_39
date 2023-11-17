<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['CustEmail'])) {

    require_once "database_connection.php";
    require_once 'toyyibpay/toyyibpay_key.php';

    $CustEmail = $_SESSION['CustEmail'];

    // Check if 'facilityType' key exists in the $_POST array
    if (isset($_POST['facilityType'])) {
        $facilityType = $_POST['facilityType'];
    } else {
        // Handle the case where 'facilityType' is not set
        echo "Facility type is not set.";
        exit();
    }

    $bookingDate = $_POST['booking-date'];
    $noOfPersons = $_POST['no-of-persons'];
    $hoursBooked = $_POST['hours-booked'];

    // Check if 'special-request' key exists in the $_POST array
    if (isset($_POST['special-request'])) {
        $specialRequest = $_POST['special-request'];
    } else {
        // Handle the case where 'special-request' is not set
        $specialRequest = ""; // Set it to an empty string
    }

    $totalPrice = $_POST['totalPrice'];

    // Calculate the new ID
    $newID = generateNewID($conn);

    if ($newID === null) {
        // Handle the case where generating a new ID fails
        echo "Error generating a new ID.";
        exit();
    }

    // Set the status to "pending"
    $status = 'pending';

    // initiate bill
    $post_data = array(
        'userSecretKey' => $secret_key,
        'categoryCode' => $category_code,
        'billName' => 'Facility Bill',
        'billDescription' => "Bill " . $facilityType,
        'billPriceSetting' => 1,
        'billPayorInfo' => 0,
        'billAmount' => $totalPrice * 100,
        'billReturnUrl' => 'http://localhost/diploma/ddwd3723/SD_Project/SD_SEC39_G03_39/toyyibpay/responseF.php',
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


    // Insert data into the 'facilityhistory' table, including the new ID and status
    $sql = "INSERT INTO facilityhistory (bookfacilityID, CustEmail, facilityType, walkInDate, noPerson, hours, totalPrice, billCode, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssdsss", $newID, $CustEmail, $facilityType, $bookingDate, $noOfPersons, $hoursBooked, $totalPrice, $bill_code, $status);

        if ($stmt->execute()) {
            // Data inserted successfully
            echo "Data inserted successfully.<br>";
            header('Location: toyyibpay/indexF.php');
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
    $sql = "SELECT MAX(bookfacilityID) FROM facilityhistory";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_row()) {
        $highestID = $row[0];
    } else {
        // Handle the case where querying the highest ID fails
        return null;
    }

    // Extract the numeric part and increment it
    $numericPart = (int)substr($highestID, 3); // Assuming "HDF" is constant
    $numericPart++;

    // Create the new ID by combining "HDF" and the incremented numeric part with leading zeros
    $newID = "HDF" . sprintf('%02d', $numericPart); // Padded to two digits

    return $newID;
}
?>