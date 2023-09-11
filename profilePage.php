<?php
session_start();
// Check if the customer is logged in
if (!isset($_SESSION['CustEmail'])) {
  header('Location: LogIn.php');
  exit();
}
require_once "database_connection.php";

/* Fetch Customer Name and Email */
$CustEmail = $_SESSION['CustEmail'];
$sql = "SELECT * FROM customer WHERE CustEmail = '$CustEmail'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$CustName = $row['CustName'];
$CustEmail = $row['CustEmail'];
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
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
  <!-- Main CSS -->
  <link rel="stylesheet" href="css/profilepage.css">
</head>

<body id="profilepage">
  <div class="ScriptHeader">
    <div class="rt-container>
            <div class=" rt-heading">
      <h1>Profile Page</h1>
      <nav>
        <a href="customerHomepage.php" class="menu_item">Home</a>
        <a href="" class="menu_item">Booking History</a>
        <a href="editprofilePage.php" class="menu_item">Edit Profile</a>
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
                      <h3>Profile Page</h3>
                      <img src="<?php echo $row['ProfilePicture']; ?>" id="profile-pic" alt="Profile Picture">
                    </div>
                    <div class="card-body">
                      <p class="mb-0"><strong class="pr-1">Name:</strong>
                        <?php echo $CustName; ?>
                      </p>
                      <p class="mb-0"><strong class="pr-1">Email:</strong>
                        <?php echo $CustEmail; ?>
                      </p>
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
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.</p>
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
</html>