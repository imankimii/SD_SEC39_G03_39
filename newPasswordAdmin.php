<?php
session_start();
// Check if the Admin is logged in
if (!isset($_SESSION['AdminEmail'])) {
    header('Location: LogIn.php');
    exit();
}
require_once "database_connection.php";

$errors = array();

if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $re_password = mysqli_real_escape_string($conn, $_POST['re_password']);
    if ($password !== $re_password) {
        $errors['password'] = "Password does not match!";
    } else {
        $code = 0;
        $status = "verified";
        $AdminEmail = $_SESSION['AdminEmail'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $update_pass = "UPDATE admin SET code = $code, password = '$hashedPassword', status = '$status' WHERE AdminEmail = '$AdminEmail'";
        $run_query = mysqli_query($conn, $update_pass);
        if ($run_query) {
            $info = "Your password is changed. Now you can login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: LogIn.php');
        } else {
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
                    <form action="newPasswordAdmin.php" method="POST" id="forgotpassword-form" autocomplete="off">
                        <h2 class="form-title">New Password</h2>

                        <!-- Password -->
                        <div class="form-group">
                            <input type="password" class="form-input" name="password" id="password"
                                placeholder="Enter new password" required />
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>

                        <!-- RePassword -->
                        <div class="form-group">
                            <input type="password" class="form-input" name="re_password" id="re_password"
                                placeholder="Confirm new password" required />
                            <?php if (isset($errors['password'])): ?>
                                <p class="error-message">
                                    <?php echo $errors['password']; ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Error Message Box -->
                        <div class="error-box">
                            <?php if (isset($errors['db-error'])): ?>
                                <p class="error-message">
                                    <?php echo $errors['db-error']; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <!--Submit Button-->
                        <div class="form-group">
                            <input type="submit" name="change-password" id="change-password" class="form-submit"
                                value="Change" a href="LogIn.php" />
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