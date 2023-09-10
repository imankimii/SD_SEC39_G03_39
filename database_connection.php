<?php
    /* If want to use database,type:
    require_once "database_connection.php";
    */
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "hotelsdamansara";

    // Connect to the database
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    // Check the database connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>