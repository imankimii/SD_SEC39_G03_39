<?php
session_start();
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "hotelsdamansara";
$errors = array();

// Connect to database
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection to database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
        $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
        $check_code = "SELECT * FROM customer WHERE code = $otp_code";
        $code_res = mysqli_query($conn, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $CustEmail = $fetch_data['CustEmail'];
            $_SESSION['CustEmail'] = $CustEmail;
            $info = "Please create a new password that you have not used before.";
            $_SESSION['info'] = $info;
            header('Location: newPassword.php');
            exit();
            }else{
                $errors['otp-error'] = "You've entered incorrect code!";
            }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Code Verification</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="LogSigncss/style.css">
</head>
<body>
    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="forgotpassword-form" class="forgotpassword-form" autocomplete="">
                        <h2 class="form-title">Code Verification</h2>
						
						<!--Code-->
                        <div class="form-group">
                            <input type="number" class="form-input" name="otp" id="otp" placeholder="Enter Code"/>
                        </div>
						
						 <!-- Error Popup -->
						<div id="error-popup" class="error-popup"></div>
						
						<!--Submit Button-->
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Submit" a href="newPassword.php"/>
                        </div>
						
                    </form>
                </div>
            </div>
        </section>
    </div>
    <!-- JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>