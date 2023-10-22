<?php
session_start();
if (!isset($_SESSION['CustEmail'])) {
  header('Location: LogIn.php');
  exit();
}
require_once "database_connection.php";
$errors = array();

// Function to get all available room types from the database
function getAllRoomTypes($conn)
{
    $roomTypes = array();
    $sql = "SELECT DISTINCT roomType FROM room";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $roomTypes[] = $row["roomType"];
        }
    }

    return $roomTypes;
}

// Function to get room information from the database for a specific room type
function getRoomInfo($conn, $roomType)
{
    $roomInfo = array();

    // Use a prepared statement to fetch binary image data
    $sql = "SELECT roomAvailable, roomPrice, roomImage, roomDescription FROM room WHERE roomType = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $roomType);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($roomAvailable, $roomPrice, $roomImage, $roomDescription);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        $roomInfo['roomAvailability'] = $roomAvailable;
        $roomInfo['roomPrice'] = $roomPrice;
        $roomInfo['roomImage'] = $roomImage;
        $roomInfo['roomDescription'] = $roomDescription;
    } else {
        // Handle the case when the room type is not found
        $roomInfo['roomAvailability'] = 0; // Room not available
        $roomInfo['roomPrice'] = "N/A";
        $roomInfo['roomImage'] = "images/HotelDefault.png";
        $roomInfo['roomDescription'] = "N/A";
    }

    return $roomInfo;
}

// Get all available room types
$roomTypes = getAllRoomTypes($conn);
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


  <!-- room section -->
  <section class="blog_section layout_padding">
    <div class="container-fluid">
      <div class="heading_container">
        <h2>Room</h2>
      </div>
      <div class="row">
        <?php
        // Loop through each room type
        foreach ($roomTypes as $roomType) {
          // Get room information from the database for each room type
          $roomInfo = getRoomInfo($conn, $roomType);
          $roomAvailability = $roomInfo['roomAvailability'];
          $roomPriceDisplay = $roomInfo['roomPrice'];
          $roomImage = $roomInfo['roomImage'];
          $roomDescription = $roomInfo['roomDescription'];

          // Check if roomImage is empty and set a default image URL
          if (empty($roomImage)) {
            $roomImage = "images/HotelDefault.png"; // Use forward slashes for the path
          }
          ?>
          <div class="col-lg-12">
            <div class="box">
              <div class="img-box">
                <img src="images/<?php echo $roomImage; ?>" alt="<?php echo $roomType; ?>">
              </div>
              <div class="detail-box">
                <h5><?php echo $roomType; ?></h5>
                <p><?php echo $roomDescription; ?></p>
                <p>Room price: RM <?php echo $roomPriceDisplay; ?> per night</p>
                <?php if ($roomAvailability > 0) { ?>
					<p>Quantity: <?php echo $roomAvailability; ?> Room</p>
					<p>Room availability: Room is available</p>
					<!-- Modify the "Book Room" link to include the room type as a query parameter -->
					<a href="Roombooking.php?roomType=<?php echo urlencode($roomType); ?>">Book Room</a>
				<?php } else { ?>
					<p>Quantity: <?php echo $roomAvailability; ?> Room</p>
					<p>Room availability: Room not available</p>
					<button disabled>Not Available</button>
				<?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- end room section -->

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


  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>

</body>

</html>