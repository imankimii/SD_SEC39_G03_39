<?php
session_start();
if (!isset($_SESSION['AdminEmail'])) {
    header('Location: LogIn.php');
    exit();
}
require_once "database_connection.php";

$sql = "SELECT * FROM events"; // Assuming "events" is the table name
$result = mysqli_query($conn, $sql);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$AdminEmail = $_SESSION['AdminEmail'];
$sqlAdmin = "SELECT * FROM Admin WHERE AdminEmail = '$AdminEmail'";
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
                                <!--<img src="plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle">-->
                                <span class="text-white font-medium">
                                    <?php echo $AdminName; ?>
                                </span>
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
                        <!-- Dashboard Link -->
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
                            <h3 class="box-title">Events Table</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Event Type</th>
                                            <th>Event Price</th>
                                            <th>Event Available</th>
                                            <th>Event Description</th>
                                            <th>Event Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rowNumber = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $eventType = $row['eventType'];
                                            echo "<tr>";
                                            echo "<td>" . $eventType . "</td>";
                                            echo "<td>" . $row['eventPrice'] . "</td>";
                                            echo "<td>" . $row['eventAvailable'] . "</td>";
                                            echo "<td>" . $row['eventDescription'] . "</td>";
                                            echo "<td>" . $row['eventImage'] . "</td>";
                                            echo "<td><button class='btn btn-primary EditModalBtn' data-eventType='$eventType' data-eventPrice='{$row['eventPrice']}' data-eventAvailable='{$row['eventAvailable']}' data-eventDescription='{$row['eventDescription']}'>EDIT</button></td>";
                                            echo "<td><button class='btn btn-danger deleteButton' data-eventType='$eventType'>DELETE</button></td>";
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
    <!-- EDIT event MODAL -->
    <div id="myModalevent" class="modal">
        <div class="modal-content">
            <span id="closeModalBtnevent" class="close">&times;</span>
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0"><i class="far fa-clone pr-1"></i>EDIT event</h3>
                    </div>
                    <div class="card-body pt-0">
                        <form method="post" action="Editfunctionevent.php">
                            <div class="form-group">
                                <label for="eventType">event Type</label>
                                <input type="text" id="eventType" name="eventType" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="eventPrice">event Price</label>
                                <input type="text" id="eventPrice" name="eventPrice" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="eventAvailable">event Available</label>
                                <input type="text" id="eventAvailable" name="eventAvailable" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="eventDescription">event Description</label>
                                <textarea id="eventDescription" name="eventDescription"
                                    class="form-control"><?php echo $eventDescription; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="eventImage">Event Image</label>
                                <input type="file" id="eventImage" name="eventImage"
                                    accept="image/jpeg, image/png, image/jpg" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="edit_event" class="btn btn-primary">EDIT event</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD event MODAL -->
    <div id="myModalAddevent" class="modal">
        <div class="modal-content">
            <span id="closeModalBtnAddevent" class="close">&times;</span>
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0"><i class="far fa-clone pr-1"></i>ADD event</h3>
                    </div>
                    <div class="card-body pt-0">
                        <form method="post" action="Addfunctionevent.php">
                            <div class="form-group">
                                <label for="eventTypeAdd">Event Type</label>
                                <input type="text" id="eventType" name="eventType" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="eventPriceAdd">Event Price</label>
                                <input type="text" id="eventPrice" name="eventPrice" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="eventAvailableAdd">Event Available</label>
                                <input type="text" id="eventAvailable" name="eventAvailable" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="eventDescriptionAdd">Event Description</label>
                                <textarea id="eventDescription" name="eventDescription" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="eventImage">Event Image</label>
                                <input type="file" id="eventImage" name="eventImage"
                                    accept="image/jpeg, image/png, image/jpg" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="add_event" class="btn btn-primary">ADD Event</button>
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
        const editeventButtons = document.querySelectorAll(".EditModalBtn");
        const modalevent = document.getElementById("myModalevent");
        const closeModalBtnevent = document.getElementById("closeModalBtnevent");
        const eventTypeInput = document.getElementById("eventType");
        const eventPriceInput = document.getElementById("eventPrice");
        const eventAvailableInput = document.getElementById("eventAvailable");
        const eventDescriptionInput = document.getElementById("eventDescription");

        // Function to open the modal and populate it with data
        function openeventModal(eventType, eventPrice, eventAvailable, eventImage, eventDescription) {
            // Populate the modal inputs with the retrieved data
            eventTypeInput.value = eventType;
            eventPriceInput.value = eventPrice;
            eventAvailableInput.value = eventAvailable;
            eventDescriptionInput.value = eventDescription; // Use .value here

            // Show the modal
            modalevent.style.display = "block";
        }


        // Add a click event listener to each edit button
        editeventButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                const eventType = button.getAttribute("data-eventType");
                const eventPrice = button.getAttribute("data-eventPrice");
                const eventAvailable = button.getAttribute("data-eventAvailable");
                const eventImage = button.getAttribute("data-eventImage");
                const eventDescription = button.getAttribute("data-eventDescription");
                openeventModal(eventType, eventPrice, eventAvailable, eventImage, eventDescription);
            });
        });

        // Close the event modal when the close button is clicked
        closeModalBtnevent.addEventListener("click", function () {
            modalevent.style.display = "none";
        });

        // Close the event modal if the user clicks anywhere outside of it
        window.addEventListener("click", function (event) {
            if (event.target === modalevent) {
                modalevent.style.display = "none";
            }
        });

        // Handling ADD event modal
        document.getElementById("AddModalBtn").addEventListener("click", function () {
            document.getElementById("myModalAddevent").style.display = "block";
        });

        document.getElementById("closeModalBtnAddevent").addEventListener("click", function () {
            document.getElementById("myModalAddevent").style.display = "none";
        });

        // Close the ADD event modal if the user clicks anywhere outside of it
        window.addEventListener("click", function (event) {
            const modal = document.getElementById("myModalAddevent");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });

        // Handling DELETE event button
        const deleteeventButtons = document.querySelectorAll(".deleteButton");

        function handleDeleteeventButtonClick(event) {
            const eventType = event.target.getAttribute("data-eventType");
            // Redirect to the deletion script (Deletefunctionevent.php)
            window.location.href = 'Deletefunctionevent.php?eventType=' + eventType;
        }

        deleteeventButtons.forEach(function (button) {
            button.addEventListener("click", handleDeleteeventButtonClick);
        });
    </script>
    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>