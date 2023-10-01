<?php
session_start();
// Check if the staff is logged in
if (!isset($_SESSION['StaffEmail'])) {
  header('Location: LogIn.php');
  exit();
}
require_once "database_connection.php";

/* Fetch Customer Name and Email */
$StaffEmail = $_SESSION['StaffEmail'];
$sql = "SELECT * FROM Staff WHERE StaffEmail = '$StaffEmail'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$StaffID = $row['StaffID'];
$StaffName = $row['StaffName'];
$Gender = $row['Gender'];
$Race = $row['Race'];
$NoPhone = $row['NoPhone'];
$State = $row['State'];

// Check if ProfilePicture is null or empty, and set it to the default picture URL if needed
if (empty($ProfilePicture)) {
  $ProfilePicture = "images\profile.png";
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
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
  <!-- Main CSS -->
  <link rel="stylesheet" href="css/profilepage.css">
</head>

<body id="profilepage">
  <div class="ScriptHeader">
    <div class="rt-container>
            <div class=" rt-heading">
      <h1>Staff Profile Page</h1>
      <nav>
        <a href="dashboardStaff.php" class="menu_item">Dashboard</a>
        <a href="editprofilePageStaff.php" class="menu_item">Edit Profile</a>
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
                      <img src="<?php echo $ProfilePicture; ?>" id="profile-pic">
                    </div>
                    <div class="card-body">
                      <p class="mb-0"><strong class="pr-1">Name:</strong>
                        <?php echo $StaffName; ?>
                      </p>
                      <p class="mb-0"><strong class="pr-1">Email:</strong>
                        <?php echo $StaffEmail; ?>
                      </p>
                    </div>
                    <div class="form-group">
                      <a href="newPasswordStaff.php" class="btn btn-primary">Change Password</a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="card shadow-sm">
                    <div class="card-header bg-transparent border-0">
                      <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Staff Information</h3>
                    </div>
                    <div class="card-body pt-0">
                      <table class="table table-bordered">
                        <tr>
                          <th width="30%">Staff ID</th>
                          <td width="2%">:</td>
                          <td><?php echo $StaffID; ?></td>
                        </tr>
                        <tr>
                          <th width="30%">Gender</th>
                          <td width="2%">:</td>
                          <td><?php echo $Gender; ?></td>
                        </tr>
                        <tr>
                          <th width="30%">Race</th>
                          <td width="2%">:</td>
                          <td><?php echo $Race; ?></td>
                        </tr>
						<tr>
                          <th width="30%">No Phone</th>
                          <td width="2%">:</td>
                          <td><?php echo $NoPhone; ?></td>
                        </tr>
                        <tr>
                          <th width="30%">State</th>
                          <td width="2%">:</td>
                          <td><?php echo $State; ?></td>
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