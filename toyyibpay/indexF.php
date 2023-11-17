<?php
session_start();

if (!isset($_SESSION['CustEmail'])) {
    header("Login.php");
    die();
}


require_once "../database_connection.php";

$cust_email = htmlspecialchars($_SESSION['CustEmail']);
$query = "SELECT * FROM `facilityhistory` WHERE CustEmail = ? ORDER BY bookfacilityID DESC limit 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $cust_email);

if (!$stmt->execute()) {
    print("Error SQL Query Failed");
    die();
}

$result = $stmt->get_result();
$facilityHistory = $result->fetch_assoc();

$billCode = $facilityHistory["billCode"];

header("Location: https://dev.toyyibpay.com/" . $billCode);
