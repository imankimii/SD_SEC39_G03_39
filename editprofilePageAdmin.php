<?php
session_start();
// Check if the customer is logged in
if (!isset($_SESSION['AdminEmail'])) {
  header('Location: LogIn.php');
  exit();
}
require_once "database_connection.php";

/* Fetch Customer Name and Email */
$AdminEmail = $_SESSION['AdminEmail'];
$sql = "SELECT * FROM admin WHERE AdminEmail = '$AdminEmail'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$AdminID = isset($row['AdminID']) ? $row['AdminID'] : '';
$AdminName = isset($row['AdminName']) ? $row['AdminName'] : '';
$AdminEmail = isset($row['AdminEmail']) ? $row['AdminEmail'] : '';
$Gender = isset($row['Gender']) ? $row['Gender'] : '';
$Race = isset($row['Race']) ? $row['Race'] : '';
$NoPhone = isset($row['NoPhone']) ? $row['NoPhone'] : '';
$State = isset($row['State']) ? $row['State'] : '';
$ProfilePicture = isset($row['ProfilePicture']) ? $row['ProfilePicture'] : '';

/* Update Profile */
if (isset($_POST['update_profile'])) {
   // Get the new values from the form
  $newAdminName = $_POST['name'];
  $newAdminEmail = $_POST['email'];
  $newGender = $_POST['gender'];
  $newRace = $_POST['race'];
  $newState = $_POST['state'];
  $newNoPhone = $_POST['noPhone'];

  // Initialize an array to store the SQL update statements
  $updateStatements = array();

  // Check and add SQL statements for each field that has a new value
  if (!empty($newAdminName)) {
    $updateStatements[] = "AdminName = '$newAdminName'";
  }
  if (!empty($newAdminEmail)) {
    $updateStatements[] = "AdminEmail = '$newAdminEmail'";
  }
  if (!empty($newGender)) {
    $updateStatements[] = "Gender = '$newGender'";
  }
  if (!empty($newRace)) {
    $updateStatements[] = "Race = '$newRace'";
  }
  if (!empty($newNoPhone)) {
    $updateStatements[] = "NoPhone = '$newNoPhone'";
  }
  if (!empty($newState)) {
    $updateStatements[] = "State = '$newState'";
  }

  // Check if any updates are needed
  if (!empty($updateStatements)) {
    // Construct the SQL query by joining the update statements
    $sql = "UPDATE admin SET " . implode(", ", $updateStatements) . " WHERE AdminEmail = '$AdminEmail'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "<script>alert('Profile Updated Successfully!')</script>";
      echo "<script>window.location.href='profileAdmin.php'</script>";
    } else {
      echo "<script>alert('Profile Update Failed!')</script>";
      echo "<script>window.location.href='profileAdmin.php'</script>";
    }
  } else {
    // Handle the case where no fields were provided for update
    echo "<script>alert('No changes were made.')</script>";
    echo "<script>window.location.href='profileAdmin.php'</script>";
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
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
  <!-- Main CSS -->
  <link rel="stylesheet" href="css/profilepage.css"><!--css/profilepage.css-->
  <style>
    /* CSS for the navigation bar */
    nav {
      background-color: tran; /* Background color */
      padding: 10px 0; /* Add some padding to top and bottom */
      text-align: center;
      width: 100%; /* Set width to 100% to span the entire width of the parent container */
    }

    nav a {
      color: white; /* Text color for the links */
      text-decoration: none; /* Remove underlines from the links */
      padding: 10px 20px; /* Add padding to the links (adjust as needed) */
      margin-right: 5px; /* Reduce the margin between the links (adjust as needed) */
      border-radius: 5px; /* Add rounded corners to the links */
      transition: background-color 0.3s ease; /* Smooth background color transition on hover */
      background-color: rgba(128, 0, 128, 0.5); /* Transparent purple color */
    }

    /* Style the navigation links on hover */
    nav a:hover {
      background-color: #B65FCF; /* Background color on hover */
    }
    .menu_item {
      text-decoration: none;
      color: #fff; /* Text color */
      font-size: 18px;
      margin: 0 10px; /* Add some spacing between menu items (adjust as needed) */
      transition: color 0.3s; /* Smooth color transition on hover */
    }

    .menu_item:hover {
      color: #290916; /* Change color on hover */
    }
  </style>
</head>

<body id="profilepage">
  <div class="ScriptHeader">
    <div class="rt-container>
            <div class=" rt-heading">
      <h1>Profile Page</h1>
      <nav>
        <a href="profileAdmin.php" class="menu_item">View Profile</a>
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
                      <h3>Edit Profile</h3>
                      <img src="<?php echo $row['ProfilePicture']; ?>" id="profile-pic" alt="Profile Picture">
                      <form method="post" action="upload_profile_pictureAdmin.php" enctype="multipart/form-data">
                        <input type="file" name="profile_picture" accept="image/jpeg, image/png, image/jpg"
                          id="input-file">
                        <input type="submit" name="upload" value="Upload Profile Picture">
                      </form>
                    </div>
                    <script>
                      let profileImage = document.getElementById("profile-pic");
                      let inputFile = document.getElementById("input-file");

                      inputFile.onchange = function () {
                        if (inputFile.files.length > 0) {
                          let selectedImage = inputFile.files[0];
                          profileImage.src = URL.createObjectURL(selectedImage);
                        }
                      }
                    </script>

                    <div class="card-body">
                      <form method="post" action="editProfilePageAdmin.php">
                        <div class="form-group">
                          <a href="newPasswordAdmin.php" class="btn btn-primary">Change Password</a>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="card shadow-sm">
                    <div class="card-header bg-transparent border-0">
                      <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Admin Information</h3>
                    </div>
                    <div class="card-body pt-0">
                      <form method="post" action="editProfilePageAdmin.php">
                      <table class="table table-bordered">
						<div class="form-group">
							<label for="AdminID">Admin ID</label>
							<input type="text" id="AdminID" name="AdminID" class="form-control" value="<?php echo $AdminID; ?>" readonly>
						</div>
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" id="name" name="name" class="form-control" value="<?php echo $AdminName; ?>">
                        </div>
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" id="email" name="email" class="form-control" value="<?php echo $AdminEmail; ?>">
                        </div>
                        <div class="form-group">
                          <label for="gender">Gender</label>
                          <input type="text" id="gender" name="gender" class="form-control" value="<?php echo $Gender; ?>">
                        </div>
                        <div class="form-group">
                          <label for="race">Race</label>
                          <input type="text" id="race" name="race" class="form-control" value="<?php echo $Race; ?>">
                        </div>
                        <div class="form-group">
                          <label for="noPhone">No. Phone</label>
                          <input type="text" id="noPhone" name="noPhone" class="form-control" value="<?php echo $NoPhone; ?>">
                        </div>
                        <div class="form-group">
                          <label for="state">State</label>
                          <input type="text" id="state" name="state" class="form-control" value="<?php echo $State; ?>">
                        </div>
                        <div class="form-group">
                          <button type="submit" name="update_profile" class="btn btn-primary">Save Changes</button>
                        </div>
                      </table>
                      </form>
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