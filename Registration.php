<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Form Hotel S Damansara</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="main">
	
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="signup-form" class="signup-form" action="ProcessRegistration.php">
                        <h2 class="form-title">Registration Account</h2>
						
						<!--Name-->
                        <div class="form-group">
                            <input type="text" class="form-input" name="CustName" id="CustName" placeholder="Your Name" required/>
                        </div>
						
						<!--Email-->
                        <div class="form-group">
                            <input type="email" class="form-input" name="CustEmail" id="CustEmail" placeholder="Your Email" required/>
                        </div>
						
						<!--Password-->
                        <div class="form-group">
                            <input type="text" class="form-input" name="password" id="password" placeholder="Password" required/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
						
						<!--Repassword-->
                        <div class="form-group">
                            <input type="password" class="form-input" name="re_password" id="re_password" placeholder="Repeat your password" required/>
                        </div>
						
						<!--Submit Button-->
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Sign up"/>
                        </div>
						
                    </form>
					
					<!--Login Session-->
                    <p class="loginhere">
                        Have already an account ? <a href="LogIn.php" class="wordhere-link">Login here</a>
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
