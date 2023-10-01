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
    <link rel="stylesheet" href="LogSigncss/style.css">
</head>

<body>

    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="signup-form" class="signup-form" action="ProcessRegistration.php">
                        <h2 class="form-title">Registration Account</h2>
                        
                        <!-- Name -->
                        <div class="form-group">
                            <input type="text" class="form-input" name="CustName" id="CustName" placeholder="Your Name" required/>
                            <p class="error-message" id="name-error"></p>
                        </div>
                        
                        <!-- Email -->
                        <div class="form-group">
                            <input type="email" class="form-input" name="CustEmail" id="CustEmail" placeholder="Your Email" required/>
                            <?php if (isset($_GET['email'])): ?>
                                <p class="error-message">Email already exists. Please use a different email.</p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group">
                            <input type="password" class="form-input" name="password" id="password" placeholder="Password" required/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                            <p class="error-message" id="password-error"></p>
                        </div>

                        <!-- RePassword -->
                        <div class="form-group">
                            <input type="password" class="form-input" name="re_password" id="re_password" placeholder="Repeat your password" required/>
                            <?php if (isset($_GET['password_mismatch'])): ?>
                                <p class="error-message">Passwords do not match.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Sign up"/>
                        </div>
                        
                    </form>
					
                    <!--login session-->
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
    <script>
    // Function to validate the Name field
    function validateName() {
        var nameInput = document.getElementById("CustName");
        var nameError = document.getElementById("name-error");
        var namePattern = /^[A-Za-z\s]+$/; // Regular expression to allow only letters and spaces
        var submitButton = document.getElementById("submit"); // Select the submit button

        if (!namePattern.test(nameInput.value)) {
            nameError.textContent = "Please enter a valid name (only letters and spaces).";
            nameError.style.color = "red"; // Set the text color to red
            nameInput.classList.add("input-error");
            submitButton.disabled = true; // Disable the submit button
        } else {
            nameError.textContent = ""; // Clear the error message
            nameInput.classList.remove("input-error");
            submitButton.disabled = false; // Enable the submit button
        }
    }

    // Function to validate the Password field
    function validatePassword() {
        var passwordInput = document.getElementById("password");
        var passwordError = document.getElementById("password-error");
        var minLength = 6; // Minimum password length
        var maxLength = 20; // Maximum password length
        var submitButton = document.getElementById("submit"); // Select the submit button

        if (passwordInput.value.length < minLength || passwordInput.value.length > maxLength) {
            passwordError.textContent = "Password must be between " + minLength + " and " + maxLength + " characters.";
            passwordError.style.color = "red"; // Set the text color to red
            passwordInput.classList.add("input-error");
            submitButton.disabled = true; // Disable the submit button
        } else {
            passwordError.textContent = ""; // Clear the error message
            passwordInput.classList.remove("input-error");
            submitButton.disabled = false; // Enable the submit button
        }
    }

    // Add event listeners for validation
    var nameInput = document.getElementById("CustName");
    var passwordInput = document.getElementById("password");

    nameInput.addEventListener("blur", validateName);
    passwordInput.addEventListener("input", validatePassword);
</script>
</body>
</html>