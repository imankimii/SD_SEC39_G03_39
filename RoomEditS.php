<?php
session_start();
if (!isset($_SESSION['StaffEmail'])) {
    header('Location: LogIn.php');
    exit();
}
require_once "database_connection.php";

$sql = "SELECT * FROM room";
$result = mysqli_query($conn, $sql);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$StaffEmail = $_SESSION['StaffEmail'];
$sqlStaff = "SELECT * FROM staff WHERE StaffEmail = '$StaffEmail'";
$resultStaff = mysqli_query($conn, $sqlStaff);
$rowStaff = mysqli_fetch_assoc($resultStaff);
$StaffName = $rowStaff['StaffName'];
$StaffEmail = $rowStaff['StaffEmail'];
$ProfilePicture = $rowStaff['ProfilePicture'];

// Check if ProfilePicture is null or empty, and set it to the default picture URL if needed
if (empty($ProfilePicture)) {
  $ProfilePicture = "images\profile.png";
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
									<span class="text-white font-medium"><?php echo $StaffName; ?></span></a>
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
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboardStaff.php" aria-expanded="false">
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
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="profileStaff.php" aria-expanded="false">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span class="hide-menu">Profile</span>
                        </a>
                    </li>
                    <!-- Customer Table Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="customertableS.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Customer Table</span>
                        </a>
                    </li>
                    <!-- Staff Table Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="stafftableS.php" aria-expanded="false">
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
                    <!-- Staff Room Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="RoomEditS.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Edit Room</span>
                        </a>
                    </li>
                    <!-- Staff Facilities Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="Facilities.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Facilities</span>
                        </a>
                    </li><!-- Staff Room Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="FacilityEditS.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Edit Facilities</span>
                        </a>
                    </li>
                    <!-- Staff Enquiry Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="ViewEnquiryS.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">View Enquiry</span>
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
							<h3 class="box-title">Room Table</h3>
							<div class="table-responsive">
								<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<tr>
												<th>Room Type</th>
												<th>Room Number</th>
												<th>Room Price</th>
												<th>Room Quantity</th>
												<th>Room Available</th>
                                                <th>Room Image</th>
												<th>Room Description</th>
												<th>Action</th>
											</tr>
										</tr>
									</thead>
									<tbody>
										<?php
										$rowNumber = 1;
										while ($row = mysqli_fetch_assoc($result)) {
											$roomType = $row['roomType'];
											echo "<tr>";
											echo "<td>" . $roomType . "</td>";
											echo "<td>" . $row['roomNum'] . "</td>";
											echo "<td>" . $row['roomPrice'] . "</td>";
											echo "<td>" . $row['roomQuantity'] . "</td>";
											echo "<td>" . $row['roomAvailable'] . "</td>";
                                            echo "<td>" . $row['roomImage'] . "</td>";
											echo "<td>" . $row['roomDescription'] . "</td>";
											echo "<td><button class='btn btn-primary EditModalBtn' data-roomType='$roomType' data-roomNum='{$row['roomNum']}' data-roomPrice='{$row['roomPrice']}' data-roomQuantity='{$row['roomQuantity']}' data-roomAvailable='{$row['roomAvailable']}' data-roomImage='{$row['roomImage']}' data-roomDescription='{$row['roomDescription']}'>EDIT</button></td>";
											echo "<td><button class='btn btn-danger deleteButton' data-roomType='$roomType'>DELETE</button></td>";
											echo "</tr>";
										}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="8"><button id="AddModalBtn" class='btn btn-success'>ADD</button></td>
										</tr>
									</tfoot>
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
	<!-- EDIT ROOM MODAL -->
<div id="myModalRoom" class="modal">
    <div class="modal-content">
        <span id="closeModalBtnRoom" class="close">&times;</span>
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h3 class="mb-0"><i class="far fa-clone pr-1"></i>EDIT ROOM</h3>
                </div>
                <div class="card-body pt-0">
                    <form method="post" action="EditfunctionRoomS.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="roomType">Room Type</label>
                            <input type="text" id="roomType" name="roomType" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="roomNum">Room Number</label>
                            <input type="text" id="roomNum" name="roomNum" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="roomPrice">Room Price</label>
                            <input type="text" id="roomPrice" name="roomPrice" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="roomQuantity">Room Quantity</label>
                            <input type="text" id="roomQuantity" name="roomQuantity" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="roomAvailable">Room Available</label>
                            <input type="text" id="roomAvailable" name="roomAvailable" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="roomImage">Room Image</label>
                            <input type="file" id="roomImage" name="roomImage" accept="image/jpeg, image/png, image/jpg" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="roomDescription">Room Description</label>
                            <textarea id="roomDescription" name="roomDescription" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="edit_room" class="btn btn-primary">EDIT ROOM</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

	<!-- ADD ROOM MODAL -->
	<div id="myModalAddRoom" class="modal">
		<div class="modal-content">
			<span id="closeModalBtnAddRoom" class="close">&times;</span>
			<div class="col-lg-8">
				<div class="card shadow-sm">
					<div class="card-header bg-transparent border-0">
						<h3 class="mb-0"><i class="far fa-clone pr-1"></i>ADD ROOM</h3>
					</div>
					<div class="card-body pt-0">
						<form method="post" action="AddfunctionRoomS.php">
							<div class="form-group">
								<label for="roomTypeAdd">Room Type</label>
								<input type="text" id="roomType" name="roomType" class="form-control">
							</div>
							<div class="form-group">
								<label for="roomNumAdd">Room Number</label>
								<input type="text" id="roomNum" name="roomNum" class="form-control">
							</div>
							<div class="form-group">
								<label for="roomPriceAdd">Room Price</label>
								<input type="text" id="roomPrice" name="roomPrice" class="form-control">
							</div>
							<div class="form-group">
								<label for="roomQuantityAdd">Room Quantity</label>
								<input type="text" id="roomQuantity" name="roomQuantity" class="form-control">
							</div>
							<div class="form-group">
								<label for="roomAvailableAdd">Room Available</label>
								<input type="text" id="roomAvailable" name="roomAvailable" class="form-control">
							</div>
                            <div class="form-group">
                                <label for="roomImageAdd">Room Image</label>
                                <input type="file" id="roomImage" name="roomImage" id="input-file" accept="image/jpeg, image/png, image/jpg" class="form-control">
                            </div>   
							<div class="form-group">
								<label for="roomDescriptionAdd">Room Description</label>
								<textarea id="roomDescription" name="roomDescription" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<button type="submit" name="add_room" class="btn btn-primary">ADD ROOM</button>
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
    const editRoomButtons = document.querySelectorAll(".EditModalBtn");
    const modalRoom = document.getElementById("myModalRoom");
    const closeModalBtnRoom = document.getElementById("closeModalBtnRoom");
    const roomTypeInput = document.getElementById("roomType");
    const roomNumInput = document.getElementById("roomNum");
    const roomPriceInput = document.getElementById("roomPrice");
    const roomQuantityInput = document.getElementById("roomQuantity");
    const roomAvailableInput = document.getElementById("roomAvailable");
    const roomImageInput = document.getElementById("roomImage");
    const roomDescriptionInput = document.getElementById("roomDescription");

    // Function to open the modal and populate it with data
    function openRoomModal(roomType, roomNum, roomPrice, roomQuantity, roomAvailable, roomImage, roomDescription) {
        // Populate the modal inputs with the retrieved data
        roomTypeInput.value = roomType;
        roomNumInput.value = roomNum;
        roomPriceInput.value = roomPrice;
        roomQuantityInput.value = roomQuantity;
        roomAvailableInput.value = roomAvailable;
        roomDescriptionInput.value = roomDescription;

        // Display the current room image, checking for an empty roomImage
        if (roomImage) {
            roomImageInput.src = roomImage;
        } else {
            roomImageInput.src = "images/HotelDefault.png"; // Set the default image
        }

        // Show the modal
        modalRoom.style.display = "block";
    }

    // Add a click event listener to each edit button
    editRoomButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const roomType = button.getAttribute("data-roomType");
            const roomNum = button.getAttribute("data-roomNum");
            const roomPrice = button.getAttribute("data-roomPrice");
            const roomQuantity = button.getAttribute("data-roomQuantity");
            const roomAvailable = button.getAttribute("data-roomAvailable");
            const roomImage = button.getAttribute("data-roomImage");
            const roomDescription = button.getAttribute("data-roomDescription");
            openRoomModal(roomType, roomNum, roomPrice, roomQuantity, roomAvailable, roomImage, roomDescription);
        });
    });

    // Close the room modal when the close button is clicked
    closeModalBtnRoom.addEventListener("click", function () {
        modalRoom.style.display = "none";
    });

    // Close the room modal if the user clicks anywhere outside of it
    window.addEventListener("click", function (event) {
        if (event.target === modalRoom) {
            modalRoom.style.display = "none";
        }
    });

    // Handling ADD ROOM modal
    document.getElementById("AddModalBtn").addEventListener("click", function () {
        document.getElementById("myModalAddRoom").style.display = "block";
    });

    document.getElementById("closeModalBtnAddRoom").addEventListener("click", function () {
        document.getElementById("myModalAddRoom").style.display = "none";
    });

    // Close the ADD ROOM modal if the user clicks anywhere outside of it
    window.addEventListener("click", function (event) {
        const modal = document.getElementById("myModalAddRoom");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // Handling DELETE ROOM button
    const deleteRoomButtons = document.querySelectorAll(".deleteButton");

    function handleDeleteRoomButtonClick(event) {
        const roomType = event.target.getAttribute("data-roomType");
        // Redirect to the deletion script (DeletefunctionRoom.php)
        window.location.href = 'DeletefunctionRoomS.php?roomType=' + roomType;
    }

    deleteRoomButtons.forEach(function (button) {
        button.addEventListener("click", handleDeleteRoomButtonClick);
    });
</script>
	<script>
	let inputFile = document.getElementById("roomImage");
		inputFile.onchange = function () {
			if (inputFile.files.length > 0) {
				let selectedImage = inputFile.files[0];
			currentRoomImage.src = URL.createObjectURL(selectedImage);
			}
		}
	</script>
	<script>
    let inputFile = document.getElementById("input-file");
        inputFile.onchange = function (){
            if (inputFile.files.length > 0){
                let selectedImage = inputFile.files[0];
            profileImage.src = URL.createObjectURL(selectedImage);
			}
        }
    </script> 
	<?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>