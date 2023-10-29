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

    // Use a prepared statement to fetch binary image data
    $sql = "SELECT facilityAvailable, facilityPrice, facilityImage, facilityDescription FROM facilities WHERE facilityType = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $facilityType);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($facilityAvailable, $facilityPrice, $facilityImage, $facilityDescription);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        $facilityInfo['facilityAvailability'] = $facilityAvailable;
        $facilityInfo['facilityPrice'] = $facilityPrice;
        $facilityInfo['facilityImage'] = $facilityImage;
        $facilityInfo['facilityDescription'] = $facilityDescription;
    } else {
        // Handle the case when the facility type is not found
        $facilityInfo['facilityAvailability'] = 0; // Facility not available
        $facilityInfo['facilityPrice'] = "N/A";
        $facilityInfo['facilityImage'] = "images/HotelDefault.jpg";
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
                                <a href="customerHomepage.php">Home</a>
								<a href="profilePage.php">Profile</a>
								<a href="aboutC.php">About</a>
								<a href="galleryC.php">Events</a>
								<a href="serviceC.php">Service</a>
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
					
					// Check if roomImage is empty and set a default image URL
					if (empty($facilityImage)) {
						$facilityImage = "images/HotelDefault.png"; // Use forward slashes for the path
					}
                    ?>
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="img-box">
                                <img src="images/<?php echo $facilityImage; ?>" alt="<?php echo $facilityType; ?>">
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
                                    <a href="Facilitybooking.php?facilityType=<?php echo urlencode($facilityType); ?>">Book Facility</a>
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