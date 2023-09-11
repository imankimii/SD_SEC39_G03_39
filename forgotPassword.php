<?php
require_once "database_connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = array();

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
            }
        } else {
            $errors['database-error'] = 'Database error: Unable to update code.';
        }
    } else {
        $errors['email-not-found'] = 'Email not found in the database.';
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
    <title>Forgot Password</title>
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
                        <h2 class="form-title">Forgot Password</h2>
						<!--Email-->
                        <div class="form-group">
                            <input type="email" class="form-input" name="CustEmail" id="CustEmail" placeholder="Your Email"/>
                        </div>
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
    <script>
    // JavaScript code to display errors using alerts
        <?php if (!empty($errors)) { ?>
            <?php foreach ($errors as $error) { ?>
                alert('<?php echo $error; ?>');
            <?php } ?>
        <?php } ?>
    </script>
</body>
</html>