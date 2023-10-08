<?php
session_start();
require_once "database_connection.php";
$errors = array();

$facilityTypes = array("Multi-purpose hall", "Gymnasium", "Swimming pool");

$facilityTypeDisplay = "";
$facilityAvailabilityDisplay = "";
$facilityPriceDisplay = "";

function getfacilityAvailability($conn, $facilityType)
{
  $sql = "SELECT * FROM facilities WHERE facilityType = '$facilityType'";
  $result = mysqli_query($conn, $sql);

  if ($result->num_rows > 0) {
    // Retrieve the facilityAvailable value from the first row (assuming there's only one matching row)
    $row = $result->fetch_assoc();
    $facilityAvailable = $row["facilityAvailable"];

    // Set variables for facility type and availability
    $facilityTypeDisplay = $facilityType;
    if ($facilityAvailable == 1) {
      $facilityAvailabilityDisplay = "Facility is available.";
    } else {
      $facilityAvailabilityDisplay = "Facility is not available.";
    }
  } else {
    // Handle the case when the facility type is not found
    $facilityTypeDisplay = "Unknown facility Type";
    $facilityAvailabilityDisplay = "Facility not found in the database for $facilityType.";
  }

  return array($facilityTypeDisplay, $facilityAvailabilityDisplay);
}

function getfacilityPrice($conn, $facilityType)
{
  // Query the database to get the facilityPrice value for the specified facility type
  $sql = "SELECT facilityPrice FROM facilities WHERE facilityType = '$facilityType'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Retrieve the facilityPrice value from the first row (assuming there's only one matching row)
    $row = $result->fetch_assoc();
    $facilityPrice = $row["facilityPrice"];

    // Set variables for facility type and price
    $facilityTypeDisplay = $facilityType;
    $facilityPriceDisplay = $facilityPrice;
  } else {
    // Handle the case when the facility type is not found
    $facilityTypeDisplay = "Unknown facility Type";
    $facilityPriceDisplay = "facility not found in the database for $facilityType.";
  }

  return array($facilityTypeDisplay, $facilityPriceDisplay);
}
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
                <a href="blog.php">Facilities</a>
                <a href="facilities.php">Book facility</a>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <!-- end header section -->


  <!-- facilites section -->
  <section class="blog_section layout_padding">
    <div class="container-fluid">
      <div class="heading_container">
        <h2>
          Facilities
        </h2>
      </div>
      <div class="row">
        <div class="col-lg-8 ">
          <div class="box">
            <div class="img-box">
              <img src="images/F2.jpg" alt="">
            </div>
            <div class="detail-box">
              <h5>
                Multi-purpose hall
              </h5>
              <p>
                Our Multi-Purpose Hall is a versatile and adaptable space designed to cater to a wide range of events. 
                Whether you're hosting a corporate conference, a grand wedding, a social gathering, or any other special occasion, 
                our spacious hall can be tailored to suit your needs. Equipped with state-of-the-art amenities and a team of dedicated professionals, 
                it offers the perfect backdrop for your event, ensuring a seamless and memorable experience for you and your guests.
              </p>
              <?php
              // Get facility price for Multi-purpose hall
              $priceInfo = getfacilityPrice($conn, "Multi-purpose hall");
              $facilityTypeDisplay = $priceInfo[0];
              $facilityPriceDisplay = $priceInfo[1];
              ?>
              <p>
                Facility price: RM <?php echo $facilityPriceDisplay; ?> per hour
              </p>
              <?php
              // Get facility availability for Multi-purpose hall
              $availabilityInfo = getfacilityAvailability($conn, "Multi-purpose hall");
              $facilityTypeDisplay = $availabilityInfo[0];
              $facilityAvailabilityDisplay = $availabilityInfo[1];
              ?>
              <p>
                Facility availability: <?php echo $facilityAvailabilityDisplay; ?>
              </p>
              <?php if ($facilityAvailabilityDisplay === "Facility is available.") { ?>
                <a href="">Book facility</a>
              <?php } else { ?>
                <button disabled>Facility Not Available</button>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-lg-8 ">
          <div class="box">
            <div class="img-box">
              <img src="images/F1.jpg" alt="">
            </div>
            <div class="detail-box">
              <h5>
                Gymnasium
              </h5>
              <p>
                Our gymnasium is a fitness haven, furnished with top-quality exercise equipment, 
                free weights, and cardio machines to help you achieve your fitness objectives. 
                Whether you're a seasoned fitness enthusiast or a newcomer looking to get started, 
                our well-maintained gym provides an inviting atmosphere. Our knowledgeable trainers 
                are available to offer guidance and support, ensuring you get the most out of every workout. 
                Stay fit and invigorated during your stay at our gymnasium.
              </p>
              <?php
              // Get facility price for Gymnasium
              $priceInfo = getfacilityPrice($conn, "Gymnasium");
              $facilityTypeDisplay = $priceInfo[0];
              $facilityPriceDisplay = $priceInfo[1];
              ?>
              <p>
                Facility price: RM
                <?php echo $facilityPriceDisplay; ?> per hour
              </p>
              <?php
              // Get facility availability for Gymnasium
              $availabilityInfo = getfacilityAvailability($conn, "Gymnasium");
              $facilityTypeDisplay = $availabilityInfo[0];
              $facilityAvailabilityDisplay = $availabilityInfo[1];
              ?>
              <p>

                Facility availability:
                <?php echo $facilityAvailabilityDisplay; ?>
              </p>
                <?php if ($facilityAvailabilityDisplay === "Facility is available.") { ?>
                  <a href="">Book facility</a>
                <?php } else { ?>
                  <button disabled>Facility Not Available</button>
                <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-lg-8 ">
          <div class="box">
            <div class="img-box">
              <img src="images/F3.jpg" alt="">
            </div>
            <div class="detail-box">
              <h5>
                Swimming pool
              </h5>
              <p>
                Dive into relaxation and leisure at our refreshing swimming pool. 
                Surrounded by lush greenery and featuring crystal-clear waters, 
                our pool is the perfect oasis for guests to unwind and enjoy a 
                rejuvenating swim. Whether you want to swim laps for a great workout 
                or simply bask in the sun on our comfortable loungers, our swimming pool 
                offers a serene escape from the hustle and bustle of daily life. Soak in 
                the tranquility and take a refreshing dip during your stay at our inviting swimming pool.
              </p>
              <?php
              // Get facility price for Swimming pool
              $priceInfo = getfacilityPrice($conn, "Swimming pool");
              $facilityTypeDisplay = $priceInfo[0];
              $facilityPriceDisplay = $priceInfo[1];
              ?>
              <p>
                Facility price: RM
                <?php echo $facilityPriceDisplay; ?> per hour
              </p>
              <?php
              // Get facility availability for Swimming pool
              $availabilityInfo = getfacilityAvailability($conn, "Swimming pool");
              $facilityTypeDisplay = $availabilityInfo[0];
              $facilityAvailabilityDisplay = $availabilityInfo[1];
              ?>
              <p>
                Facility availability:
                <?php echo $facilityAvailabilityDisplay; ?>
              </p>
              <?php if ($facilityAvailabilityDisplay === "Facility is available.") { ?>
                <a href="">Book facility</a>
              <?php } else { ?>
                <button disabled>Facility Not Available</button>
              <?php } ?>
            </div>
          </div>
        </div>
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


  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>

</body>

</html>