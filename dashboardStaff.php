<?php
session_start();
// Check if the Staff is logged in
if (!isset($_SESSION['StaffEmail'])) {
  header('Location: LogIn.php');
  exit();
}
require_once "database_connection.php";

/* Fetch Staff Name and Email */
$StaffEmail = $_SESSION['StaffEmail'];
$sql = "SELECT * FROM staff WHERE StaffEmail = '$StaffEmail'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$StaffName = $row['StaffName'];
$StaffEmail = $row['StaffEmail'];
$ProfilePicture = $row['ProfilePicture'];

// Check if ProfilePicture is null or empty, and set it to the default picture URL if needed
if (empty($ProfilePicture)) {
  $ProfilePicture = "images\profile.png";
}

// Fetch data for the graph from the bookinghistory table
$graphDataQuery = "SELECT MONTH(CheckInDate) as month, SUM(TotalPrice) as total_price
                  FROM bookinghistory
                  GROUP BY MONTH(CheckInDate)";
$graphDataResult = mysqli_query($conn, $graphDataQuery);

// Initialize arrays to store labels and series data for the graph
$labels = [];
$series = [[]];

// Initialize total profit and total booking variables
$totalProfit = 0;
$totalBooking = 0;

while ($row = mysqli_fetch_assoc($graphDataResult)) {
    $labels[] = date("F", mktime(0, 0, 0, $row['month'], 1));
    $series[0][] = $row['total_price'];

    // Update total profit
    $totalProfit += $row['total_price'];

    // Fetch and update total booking count
    $bookingCountQuery = "SELECT COUNT(*) as booking_count
                         FROM bookinghistory
                         WHERE MONTH(CheckInDate) = {$row['month']}";
    $bookingCountResult = mysqli_query($conn, $bookingCountQuery);
    $bookingCountRow = mysqli_fetch_assoc($bookingCountResult);
    $totalBooking += $bookingCountRow['booking_count'];
}

// Fetch and update total staff count
$totalStaffQuery = "SELECT COUNT(*) as total_staff FROM staff";
$totalStaffResult = mysqli_query($conn, $totalStaffQuery);
$totalStaffRow = mysqli_fetch_assoc($totalStaffResult);
$totalStaff = $totalStaffRow['total_staff'];
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Ample lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Ample admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description" content="Ample Admin Lite is powerful and clean admin dashboard template, inspired by Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>Admin Hotel S Damansara Dashboard</title>
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <link href="dashcss/style.min.css" rel="stylesheet">
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
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

        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation -->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <!-- Dashboard Link -->
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

        <div class="page-wrapper">
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">Dashboard</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-12">
						<div class="white-box analytics-info">
							<h3 class="box-title">Total Profit</h3>
							<ul class="list-inline two-part d-flex align-items-center mb-0">
								<li>
									<div id="sparklinedash"><canvas width="67" height="30"
											style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
									</div>
								</li>
								<li class="ms-auto"><span class="counter text-success"><?php echo $totalProfit; ?> (Ringgit Malaysia)</span></li>
							</ul>
						</div>
					</div>
                    <div class="col-lg-4 col-md-12">
						<div class="white-box analytics-info">
							<h3 class="box-title">Total Booking</h3>
							<ul class="list-inline two-part d-flex align-items-center mb-0">
								<li>
									<div id="sparklinedash2"><canvas width="67" height="30"
											style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
									</div>
								</li>
								<li class="ms-auto"><span class="counter text-purple"><?php echo $totalBooking; ?></span></li>
							</ul>
						</div>
					</div>
                    <div class="col-lg-4 col-md-12">
					<div class="white-box analytics-info">
						<h3 class="box-title">Total Staff</h3>
						<ul class="list-inline two-part d-flex align-items-center mb-0">
							<li>
								<div id="sparklinedash3"><canvas width="67" height="30"
										style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
								</div>
							</li>
							<li class="ms-auto"><span class="counter text-info"><?php echo $totalStaff; ?></span></li>
						</ul>
					</div>
				</div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Monthly Sales</h3>
                            <div id="ct-visits" style="height: 305px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js2/app-style-switcher.js"></script>
        <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="js2/waves.js"></script>
        <script src="js2/sidebarmenu.js"></script>
        <script src="js2/custom.js"></script>
        <script src="plugins/bower_components/chartist/dist/chartist.min.js"></script>
        <script src="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
        <script src="js2/pages/dashboards/dashboard1.js"></script>
        <script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>

        <script>
            var data = {
                labels: <?php echo json_encode($labels); ?>,
                series: <?php echo json_encode($series); ?>
            };

            var options = {
                width: '100%',
                height: '300px',
                showArea: false,
                showPoint: true,
                showLine: true,
                fullWidth: true,
                chartPadding: {
                    right: 40
                }
            };

            new Chartist.Line('#ct-visits', data, options);
        </script>
    </body>

</html>