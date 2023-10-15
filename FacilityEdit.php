<?php
session_start();
if (!isset($_SESSION['AdminEmail'])) {
    header('Location: LogIn.php');
    exit();
}
require_once "database_connection.php";

$sql = "SELECT * FROM facilities"; // Assuming "facilities" is the table name
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
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Ample lite admin bootstrap 5 dashboard template, frontend, responsive bootstrap 5 admin template, Ample admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Ample Admin Lite is powerful and clean admin dashboard template, inspired from Bootstrap Framework">
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
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboardAdmin.php"
                                aria-expanded="false">
                                <i class="far fa-clock" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <!-- View Homepage Link -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php"
                                aria-expanded="false">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                <span class="hide-menu">View Homepage</span>
                            </a>
                        </li>
                        <!-- Profile Link -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="profileAdmin.php"
                                aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="hide-menu">Profile</span>
                            </a>
                        </li>
                        <!-- Customer Table Link -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="customertable.php"
                                aria-expanded="false">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">Customer Table</span>
                            </a>
                        </li>
                        <!-- Staff Table Link -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="stafftable.php"
                                aria-expanded="false">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">Staff Table</span>
                            </a>
                        </li>
                        <!-- Staff Room Link -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="Room.php"
                                aria-expanded="false">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">Room</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="RoomEdit.php"
                                aria-expanded="false">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">Edit Room</span>
                            </a>
                        </li>
                        <!-- Staff Facilities Link -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="Facilities.php"
                                aria-expanded="false">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">Facilities</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="FacilityEdit.php"
                                aria-expanded="false">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">Edit Facilities</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="events.php"
                                aria-expanded="false">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">Events</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="eventEdit.php"
                                aria-expanded="false">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">Edit events</span>
                            </a>
                        </li>
                        <!-- Admin Enquiry Link -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="ViewEnquiry.php"
                                aria-expanded="false">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">View Enquiry</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="ContactUsEdit.php"
                                aria-expanded="false">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">Edit Contact Us / About Us</span>
                            </a>
                        </li>
                        <!-- Log Out Link -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="LogOut.php"
                                aria-expanded="false">
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
                            <h3 class="box-title">Facilities Table</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Facility Type</th>
                                            <th>Facility Price</th>
                                            <th>Facility Available</th>
                                            <th>Facility Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rowNumber = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $facilityType = $row['facilityType'];
                                            echo "<tr>";
                                            echo "<td>" . $facilityType . "</td>";
                                            echo "<td>" . $row['facilityPrice'] . "</td>";
                                            echo "<td>" . $row['facilityAvailable'] . "</td>";
                                            echo "<td>" . $row['facilityDescription'] . "</td>";
                                            echo "<td><button class='btn btn-primary EditModalBtn' data-facilityType='$facilityType' data-facilityPrice='{$row['facilityPrice']}' data-facilityAvailable='{$row['facilityAvailable']}' data-facilityDescription='{$row['facilityDescription']}'>EDIT</button></td>";
                                            echo "<td><button class='btn btn-danger deleteButton' data-facilityType='$facilityType'>DELETE</button></td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6"><button id="AddModalBtn"
                                                    class='btn btn-success'>ADD</button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Page Content -->
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
    <!-- EDIT FACILITY MODAL -->
    <div id="myModalFacility" class="modal">
        <div class="modal-content">
            <span id="closeModalBtnFacility" class="close">&times;</span>
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0"><i class="far fa-clone pr-1"></i>EDIT FACILITY</h3>
                    </div>
                    <div class="card-body pt-0">
                        <form method="post" action="EditfunctionFacility.php">
                            <div class="form-group">
                                <label for="facilityType">Facility Type</label>
                                <input type="text" id="facilityType" name="facilityType" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="facilityPrice">Facility Price</label>
                                <input type="text" id="facilityPrice" name="facilityPrice" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="facilityAvailable">Facility Available</label>
                                <input type="text" id="facilityAvailable" name="facilityAvailable" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="facilityDescription">Facility Description</label>
                                <textarea id="facilityDescription" name="facilityDescription"
                                    class="form-control"><?php echo $facilityDescription; ?></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="edit_facility" class="btn btn-primary">EDIT
                                    FACILITY</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD FACILITY MODAL -->
    <div id="myModalAddFacility" class="modal">
        <div class="modal-content">
            <span id="closeModalBtnAddFacility" class="close">&times;</span>
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0"><i class="far fa-clone pr-1"></i>ADD FACILITY</h3>
                    </div>
                    <div class="card-body pt-0">
                        <form method="post" action="AddfunctionFacility.php">
                            <div class="form-group">
                                <label for="facilityTypeAdd">Facility Type</label>
                                <input type="text" id="facilityType" name="facilityType" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="facilityPriceAdd">Facility Price</label>
                                <input type="text" id="facilityPrice" name="facilityPrice" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="facilityAvailableAdd">Facility Available</label>
                                <input type="text" id="facilityAvailable" name="facilityAvailable" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="facilityDescriptionAdd">Facility Description</label>
                                <textarea id="facilityDescription" name="facilityDescription"
                                    class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="add_facility" class="btn btn-primary">ADD FACILITY</button>
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
        const editFacilityButtons = document.querySelectorAll(".EditModalBtn");
        const modalFacility = document.getElementById("myModalFacility");
        const closeModalBtnFacility = document.getElementById("closeModalBtnFacility");
        const facilityTypeInput = document.getElementById("facilityType");
        const facilityPriceInput = document.getElementById("facilityPrice");
        const facilityAvailableInput = document.getElementById("facilityAvailable");
        const facilityDescriptionInput = document.getElementById("facilityDescription");

        // Function to open the modal and populate it with data
        function openFacilityModal(facilityType, facilityPrice, facilityAvailable, facilityImage, facilityDescription) {
            // Populate the modal inputs with the retrieved data
            facilityTypeInput.value = facilityType;
            facilityPriceInput.value = facilityPrice;
            facilityAvailableInput.value = facilityAvailable;
            facilityDescriptionInput.value = facilityDescription; // Use .value here

            // Show the modal
            modalFacility.style.display = "block";
        }


        // Add a click event listener to each edit button
        editFacilityButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                const facilityType = button.getAttribute("data-facilityType");
                const facilityPrice = button.getAttribute("data-facilityPrice");
                const facilityAvailable = button.getAttribute("data-facilityAvailable");
                const facilityImage = button.getAttribute("data-facilityImage");
                const facilityDescription = button.getAttribute("data-facilityDescription");
                openFacilityModal(facilityType, facilityPrice, facilityAvailable, facilityImage, facilityDescription);
            });
        });

        // Close the facility modal when the close button is clicked
        closeModalBtnFacility.addEventListener("click", function () {
            modalFacility.style.display = "none";
        });

        // Close the facility modal if the user clicks anywhere outside of it
        window.addEventListener("click", function (event) {
            if (event.target === modalFacility) {
                modalFacility.style.display = "none";
            }
        });

        // Handling ADD FACILITY modal
        document.getElementById("AddModalBtn").addEventListener("click", function () {
            document.getElementById("myModalAddFacility").style.display = "block";
        });

        document.getElementById("closeModalBtnAddFacility").addEventListener("click", function () {
            document.getElementById("myModalAddFacility").style.display = "none";
        });

        // Close the ADD FACILITY modal if the user clicks anywhere outside of it
        window.addEventListener("click", function (event) {
            const modal = document.getElementById("myModalAddFacility");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });

        // Handling DELETE FACILITY button
        const deleteFacilityButtons = document.querySelectorAll(".deleteButton");

        function handleDeleteFacilityButtonClick(event) {
            const facilityType = event.target.getAttribute("data-facilityType");
            // Redirect to the deletion script (DeletefunctionFacility.php)
            window.location.href = 'DeletefunctionFacility.php?facilityType=' + facilityType;
        }

        deleteFacilityButtons.forEach(function (button) {
            button.addEventListener("click", handleDeleteFacilityButtonClick);
        });
    </script>
    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>