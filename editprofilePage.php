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

if(isset($_POST['change-email'])){
    $_SESSION['info'] = "";
    $CustName = mysqli_real_escape_string($conn, $_POST['CustName']);
    $CustEmail = mysqli_real_escape_string($conn, $_POST['CustEmail']);
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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile Page</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet"><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/profilepage.css"><!--css/profilepage.css-->
</head>
<body id="profilepage">
<div class="ScriptHeader">
    <div class="rt-container>
            <div class="rt-heading">
            	<h1>Profile Page</h1>
                <nav>
                    <a href="" class="menu_item">Update Profile</a>
                    <a href="" class="menu_item">Booking History</a>
                    <a href="profilePage.php" class="menu_item">View Profile</a>
                </nav>  
            </div>
        </div>
<section>
    <div class="rt-container">
          <div class="col-rt-12">
              <div class="Scriptcontent">
              
<!-- customer Profile -->
<div class="customer-profile py-4">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="profile-image-section">
                <h3>Customer Name</h3>
                <img src="images/profile.png" id="profile-pic">
                <input type ="file" accept="image/jpeg, image/png, image/jpg" id="input-file">
                <script>
                    let profileImage = document.querySelector("profile-pic");
                    let input = document.querySelector("input-file");
                    inputFile.onchange= function(){
                        profilePic.src = URL.createObjectURL(inputFile.files[0]);
                    }
                </script>
            </div>
          <div class="card-body">
            <p class="mb-0"><strong class="pr-1">Name:</strong>customer name</p>
            <input type="text" name="CustName" id="newCustName" placeholder="Enter new name" required>
            <button class="button" id="change-name" onclick="location.href='editprofilePage.php'">Change</button>
            <?php
            /*after customer click change button, the name will be changed and the new name will be displayed*/
            if(isset ($_POST['change-name'])){
                $CustName = $_POST['CustName'];
                $sql = "UPDATE customer SET CustName = '$CustName' WHERE CustEmail = '$CustEmail'";
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo "Name changed successfully";
                }else{
                    echo "Failed to change name";
                }
            }
            ?>
            <p class="mb-0"><strong class="pr-1">Email:</strong>customremail@gmail.com</p>
            <input type="text" name="CustEmail" id="CustEmail" placeholder="Enter new email" required>
            <button class="button" id="change-email" onclick="location.href='editprofilePage.php'">Change</button>
            <?php
            /*after customer click change button, the email will be changed and the new email will be displayed*/
            if(isset ($_POST['change-email'])){
                $CustEmail = $_POST['CustEmail'];
                $sql = "UPDATE customer SET CustEmail = '$CustEmail' WHERE CustEmail = '$CustEmail'";
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo "Email changed successfully";
                }else{
                    echo "Failed to change email";
                }
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Booking Information</h3>
          </div>
          <div class="card-body pt-0">
            <table class="table table-bordered">
              <tr>
                <th width="30%">Room Type</th>
                <td width="2%">:</td>
                <td>Deluxe King</td>
              </tr>
              <tr>
                <th width="30%">Room Number</th>
                <td width="2%">:</td>
                <td>202</td>
              </tr>
              <tr>
                <th width="30%">Duration</th>
                <td width="2%">:</td>
                <td>3 Days 2 Night</td>
              </tr>
              <tr>
                <th width="30%">Add On</th>
                <td width="2%">:</td>
                <td>Breakfast x 2</td>
              </tr>
              <tr>
                <th width="30%">Services</th>
                <td width="2%">:</td>
                <td>Room Cleaning and Spa</td>
              </tr>
            </table>
          </div>
        </div>
          <div style="height: 26px"></div>
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Other Information</h3>
          </div>
          <div class="card-body pt-0">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- partial -->
           
    		</div>
		</div>
    </div>
</section>
     
    <!-- Analytics -->

</body>
