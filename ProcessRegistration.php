<?php
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "hotelsdamansara";

// Connect to database server
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection to database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $CustName = $_POST["CustName"];
    $CustEmail = $_POST["CustEmail"];
    $password = $_POST["password"];
    $rePassword = $_POST["re_password"];

    // Check if passwords match
    if ($password !== $rePassword) {
        // Display a message that password did not match
        header("Location: Registration.php?password_mismatch=true");
        exit();
    } else {
        // Check if email already exists
        $emailCheckQuery = "SELECT CustEmail FROM customer WHERE CustEmail = '$CustEmail'";
        $emailCheckResult = $conn->query($emailCheckQuery);

        if ($emailCheckResult->num_rows > 0) {
            // Display a message that email already exists
			header("Location: Registration.php?email=true");
        } else {
            // Hash the password before inserting it into the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert customer data into the database
            $sql = "INSERT INTO customer (CustName, CustEmail, password) VALUES ('$CustName', '$CustEmail', '$hashedPassword')";

            if ($conn->query($sql) === TRUE) {
                header("Location: LogIn.php"); // Go to the Login page
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>