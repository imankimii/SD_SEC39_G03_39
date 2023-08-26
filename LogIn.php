<?php
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

$loginError = ""; // Declare the error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $CustEmail = $_POST["CustEmail"];
    $password = $_POST["password"];

    // Retrieve hashed password from the database based email user input
    $sql = "SELECT password FROM customer WHERE CustEmail = '$CustEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Verify the password input with hashed password
        if (password_verify($password, $hashedPassword)) {
            // if password same allow user to go to the next page
            header("Location: Registration.php"); // Go to Homepage
            exit();
        } else {
            $loginError = "Invalid email or password";
        }
    } else {
        $loginError = "Invalid email or password";
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
    <title>Login Form Hotel S Damansara</title>

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
                    <form method="POST" id="login-form" class="login-form">
                        <h2 class="form-title">Log In Account</h2>
						
						<!--Email-->
                        <div class="form-group">
                            <input type="email" class="form-input" name="CustEmail" id="CustEmail" placeholder="Your Email"/>
                        </div>
						
						<!--Password-->
                        <div class="form-group">
                            <input type="text" class="form-input" name="password" id="password" placeholder="Password"/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
						
						 <!-- Error Popup -->
						<div id="error-popup" class="error-popup"><?php echo $loginError; ?></div>
						
						<!--Submit Button-->
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Log In"/>
                        </div>
						
                    </form>
					
					<!--Forgot Password Session-->
                    <p class="forgotpasshere">
                        Forgot <a href="#" class="wordhere-link">Username/Password?</a>
                    </p>
					
					<!--Register Session-->
                    <p class="signuphere">
                        Didn't have an account? <a href="Registration.php" class="wordhere-link">Register here</a>
                    </p>
                </div>
            </div>
        </section>

    </div>

    <!-- JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>