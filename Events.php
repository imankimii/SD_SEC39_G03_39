<?php
session_start();
require_once "database_connection.php";
$errors = array();

// Function to get all available event types from the database
function getAlleventTypes($conn)
{
    $eventTypes = array();
    $sql = "SELECT DISTINCT eventType FROM events";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $eventTypes[] = $row["eventType"];
        }
    }

    return $eventTypes;
}

// Function to get event information from the database for a specific event type
function geteventInfo($conn, $eventType)
{
    $eventInfo = array();

    // Query the database to get event information for the specified event type
    $sql = "SELECT eventAvailable, eventPrice, eventImage, eventDescription FROM events WHERE eventType = '$eventType'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Retrieve event information
        $row = $result->fetch_assoc();
        $eventInfo['eventAvailability'] = $row["eventAvailable"];
        $eventInfo['eventPrice'] = $row["eventPrice"];
        $eventInfo['eventImage'] = $row["eventImage"];
        $eventInfo['eventDescription'] = $row["eventDescription"];
    } else {
        // Handle the case when the event type is not found
        $eventInfo['eventAvailability'] = 0; // event not available
        $eventInfo['eventPrice'] = "N/A";
        $eventInfo['eventImage'] = "images/HotelDefault.jpg";
        $eventInfo['eventDescription'] = "N/A";
    }

    return $eventInfo;
}

// Get all available event types
$eventTypes = getAlleventTypes($conn);
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

    <title>Hotel S Damansara - events</title>

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
                                <a href="events.php">Events</a>
                                <a href="Room.php">Room</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- end header section -->


    <!-- events section -->
    <section class="blog_section layout_padding">
        <div class="container-fluid">
            <div class="heading_container">
                <h2>
                    events
                </h2>
            </div>
            <div class="row">
                <?php
                // Loop through each event type
                foreach ($eventTypes as $eventType) {
                    // Get event information from the database for each event type
                    $eventInfo = geteventInfo($conn, $eventType);
                    $eventAvailability = $eventInfo['eventAvailability'];
                    $eventPriceDisplay = $eventInfo['eventPrice'];
                    $eventImage = $eventInfo['eventImage'];
                    $eventDescription = $eventInfo['eventDescription'];

                    // Check if roomImage is empty and set a default image URL
                    if (empty($eventImage)) {
                        $eventImage = "images/HotelDefault.png"; // Use forward slashes for the path
                    }
                    ?>
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="img-box">
                                <img src="<?php echo $eventImage; ?>" alt="<?php echo $eventType; ?>">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    <?php echo $eventType; ?>
                                </h5>
                                <p>
                                    <?php echo $eventDescription; ?>
                                </p>
                                <p>
                                    event price: RM
                                    <?php echo $eventPriceDisplay; ?> per hour
                                </p>
                                <?php if ($eventAvailability > 0) { ?>
                                    <p>
                                        Quantity:
                                        <?php echo $eventAvailability; ?> event
                                    </p>
                                    <p>
                                        Event availability: Event is available
                                    </p>
                                    <a href="">Book event</a>
                                <?php } else { ?>
                                    <p>
                                        Quantity:
                                        <?php echo $eventAvailability; ?> event
                                    </p>
                                    <p>
                                        Event availability: Event not available
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

    <!-- end events section -->

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
                            Sri Damansara Hotel is a business run by a family from Sabah, east Malaysian Borneo. This
                            stunning hotel
                            is equipped with modern structures and at night sports so many flickering lights that makes
                            it appear as
                            if out of a 1960’s Hong Kong movie.
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

    <!-- jQuery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.js"></script>
    <!-- Custom JS -->
    <script src="js/custom.js"></script>

</body>

</html>