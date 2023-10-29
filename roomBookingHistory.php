<?php
session_start();
if (!isset($_SESSION['AdminEmail'])) {
    header('Location: LogIn.php');
    exit();
}
require_once "database_connection.php";

// SQL query to retrieve booking information (table name is 'booking')
$sql = "SELECT * FROM bookinghistory";
$result = mysqli_query($conn, $sql);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$AdminEmail = $_SESSION['AdminEmail'];
$sqlAdmin = "SELECT * FROM admin WHERE AdminEmail = '$AdminEmail'";
$resultAdmin = mysqli_query($conn, $sqlAdmin);
$rowAdmin = mysqli_fetch_assoc($resultAdmin);
$AdminName = $rowAdmin['AdminName'];
$AdminEmail = $rowAdmin['AdminEmail'];
$ProfilePicture = $rowAdmin['ProfilePicture'];

// Check if ProfilePicture is null or empty and set it to the default picture URL if needed
if (empty($ProfilePicture)) {
    $ProfilePicture = "images/profile.png";
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Ample lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Ample admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Ample Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>Hotel S Damansara Dashboard</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <!-- Custom CSS -->
    <link href="dashcss/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">

                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav d-none d-md-block d-lg-none">
                        <li class="nav-item">
                            <a class="nav-toggler nav-link waves-effect waves-light text-white"
                                href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li>
                            <a class="profile-pic" href="#">
                                <img src="<?php echo $ProfilePicture; ?>" alt="user-img" width="36" class="img-circle">
                                <span class="text-white font-medium">
                                    <?php echo $AdminName; ?>
                                </span></a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="sidebar-item pt-2">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboardAdmin.php" aria-expanded="false">
                            <i class="far fa-clock" aria-hidden="true"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <!-- View Homepage Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php" aria-expanded="false">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span class="hide-menu">View Homepage</span>
                        </a>
                    </li>
                    <!-- Profile Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="profileAdmin.php" aria-expanded="false">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span class="hide-menu">Profile</span>
                        </a>
                    </li>
                    <!-- Customer Table Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="customertable.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Customer Table</span>
                        </a>
                    </li>
					<!-- Staff Table Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="stafftable.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Staff Table</span>
                        </a>
                    </li>
                    <!-- Staff Room Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="Room.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Room</span>
                        </a>
                    </li>
					<li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="RoomEdit.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Edit Room</span>
                        </a>
                    </li>
					<li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="roomBookingHistory.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Room Booking History</span>
                        </a>
                    </li>
                    <!-- Staff Facilities Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="Facilities.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Facilities</span>
                        </a>
                    </li>
					<li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="FacilityEdit.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Edit Facilities</span>
                        </a>
                    </li>
					<li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="facilityBookingHistory.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Facility Booking History</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="events.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Events</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="eventEdit.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Edit events</span>
                        </a>
                    </li>
                    <!-- Admin Enquiry Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="ViewEnquiry.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">View Enquiry</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="ContactUsEdit.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Edit Contact Us / About Us</span>
                        </a>
                    </li>
                    <!-- Log Out Link -->
					<li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="LogOut.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Log Out</span>
                        </a>
                    </li>
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
					<div class="col-sm-12">
						<div class="white-box">
							<h3 class="box-title">Booking Table</h3>
							<div class="table-responsive">
								<table class="table text-nowrap">
									<thead>
										<tr>
											<th class="border-top-0">Booking ID</th>
											<th class="border-top-0">Customer Email</th>
											<th class="border-top-0">Room Type</th>
											<th class="border-top-0">Check-In Date</th>
											<th class="border-top-0">Check-Out Date</th>
											<th class="border-top-0">No. of Occupants</th>
											<th class="border-top-0">Facility Choice</th>
											<th class="border-top-0">Special Requests</th>
											<th class="border-top-0">Total Price</th>
											<th class="border-top-0">Status</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$rowNumber = 1;
										while ($row = mysqli_fetch_assoc($result)) {
											$bookingID = $row['BookingID'];
											echo "<tr>";
											echo "<td>" . $bookingID . "</td>";
											echo "<td>" . $row['CustEmail'] . "</td>";
											echo "<td>" . $row['roomType'] . "</td>";
											echo "<td>" . $row['CheckInDate'] . "</td>";
											echo "<td>" . $row['CheckOutDate'] . "</td>";
											echo "<td>" . $row['NoOccupant'] . "</td>";
											echo "<td>" . $row['FacilityChoice'] . "</td>";
											echo "<td>" . $row['SpecialReq'] . "</td>";
											echo "<td>" . $row['TotalPrice'] . "</td>";
											echo "<td>" . $row['status'] . "</td>";
											echo "<td colspan='8'><button class='btn btn-primary EditModalBtn' data-id='$bookingID' data-custemail='{$row['CustEmail']}' data-roomtype='{$row['roomType']}' data-checkindate='{$row['CheckInDate']}' data-checkoutdate='{$row['CheckOutDate']}' data-nooccupant='{$row['NoOccupant']}' data-facilitychoice='{$row['FacilityChoice']}' data-specialreq='{$row['SpecialReq']}' data-totalprice='{$row['TotalPrice']}' data-status='{$row['status']}'>EDIT</button></td>";
											//echo "<td colspan='8'><button class='btn btn-danger deleteButton' data-id='$bookingID'>DELETE</button></td>";
											echo "<td colspan='8'><button class='btn btn-danger cancelButton' data-id='$bookingID'>CANCEL</button></td>";
											echo "</tr>";
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- EDIT CUSTOMER MODAL -->
    <!-- ============================================================== -->
    <div id="myModal" class="modal">
		<div class="modal-content">
			<span id="closeModalBtn" class="close">&times;</span>
			<div class="col-lg-8">
				<div class="card shadow-sm">
					<div class="card-header bg-transparent border-0">
						<h3 class="mb-0"><i class="far fa-clone pr-1"></i>EDIT BOOKING</h3>
					</div>
					<div class="card-body pt-0" style="max-height: 80vh; overflow-y: auto;">
						<form method="post" action="EditfunctionBooking.php">
							<div class="form-group">
								<label for="bookingID">Booking ID</label>
								<input type="text" id="bookingID" name="bookingID" class="form-control" value="" readonly>
							</div>
							<div class="form-group">
								<label for="custEmail">Customer Email</label>
								<input type="email" id="custEmail" name="custEmail" class="form-control" value="" readonly>
							</div>
							<div class="form-group">
								<label for="roomType">Room Type</label>
								<input type="text" id="roomType" name="roomType" class="form-control" value="" readonly>
							</div>
							<div class="form-group">
								<label for="checkInDate">Check-In Date</label>
								<input type="date" id="checkInDate" name="checkInDate" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="checkOutDate">Check-Out Date</label>
								<input type="date" id="checkOutDate" name="checkOutDate" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="noOccupant">No. of Occupants</label>
								<input type="number" id="noOccupant" name="noOccupant" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="facilityChoice">Facility Choice</label>
								<input type="text" id="facilityChoice" name="facilityChoice" class="form-control">
							</div>
							<div class="form-group">
								<label for="specialReq">Special Requests</label>
								<textarea id="specialReq" name="specialReq" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label for="totalPrice">Total Price</label>
								<input type="text" id="totalPrice" name="totalPrice" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="status">Status</label>
								<input type="text" id="status" name="status" class="form-control" required>
							</div>
							<div class="form-group">
								<button type="submit" name="edit_booking" class="btn btn-primary">EDIT BOOKING</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js2/app-style-switcher.js"></script>
    <!--Wave Effects -->
    <script src="js2/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js2/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js2/custom.js"></script>

    <script>
    // Select all elements with the class "EditModalBtn"
	const editButtons = document.querySelectorAll(".EditModalBtn");
	const modal = document.getElementById("myModal");
	const closeModalBtn = document.getElementById("closeModalBtn");
	const custEmailInput = document.getElementById("custEmail");
	const roomTypeInput = document.getElementById("roomType");
	const checkInDateInput = document.getElementById("checkInDate");
	const checkOutDateInput = document.getElementById("checkOutDate");
	const noOccupantInput = document.getElementById("noOccupant");
	const facilityChoiceInput = document.getElementById("facilityChoice");
	const specialReqInput = document.getElementById("specialReq");
	const totalPriceInput = document.getElementById("totalPrice");
	const statusInput = document.getElementById("status");

	// Function to open the modal and populate it with data
	function openModal(bookingID, custEmail, roomType, checkInDate, checkOutDate, noOccupant, facilityChoice, specialReq, totalPrice, status) {
		// Populate the modal inputs with the retrieved data
		document.getElementById("bookingID").value = bookingID;
		custEmailInput.value = custEmail;
		roomTypeInput.value = roomType;
		checkInDateInput.value = checkInDate;
		checkOutDateInput.value = checkOutDate;
		noOccupantInput.value = noOccupant;
		facilityChoiceInput.value = facilityChoice;
		specialReqInput.value = specialReq;
		totalPriceInput.value = totalPrice;
		statusInput.value = status;

		// Show the modal
		modal.style.display = "block";
	}

	// Add a click event listener to each edit button
	editButtons.forEach(function (button) {
		button.addEventListener("click", function () {
			const bookingID = button.getAttribute("data-id");
			const custEmail = button.getAttribute("data-custemail");
			const roomType = button.getAttribute("data-roomtype");
			const checkInDate = button.getAttribute("data-checkindate");
			const checkOutDate = button.getAttribute("data-checkoutdate");
			const noOccupant = button.getAttribute("data-nooccupant");
			const facilityChoice = button.getAttribute("data-facilitychoice");
			const specialReq = button.getAttribute("data-specialreq");
			const totalPrice = button.getAttribute("data-totalprice");
			const status = button.getAttribute("data-status");

			openModal(bookingID, custEmail, roomType, checkInDate, checkOutDate, noOccupant, facilityChoice, specialReq, totalPrice, status);
		});
	});

	// Close the modal when the close button is clicked
	closeModalBtn.addEventListener("click", function () {
		modal.style.display = "none";
	});

	// Close the modal if the user clicks anywhere outside of it
	window.addEventListener("click", function (event) {
		if (event.target === modal) {
			modal.style.display = "none";
		}
	});
	</script>
    <script>
    // Select all elements with the class "cancelButton"
    const cancelButtons = document.querySelectorAll(".cancelButton");

    // Function to handle CANCEL button click event
    function handleCancelButtonClick(event) {
        // Retrieve the data-id attribute value (which is the booking ID)
        const id = event.target.getAttribute("data-id");

        // Send an AJAX request to update the status in the database
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "CancelBooking.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Reload the page to see the updated data
                window.location.reload();
            }
        };
        xhr.send("bookingID=" + id);
    }

    // Add a click event listener to each CANCEL button
    cancelButtons.forEach(function (button) {
        button.addEventListener("click", handleCancelButtonClick);
    });
</script>
    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>