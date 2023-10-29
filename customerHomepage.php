<?php
session_start();
// Check if the customer is not logged in
if(!isset($_SESSION['CustEmail'])){
    header('Location: LogIn.php');
    exit();
}

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
} else {
    // Handle the case where no contact information is found in the database
    $address = "No address available.";
    $phone = "No phone number available.";
    $email = "No email available.";
}

// Fetch the About Us description from the database without specifying 'id'
$sql = "SELECT AboutDescription FROM aboutus LIMIT 1"; // Use LIMIT 1 to fetch a single row
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $aboutDescription = $row['AboutDescription'];

    // Define the maximum length for the shortened description
    $maxDescriptionLength = 250;

    // Truncate the description if it's longer than the maximum length
    if (strlen($aboutDescription) > $maxDescriptionLength) {
        $shortDescription = substr($aboutDescription, 0, $maxDescriptionLength) . "...";
    } else {
        $shortDescription = $aboutDescription;
    }
} else {
    // Handle the case where no data is found in the database
    $shortDescription = "About Us description not available.";
}

// Close the database connection
mysqli_close($conn);
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
  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="customerHomepage.php">
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

  <!-- slider section -->
  <section class="slider_section position-relative">
    <div id="customCarousel1" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="img_container">
            <div class="img-box">
              <img src="images/slider-bg.jpg" class="" alt="...">
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="img_container">
            <div class="img-box">
              <img src="images/slider-bg.jpg" class="" alt="...">
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="img_container">
            <div class="img-box">
              <img src="images/slider-bg.jpg" class="" alt="...">
            </div>
          </div>
        </div>
      </div>
      <div class="carousel_btn_box">
        <a class="carousel-control-prev" href="#customCarousel1" role="button" data-slide="prev">
          <i class="fa fa-arrow-left" aria-hidden="true"></i>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#customCarousel1" role="button" data-slide="next">
          <i class="fa fa-arrow-right" aria-hidden="true"></i>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    <div class="detail-box">
      <div class="col-md-8 col-lg-6 mx-auto">
        <div class="inner_detail-box">
          <h1>
            Hotel S Damansara
          </h1>
          <p>
            Hotel S.Damansara is a unique boutique hotel where modern facilities and comforts encased 
			within a business and leisure concept. Hotel S. Damansara, infuses Malaysian traditions with 
			modern contemporary, evoking style and flavor with grace, warm hospitality and efficiency, with a good night's stay.
          </p>
          <div>
            <a href="RoomC.php" class="slider-link">
              BOOK ROOM
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end slider section -->

  <!-- about section -->
  <section class="about_section layout_padding ">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="img-box">
            <img src="images/about-img.jpg" alt="">
          </div>
        </div>
		<div class="col-md-6">
		  <div class="detail-box">
			<div class="heading_container">
			  <h2>
				About Us
			  </h2>
			</div>
			<p>
			  <span id="aboutShortDescription">
				<?php echo $shortDescription; ?>
			  </span>
			</p>
			<?php if (strlen($aboutDescription) > $maxDescriptionLength) : ?>
			  <a href="about.php">Read More</a>
			<?php endif; ?>
		  </div>
		</div>
      </div>
    </div>
  </section>
  <!-- end about section -->

  <!-- gallery section -->

  <div class="gallery_section layout_padding2">
    <div class="container-fluid">
      <div class="heading_container heading_center">
        <h2>
          Events
        </h2>
      </div>
      <div class="row">
        <div class=" col-sm-6 col-md-4 px-0">
          <div class="img-box">
            <img src="images/g1.jpg" alt="">
            <a href="images/g1.jpg" data-toggle="lightbox" data-title="Birthday Party" data-gallery="gallery">
              <i class="fa fa-picture-o" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 px-0">
          <div class="img-box">
            <img src="images/g2.jpg" alt="">
            <a href="images/g2.jpg" data-toggle="lightbox" data-title="Reunion" data-gallery="gallery">
              <i class="fa fa-picture-o" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 px-0">
          <div class="img-box">
            <img src="images/g3.jpg" alt="">
            <a href="images/g3.jpg" data-toggle="lightbox" data-title="Wedding" data-gallery="gallery">
              <i class="fa fa-picture-o" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 px-0">
          <div class="img-box">
            <img src="images/g4.jpg" alt="">
            <a href="images/g4.jpg" data-toggle="lightbox" data-title="Wedding" data-gallery="gallery">
              <i class="fa fa-picture-o" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 px-0">
          <div class="img-box">
            <img src="images/g5.jpg" alt="">
            <a href="images/g5.jpg" data-toggle="lightbox" data-title="Conference" data-gallery="gallery">
              <i class="fa fa-picture-o" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 px-0">
          <div class="img-box">
            <img src="images/g6.jpg" alt="">
            <a href="images/g6.jpg" data-toggle="lightbox" data-title="Seminar" data-gallery="gallery">
              <i class="fa fa-picture-o" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="btn-box">
        <a href="gallery.php">
          BOOK EVENT
        </a>
      </div>
    </div>
  </div>

  <!-- end gallery section -->


  <!-- service section -->

  <section class="service_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Services
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="images/s1.jpg" alt="" style="width:128px;height:128px;">
            </div>
            <div class="detail-box">
              <h5>
                Hall rental
              </h5>
              <p>
                The hall can accomodate various events and the hall it is expandable
              </p>
              <a href="FacilitiesC.php">
                Read More
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="images/s2.jpg" alt="" style="width:128px;height:128px;">
            </div>
            <div class="detail-box">
              <h5>
                Dining
              </h5>
              <p>
                Buffet dining service is also available in the hotel
              </p>
              <a href="FacilitiesC.php">
                Read More
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="images/s3.jpg" alt="">
            </div>
            <div class="detail-box">
              <h5>
                Shuttle Service
              </h5>
              <p>
                Shuttle service toward nearest public transport is available
              </p>
              <a href="FacilitiesC.php">
                Read More
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>

  <!-- end service section -->



 

  <!-- client section -->

  <section class="client_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Review
        </h2>
      </div>
      <div id="carouselExample2Controls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="row">
              <div class="col-md-11 col-lg-10 mx-auto">
                <div class="box">
                  <div class="img-box">
                    <img src="images/Ash.jpg" alt="" />
                  </div>
                  <div class="detail-box">
                    <div class="name">
                      <h6>
                        AshKetum
                      </h6>
                    </div>
                    <p>
                      Location : walking distance to MRT Sri Damansara Barat. Easy check in and check out process Staff
                      : very helpful Room : comfort bed. Android TV inside the room, so we can enjoy YouTube & Netflix
                      from TV. Got hairdryer. WiFi : laju Breakfast : buffet style, not many varieties but taste OK
                    </p>
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-md-11 col-lg-10 mx-auto">
                <div class="box">
                  <div class="img-box">
                    <<img src="images/Syamim.jpg" alt="" />
                  </div>
                  <div class="detail-box">
                    <div class="name">
                      <h6>
                        Syamim
                      </h6>
                    </div>
                    <p>
                      When i booked it was actually a standard room but the staff upgraded to a deluxe which have very
                      nice view. I love the bfast buffet, especially the nasi goreng. Eventhough i booked through agoda
                      like 5 minutes before checking in, but the staff kindly give me a room even the booking is not
                      updated in their system yet. The best budget hotel so far since they allow for really early check
                      in without additional charge. All in all, i just love this hotel and will definitely come again :)
                    </p>
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-md-11 col-lg-10 mx-auto">
                <div class="box">
                  <div class="img-box">
                    <img src="images/client.jpg" alt="" />
                  </div>
                  <div class="detail-box">
                    <div class="name">
                      <h6>
                        Siaalya
                      </h6>
                    </div>
                    <p>
                      Staff are friendly and helpful Took less than 10 min to check in Free parking available outside of
                      hotel and underground Room and toilet are clean Tv with decent channel but only 5 channel
                      available Aircond is a bit hard to adjust the temperature The space to pray is quite small. It
                      fits just enough to perform prayer Breakfast with wide variety of food. Scrumptious and they kept
                      refilled it
                    </p>
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel_btn-container">
          <a class="carousel-control-prev" href="#carouselExample2Controls" role="button" data-slide="prev">
            <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExample2Controls" role="button" data-slide="next">
            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- end client section -->

  <!-- contact section -->
  <section class="contact_section  ">
    <div class="container">
      <div class="row">
        <div class="col-md-7 col-lg-6 ">
          <div class="form_container">
            <div class="heading_container ">
              <h2>
                Enquiry
              </h2>
            </div>
            <!--Enquiry form-->
            <form method="post" action="Enquiry.php">
              <div>
                <input type="text" name="enquiryName"placeholder="Your Name" />
              </div>
              <div>
                <input type="text" name="enquiryPhone" placeholder="Phone Number" />
              </div>
              <div>
                <input type="email" name="enquiryEmail" placeholder="Email" />
              </div>
              <div>
                <input type="text" name="enquiryMessage" class="message-box" placeholder="Message" />
              </div>
              <div class="btn_box">
                <input type="submit" name="new_enquiry">
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-5 col-lg-6">
          <div class="subscribe-box">
            <h3>
              Submit your review
            </h3>
            <p>
              Post your review here so we can improve ourselves
            </p>
            <form action="">
              <input type="email" placeholder="Enter your review">
              <button>
                Submit Review
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end contact section -->

  <!-- info section -->
  <section class="info_section ">
    <div class="container">
      <div class="row info_main_row">
        <div class="col-md-6 col-lg-5">
          <div class="info_detail">
            <h4>
              Company History
            </h4>
            <p class="mb-0">
              Sri Damansara Hotel is a business run by a family from Sabah, east Malaysian Borneo. This stunning hotel is equipped with modern structures and at night sports so many flickering lights that makes it appear as if out of a 1960’s Hong Kong movie.
            </p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
			<h4>Contact Us</h4>
			<div class="info_contact">
					<a href="#">
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<span><?php echo $address; ?></span>
					</a>
					<a href="#">
						<i class="fa fa-phone" aria-hidden="true"></i>
						<span><?php echo $phone; ?></span>
					</a>
					<a href="mailto:<?php echo $email; ?>">
						<i class="fa fa-envelope"></i>
						<span><?php echo $email; ?></span>
					</a>
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
  <!-- lightbox Gallery-->
  <script src="js/ekko-lightbox.min.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>

</body>
</html>