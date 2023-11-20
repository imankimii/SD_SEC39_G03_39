<?php
session_start();

if (!isset($_SESSION['CustEmail'])) {
    header("Login.php");
    die();
}

if (!isset($_GET['status_id'])) {
    print("Error False");
    die();
}

$status_id = $_GET['status_id'];
$bill_code = $_GET['billcode'];

$data = array(
    'billCode' => $bill_code,
);

$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/getBillTransactions');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

$result = curl_exec($curl);
$info = curl_getinfo($curl);
curl_close($curl);
$result = json_decode($result, true);

$payment_status = $result[0]["billpaymentStatus"];

if ($payment_status === $status_id) {
    require_once "../database_connection.php";

    $query = "UPDATE `facilityhistory` SET status='success' WHERE billCode=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $bill_code);

    if (!$stmt->execute()) {
        print("Error SQL Query Failed");
        die();
    }
    header("Location: /diploma/ddwd3723/SD_Project/SD_SEC39_G03_39/bookingHistory.php");

}
exit;
