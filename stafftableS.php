<?php
session_start();
if (!isset($_SESSION['StaffEmail'])) {
  header('Location: LogIn.php');
  exit();
}
require_once "database_connection.php";

$sql = "SELECT * FROM staff";
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
                                <!--<img src="plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle">-->
                                <span class="text-white font-medium"><?php echo $StaffName; ?></span>
							</a>
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
					<li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="roomBookingHistoryS.php" aria-expanded="false">
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
                    </li><!-- Staff Room Link -->
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="FacilityEditS.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Edit Facilities</span>
                        </a>
                    </li>
					<li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="facilityBookingHistoryS.php" aria-expanded="false">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu">Facility Booking History</span>
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
                            <h3 class="box-title">Staff Table</h3>
                            <div class="table-responsive">
								<table class="table text-nowrap">
									<thead>
										<tr>
											<th class="border-top-0">Staff ID</th>
											<th class="border-top-0">Staff Name</th>
											<th class="border-top-0">Staff Email</th>
											<th class="border-top-0">Gender</th>
											<th class="border-top-0">Race</th>
											<th class="border-top-0">No Phone</th>
											<th class="border-top-0">State</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$rowNumber = 1;
										while ($row = mysqli_fetch_assoc($result)) {
											echo "<tr>";
											echo "<td>" . $row['StaffID'] . "</td>";
											echo "<td>" . $row['StaffName'] . "</td>";
											echo "<td>" . $row['StaffEmail'] . "</td>";
											echo "<td>" . $row['Gender'] . "</td>";
											echo "<td>" . $row['Race'] . "</td>";
											echo "<td>" . $row['NoPhone'] . "</td>";
											echo "<td>" . $row['State'] . "</td>";
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
	
	<?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>