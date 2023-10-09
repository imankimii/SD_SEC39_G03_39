<?php
session_start();
require_once "database_connection.php";

if(isset($_POST['new_enquiry'])){
    $enquiryName = $_POST['enquiryName'];
    $enquiryEmail = $_POST['enquiryEmail'];
    $enquiryPhone = $_POST['enquiryPhone'];
    $enquiryMessage = $_POST['enquiryMessage'];

    $sql = "INSERT INTO enquiry (enquiryName, enquiryEmail, enquiryPhone, enquiryMessage) 
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $enquiryName, $enquiryEmail, $enquiryPhone, $enquiryMessage);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php"); 
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    header: ("Location: index.php");
}
mysqli_close($conn);
?>