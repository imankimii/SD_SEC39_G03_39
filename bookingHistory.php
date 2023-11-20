<?php
session_start(); // Start the session

// Check if the customer is not logged in
if (!isset($_SESSION['CustEmail'])) {
    header('Location: LogIn.php');
    exit();
}

// Include the database connection script
require_once "database_connection.php";

// Fetch the current user's CustEmail from the session
$currentUserEmail = $_SESSION['CustEmail'];
?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="icon" href="images/favicon.png" type="image/gif" />

  <title>Hotel S Damansara</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
<style>
  .table-responsive {
    overflow-x: auto;
  }

  table {
    width: 100%;
    max-width: 100%;
    padding: 0;
    margin: 0;
    border: 4px solid #000; /* Increase border width to 4px */
  }

  th, td {
    white-space: nowrap;
    border: 2px solid #000; /* Increase cell border width to 2px */
    padding: 10px; /* Increase cell padding to 10px */
  }

  .table-responsive table {
    margin: 0;
  }
</style>
</head>

<body>

  <!-- header section strats -->
  <header class="header_section innerpage_header">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="index.php">
          <span>
            Hotel S Damansara
          </span>
        </a>
        <div class="" id="">

          <div class="custom_menu-btn">
            <button onclick="openNav()">
              <span class="s-1"> </span>
              <span class="s-2"> </span>
              <span class="s-3"> </span>
            </button>
            <div id="myNav" class="overlay">
              <div class="overlay-content">
                <a href="customerHomepage.php">Home</a>
                <a href="profilePage.php">Profile</a>
				<a href="bookingHistory.php">Booking History</a>
                <a href="aboutC.php">About</a>
                <a href="galleryC.php">Events</a>
                <a href="FacilitiesC.php">Facilities</a>
                <a href="RoomC.php">Room</a>
                <a href="LogOut.php">Log Out</a>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <!-- end header section -->


<!-- Room Booking History section -->
<section class="booking_history_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>
                            Room Booking History
                        </h2>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="border-width: 4px; padding: 10px; width: 100%; max-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Room Type</th>
                                    <th>Check-In Date</th>
                                    <th>Check-Out Date</th>
                                    <th>No. of Occupants</th>
                                    <th>Facility Choice</th>
                                    <th>Special Requests</th>
                                    <th>Total Price(RM)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
								<?php
								// Include the database connection script
								require_once "database_connection.php";

								// Fetch the booking history for the current user
								$currentUserEmail = $_SESSION['CustEmail'];
								$sql = "SELECT BookingID, roomType, CheckInDate, CheckOutDate, NoOccupant, FacilityChoice, SpecialReq, TotalPrice, status FROM bookinghistory WHERE CustEmail = ?";
								$stmt = mysqli_prepare($conn, $sql);
								mysqli_stmt_bind_param($stmt, "s", $currentUserEmail);
								mysqli_stmt_execute($stmt);
								$result = mysqli_stmt_get_result($stmt);

								if ($result && mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
										echo '<tr>';
										echo '<td>' . $row['BookingID'] . '</td>';
										echo '<td>' . $row['roomType'] . '</td>';
										echo '<td>' . $row['CheckInDate'] . '</td>';
										echo '<td>' . $row['CheckOutDate'] . '</td>';
										echo '<td>' . $row['NoOccupant'] . '</td>';
										echo '<td>';
										// Explode the facility choices and display them with hours
										$facilityChoices = explode(', ', $row['FacilityChoice']);
										foreach ($facilityChoices as $choice) {
											list($facility, $hours) = explode('(', $choice);
											$hours = trim($hours, '()');
											echo $facility . ' (' . $hours . ' hours)<br>';
										}
										echo '</td>';
										echo '<td>';

										// Check if Special Request is not empty
										if (!empty($row['SpecialReq'])) {
											echo $row['SpecialReq'];
										} else {
											echo 'None';
										}

										echo '</td>';
										echo '<td>' . $row['TotalPrice'] . '</td>';
										echo '<td>' . $row['status'] . '</td>';
										echo '</tr>';
									}
								} else {
									// Handle the case where no booking history is found for the user
									echo '<tr><td colspan="9">No booking history found for ' . $currentUserEmail . '</td></tr>';
								}
								?>
								</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end Room Booking History section -->

