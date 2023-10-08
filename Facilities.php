<?php
session_start();
require_once "database_connection.php";
$errors = array();

// Function to get all available facility types from the database
function getAllFacilityTypes($conn)
{
    $facilityTypes = array();
    $sql = "SELECT DISTINCT facilityType FROM facilities";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $facilityTypes[] = $row["facilityType"];
        }
    }

    return $facilityTypes;
}

// Function to get facility information from the database for a specific facility type
function getFacilityInfo($conn, $facilityType)
{
    $facilityInfo = array();

    // Query the database to get facility information for the specified facility type
    $sql = "SELECT facilityAvailable, facilityPrice, facilityImage, facilityDescription FROM facilities WHERE facilityType = '$facilityType'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Retrieve facility information
        $row = $result->fetch_assoc();
        $facilityInfo['facilityAvailability'] = $row["facilityAvailable"];
        $facilityInfo['facilityPrice'] = $row["facilityPrice"];
        $facilityInfo['facilityImage'] = $row["facilityImage"];
        $facilityInfo['facilityDescription'] = $row["facilityDescription"];
    } else {
        // Handle the case when the facility type is not found
        $facilityInfo['facilityAvailability'] = 0; // Facility not available
        $facilityInfo['facilityPrice'] = "N/A";
        $facilityInfo['facilityImage'] = "images/placeholder.jpg";
        $facilityInfo['facilityDescription'] = "N/A";
    }

    return $facilityInfo;
}

// Get all available facility types
$facilityTypes = getAllFacilityTypes($conn);
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

    <title>Hotel S Damansara - Facilities</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />

    <!-- lightbox Gallery-->
    <link rel="stylesheet" href="css/ekko-lightbox.css" />

    <!-- font awesome style -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />
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
                                <a href="LogIn.php">Log In</a>
                                <a href="index.php">Home</a>
                                <a href="about.php">About</a>
                                <a href="gallery.php">Events</a>
                                <a href="service.php">Service</a>
                                <a href="Facilities.php">Facilities</a>
                                <a href="Room.php">Book room</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- end header section -->


    <!-- facilities section -->
    <section class="blog_section layout_padding">
        <div class="container-fluid">
            <div class="heading_container">
                <h2>
                    Facilities
                </h2>
            </div>
            <div class="row">
                <?php
                // Loop through each facility type
                foreach ($facilityTypes as $facilityType) {
                    // Get facility information from the database for each facility type
                    $facilityInfo = getFacilityInfo($conn, $facilityType);
                    $facilityAvailability = $facilityInfo['facilityAvailability'];
                    $facilityPriceDisplay = $facilityInfo['facilityPrice'];
                    $facilityImage = $facilityInfo['facilityImage'];
                    $facilityDescription = $facilityInfo['facilityDescription'];
                    ?>
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="img-box">
                                <img src="<?php echo $facilityImage; ?>" alt="<?php echo $facilityType; ?>">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    <?php echo $facilityType; ?>
                                </h5>
                                <p>
                                    <?php echo $facilityDescription; ?>
                                </p>
                                <p>
                                    Facility price: RM <?php echo $facilityPriceDisplay; ?> per hour
                                </p>
                                <?php if ($facilityAvailability > 0) { ?>
                                    <p>
                                        Quantity: <?php echo $facilityAvailability; ?> Facility
                                    </p>
                                    <p>
                                        Facility availability: Facility is available
                                    </p>
                                    <a href="">Book Facility</a>
                                <?php } else { ?>
                                    <p>
                                        Quantity: <?php echo $facilityAvailability; ?> Facility
                                    </p>
                                    <p>
                                        Facility availability: Facility not available
                                    </p>
                                    <button disabled>Not Available</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- end facilities section -->

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
                            Sri Damansara Hotel is a business run by a family from Sabah, east Malaysian Borneo. This stunning hotel
                            is equipped with modern structures and at night sports so many flickering lights that makes it appear as
                            if out of a 1960’s Hong Kong movie.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <h4>
                        Contact Us
                    </h4>
                    <div class="info_contact">
                        <a href="">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <span>
                                No.1, Jalan Cempaka SD 12/5 Bandar Sri Damansara PJU9, 52200 Wilayah Persekutuan, Wilayah Persekutuan Kuala Lumpur
                            </span>
                        </a>
                        <a href="">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <span>
                                Call +603-6280-5000
                            </span>
                        </a>
                        <a href="">
                            <i class="fa fa-envelope"></i>
                            <span>
                                HotelSDamansara@gmail.com
                            </span>
                        </a>
                        <a href="">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            <span>
                                Operation time (24 Hours)
                            </span>
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

    <!-- jQuery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.js"></script>
    <!-- Custom JS -->
    <script src="js/custom.js"></script>

</body>

</html>