<?php

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
    
    
    $conn->close();

    if($_SESSION['info'] == false){
        header('Location: LogIn.php');  
    }

    if(isset($_POST['submit'])){
        $CustEmail = $_SESSION['CustEmail'];
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $re_password = mysqli_real_escape_string($conn, $_POST['re_password']);
        if($password !== $re_password){
            $errors['password'] = "Password does not match!";
        }else{
            $code = $_POST['code'];
            $password = $_POST['password'];
            $result = $conn->query("SELECT * FROM customer WHERE CustEmail='$CustEmail'");
            $row = $result->fetch_assoc();
            $password = $row['password'];
            $code = 0;
            $status = "verified";
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE customer SET code = $code, password = '$password', status = '$status' WHERE CustEmail = '$CustEmail'";
            //$run_query = mysqli_query($conn, $update_pass);
            /*if($run_query){
                $info = "Your password is changed. Now you can login with your new password.";
                $_SESSION['CustEmail'] = $CustEmail;
                header('location: password-changed.php');
                exit();
            }else{
                $errors['db-error'] = "Something went wrong. Please try again!";
            }   */
            if($conn->query($sql) === TRUE){
                $info = "Your password is changed. Now you can login with your new password.";
                $_SESSION['CustEmail'] = $CustEmail;
                header('location: password-changed.php');
                exit();
        }
    }}
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
<div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
            <?php 
            if(isset($_SESSION['info'])){
                ?>
                <div class="alert alert-success text-center">
                <?php echo $_SESSION['info']; ?>
                </div>
                <?php
            }
            ?>
                <form action="login-user.php" method="POST">
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="login-now" value="Login Now">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>