<!-- Facility Booking History section -->
<section class="booking_history_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>
                            Facility Booking History
                        </h2>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="border-width: 4px; padding: 10px; width: 100%; max-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Facility Type</th>
                                    <th>Check-In Date</th>
                                    <th>No. of Person</th>
                                    <th>No. of Hours</th>
                                    <th>Total Price(RM)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
								<?php
								// Include the database connection script
								require_once "database_connection.php";

								// Fetch the booking history for the current user
								$currentUserEmail = $_SESSION['CustEmail'];
								$sql = "SELECT bookfacilityID, facilityType, walkInDate, noPerson, hours, totalPrice, status FROM facilityhistory WHERE CustEmail = ?";
								$stmt = mysqli_prepare($conn, $sql);
								mysqli_stmt_bind_param($stmt, "s", $currentUserEmail);
								mysqli_stmt_execute($stmt);
								$result = mysqli_stmt_get_result($stmt);

								if ($result && mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
										echo '<tr>';
										echo '<td>' . $row['bookfacilityID'] . '</td>';
										echo '<td>' . $row['facilityType'] . '</td>';
										echo '<td>' . $row['walkInDate'] . '</td>';
										echo '<td>' . $row['noPerson'] . '</td>';
										echo '<td>' . $row['hours'] . '</td>';
										echo '<td>' . $row['totalPrice'] . '</td>';
										echo '<td>' . $row['status'] . '</td>';
										echo '</tr>';
									}
								} else {
									// Handle the case where no booking history is found for the user
									echo '<tr><td colspan="9">No booking history found for ' . $currentUserEmail . '</td></tr>';
								}
								?>
								</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end Facility Booking History section -->

  <!-- info section -->
  <section class="info_section innerpage_info_section">
    <div class="container">
      <div class="row info_main_row">
        <div class="col-md-6 col-lg-5">
          <div class="info_detail">
            <h4>
              Company History
            </h4>
            <p class="mb-0">
              Sri Damansara Hotel is a business run by a family from Sabah, east Malaysian Borneo. This stunning hotel is equipped with modern structures and at night sports so many flickering lights that makes it appear as if out of a 1960’s Hong Kong movie.
            </p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
			<h4>Contact Us</h4>
			<div class="info_contact">
				<?php
				// Include the database connection script
				require_once "database_connection.php";

				// Fetch contact information from the 'contactus' table
				$sql = "SELECT address, phone, email FROM contactus";
				$result = mysqli_query($conn, $sql);

				if ($result && mysqli_num_rows($result) > 0) {
					$row = mysqli_fetch_assoc($result);
					$address = $row['address'];
					$phone = $row['phone'];
					$email = $row['email'];

					// Display the contact information
					echo '<a href="#">
							<i class="fa fa-map-marker" aria-hidden="true"></i>
							<span>' . $address . '</span>
						  </a>';
					echo '<a href="#">
							<i class="fa fa-phone" aria-hidden="true"></i>
							<span>Call ' . $phone . '</span>
						  </a>';
					echo '<a href="mailto:' . $email . '">
							<i class="fa fa-envelope"></i>
							<span>' . $email . '</span>
						  </a>';
				} else {
					// Handle the case where no data is found in the 'contactus' table
					echo "Contact information not available.";
				}

				// Close the database connection
				mysqli_close($conn);
				?>
				<a href="">
					<i class="fa fa-clock-o" aria-hidden="true"></i>
					<span>Operation time (24 Hours)</span>
				</a>
			</div>
		</div>
        <div class="col-md-6 col-lg-3">
          <h4>
            Follow Us
          </h4>
          <div class="social_box">
            <a href="">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-linkedin" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end info_section -->


  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> All Rights Reserved By
        <a href="https://html.design/">Hotel S Damansara</a>
      </p>
    </div>
  </footer>
  <!-- footer section -->


  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>

</body>

</html>