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

if(isset($_POST['change-password'])){
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $re_password = mysqli_real_escape_string($conn, $_POST['re_password']);
    if($password !== $re_password){
        $errors['password'] = "Password does not match!";
    }else{
        $code = 0;
        $CustEmail = $_SESSION['CustEmail'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $update_pass = "UPDATE customer SET code = $code, password = '$hashedPassword', status = '$status' WHERE CustEmail = '$CustEmail'";
        $run_query = mysqli_query($conn, $update_pass);
        if($run_query){
            $info = "Your password is changed. Now you can login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: LogIn.php');
        }else{
            $errors['db-error'] = "Failed to change your password!";
        }  
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
    <title>Create a New Password</title>
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
                    <form action="newPassword.php" method="POST" id="forgotpassword-form" autocomplete="off">
                        <h2 class="form-title">New Password</h2>
						<!--Code-->
                        <div class="form-group">
                            <input type="password" class="form-input" name="password" id="password" placeholder="Enter new password"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="re_password" id="re_password" placeholder="Confirm new password"/>
                        </div>
                        <!-- Error Message Box -->
                        <div class="error-box">
                        </div>
						<!--Submit Button-->
                        <div class="form-group">
                            <input type="submit" name="change-password" id="change-password" class="form-submit" value="Change" a href="LogIn.php"/>
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