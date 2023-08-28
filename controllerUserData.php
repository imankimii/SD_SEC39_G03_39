<?php
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "hotelsdamansara";
    
    // conn$connnect to database
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    
    // Check conn$connnection to database
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //if user signup button
    if(isset($_POST['signup-form'])){
        $CustName = mysqli_real_escape_string($conn, $_POST['CustName']);
        $CustEmail = mysqli_real_escape_string($conn, $_POST['CustEmail']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $rePassword = mysqli_real_escape_string($conn, $_POST['re_password']);
        
        $email_check = "SELECT * FROM customer WHERE email = '$CustEmail'";
        $res = mysqli_query($conn, $email_check);
        if(mysqli_num_rows($res) > 0){
            $errors['email'] = "Email that you have entered is already exist!";
        }
        if(count($errors) === 0){
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $code = rand(999999, 111111);
            $status = "notverified";
            $insert_data = "INSERT INTO customer (CustName, CustEmail, password, code, status)
                            values('$CustName', '$CustEmail', $hashedPassword', '$code', '$status')";
            $data_check = mysqli_query($conn, $insert_data);
            if($data_check){
                $subject = "Email Verification Code";
                $message = "Your verification code is $code";
                $sender = "From: nurinqistinaedu@gmail.com";
                if(mail($CustEmail, $subject, $message, $sender)){
                    $info = "We've sent a verification code to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['CustEmail'] = $CustEmail;
                    $_SESSION['password'] = $password;
                    header('location: codeVerification.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{
                $errors['db-error'] = "Failed while inserting data into database!";
            }
        }
    
    }
        //if user click verification code submit button
        if(isset($_POST['check'])){
            $_SESSION['info'] = "";
            $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
            $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
            $code_res = mysqli_query($conn, $check_code);
            if(mysqli_num_rows($code_res) > 0){
                $fetch_data = mysqli_fetch_assoc($code_res);
                $fetch_code = $fetch_data['code'];
                $email = $fetch_data['email'];
                $code = 0;
                $status = 'verified';
                $update_otp = "UPDATE usertable SET code = $code, status = '$status' WHERE code = $fetch_code";
                $update_res = mysqli_query($conn, $update_otp);
                if($update_res){
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    header('location: home.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while updating code!";
                }
            }else{
                $errors['otp-error'] = "You've entered incorrect code!";
            }
        }
    
        //if user click conn$conntinue button in forgot password form
        if(isset($_POST['check-email'])){
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $check_email = "SELECT * FROM usertable WHERE email='$email'";
            $run_sql = mysqli_query($conn, $check_email);
            if(mysqli_num_rows($run_sql) > 0){
                $code = rand(999999, 111111);
                $insert_code = "UPDATE usertable SET code = $code WHERE email = '$email'";
                $run_query =  mysqli_query($conn, $insert_code);
                if($run_query){
                    $subject = "Password Reset Code";
                    $message = "Your password reset code is $code";
                    $sender = "From: shahiprem7890@gmail.com";
                    if(mail($email, $subject, $message, $sender)){
                        $info = "We've sent a passwrod reset otp to your email - $email";
                        $_SESSION['info'] = $info;
                        $_SESSION['email'] = $email;
                        header('location: reset-code.php');
                        exit();
                    }else{
                        $errors['otp-error'] = "Failed while sending code!";
                    }
                }else{
                    $errors['db-error'] = "Something went wrong!";
                }
            }else{
                $errors['email'] = "This email address does not exist!";
            }
        }
    
        //if user click check reset otp button
        if(isset($_POST['check-reset-otp'])){
            $_SESSION['info'] = "";
            $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
            $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
            $code_res = mysqli_query($conn, $check_code);
            if(mysqli_num_rows($code_res) > 0){
                $fetch_data = mysqli_fetch_assoc($code_res);
                $email = $fetch_data['email'];
                $_SESSION['email'] = $email;
                $info = "Please create a new password that you don't use on any other site.";
                $_SESSION['info'] = $info;
                header('location: new-password.php');
                exit();
            }else{
                $errors['otp-error'] = "You've entered incorrect code!";
            }
        }
    
        //if user click change password button
        if(isset($_POST['change-password'])){
            $_SESSION['info'] = "";
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
            if($password !== $cpassword){
                $errors['password'] = "conn$connfirm password not matched!";
            }else{
                $code = 0;
                $email = $_SESSION['email']; //getting this email using session
                $encpass = password_hash($password, PASSWORD_BCRYPT);
                $update_pass = "UPDATE usertable SET code = $code, password = '$encpass' WHERE email = '$email'";
                $run_query = mysqli_query($conn, $update_pass);
                if($run_query){
                    $info = "Your password changed. Now you can login with your new password.";
                    $_SESSION['info'] = $info;
                    header('Location: password-changed.php');
                }else{
                    $errors['db-error'] = "Failed to change your password!";
                }
            }
        }
        
       //if login now button click
        if(isset($_POST['login-now'])){
            header('Location: login-user.php');
        }
    ?>