<?php //require_once "controllerUserData.php";
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "hotelsdamansara";

// Connect to database
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection to database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loginError = "Invalid email entered"; // Declare the error variable
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $CustEmail = $_POST["CustEmail"];
    // Retrieve hashed password from the database based email user input
    $sql = "SELECT password FROM customer WHERE CustEmail = '$CustEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];
        
        //verify the email
        $sql = "SELECT CustEmail FROM customer WHERE CustEmail = '$CustEmail'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $CustEmail = $row["CustEmail"];
        } else {
            $loginError = "Invalid email or password";
        }
    } else {
        $loginError = "Invalid email or password";
    }
}*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//if user click submit button in forgot password form
if(isset($_POST['submit'])){
    $CustEmail = $_POST['CustEmail'];
    $check_email = "SELECT * FROM customer WHERE CustEmail='$CustEmail'";
    $run_sql = mysqli_query($conn, $check_email);
    if(mysqli_num_rows($run_sql) > 0){
        $code = rand(999999, 111111);
        $insert_code = "UPDATE customer SET code = $code WHERE CustEmail = '$CustEmail'";
        $run_query =  mysqli_query($conn, $insert_code);
        if($run_query){

            // Load Composer's autoloader
            require 'vendor/autoload.php';
            $mail = new PHPMailer(true);
            
            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->SMTPDebug = 2;
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'nurinqistinaedu@gmail.com'; // Your Gmail email
                $mail->Password = 'qynrxnnadaxpfuhl'; // Your Gmail password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
            
                // Sender and recipient
                $mail->setFrom('nurinqistinaedu@gmail.com', 'HOTEL S DAMANSARA PASSWORD RESET OTP'); // Replace with your name and email
                $mail->addAddress($CustEmail); // Email address you want to send the email to
            
                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Code';
                $mail->Body = "Your password reset code is $code";
            
                // Send email
                $mail->send();
            
                $info = "We've sent a password reset otp to your email - $CustEmail";
                $_SESSION['info'] = $info;
                $_SESSION['CustEmail'] = $CustEmail;
                header('location: codeVerification.php');
                exit();
            } catch (Exception $e) {
                $errors['smtp-error'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                echo $errors['smtp-error'];  // Display the error for debugging
            }

        }}}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
	
	<script>
    document.addEventListener("DOMContentLoaded", function() {
        var errorPopup = document.getElementById("error-popup");

        // Show the error popup
        if (errorPopup.textContent.trim() !== "") {
            errorPopup.style.display = "block";
        }

        // Add a click event to close the error popup
        errorPopup.addEventListener("click", function() {
            errorPopup.style.display = "none";
        });
    });
	</script>

</head>

<body>

    <div class="main">
	
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="forgotpassword-form" class="forgotpassword-form" autocomplete="">
                        <h2 class="form-title">Forgot Password</h2>
						
						<!--Email-->
                        <div class="form-group">
                            <input type="email" class="form-input" name="CustEmail" id="CustEmail" placeholder="Your Email"/>
                        </div>
						
						 <!-- Error Popup -->
						<div id="error-popup" class="error-popup"><?php echo $loginError; ?></div>
						
						<!--Submit Button-->
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Submit" a href="codeVerification.php" class="wordhere-link"/>
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