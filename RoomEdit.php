<?php
session_start();
require_once "database_connection.php";
$errors = array();

if (isset($_POST['update_room'])) {
    // Get the new values from the form
    $newRoomType = $_POST['roomType'];
    $newRoomPrice = $_POST['roomPrice'];
    $newRoomQuantity = $_POST['roomQuantity'];
    $newRoomAvailable = $_POST['roomAvailable'];

    $updateStatements = array();

    if (!empty($newRoomType)) {
        $updateStatements[] = "roomType = '$newRoomType'";
    }
    if (!empty($newRoomPrice)) {
        $updateStatements[] = "roomPrice = '$newRoomPrice'";
    }
    if (!empty($newRoomQuantity)) {
        $updateStatements[] = "roomQuantity = '$newRoomQuantity'";
    }
    if (!empty($newRoomAvailable)) {
        $updateStatements[] = "roomAvailable = '$newRoomAvailable'";
    }

    if (!empty($updateStatements)) {
        // Define the roomType you want to update
        $roomType = "Single Room"; // Update this value as needed

        // Construct and execute the SQL query
        $sql = "UPDATE room SET " . implode(', ', $updateStatements) . " WHERE roomType = '$roomType'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Room updated successfully!')</script>";
            header("Location: Room.php");
        } else {
            echo "<script>alert('Room update failed!')</script>";
        }
    } else {
        echo "<script>alert('Please fill in at least one field!')</script>";
    }
    header('Location: RoomEdit.php');
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
                                <a href="index.php">Home</a>
                                <a href="dashboardStaff.php">Dashboard</a>
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
        <class="container-fluid">
            <div class="heading_container">
                <h2>
                    Room
                </h2>
            </div>
                <div class="col-lg-8">
                    <div class="box">
                        <div class="img-box">
                            <img src="images/R1.jpg" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                Single room
                            </h5>
                            <p>
                                Our Single Bed Room offers a cozy haven for solo travelers.
                                 The room features a comfortable single bed with premium bedding, ensuring a restful night's sleep. 
                                 The en-suite bathroom is well-appointed with modern amenities, providing convenience and comfort. 
                                 Whether you're in town for business or leisure, our Single Bed Room provides a welcoming retreat, 
                                 ensuring a pleasant stay during your visit.
                            </p>
                            <form method="post" action="RoomEdit.php">
                            <div class=form-group>
                                <label for="type">Room Type</label>
                                <?php $roomType = "Single Room"; ?>
                                <input type="text" class="form-control" id="type" name="roomType" value="<?php echo $roomType; ?>" disabled>
                            </div>
                            <div class=form-group>
                                <label for="price">Room Price</label>
                                <input type="number" class="form-control" id="price" name="roomPrice" value="<?php echo $roomPrice; ?>">
                            </div>
                            <div class=form-group>
                                <label for="quantity">Room Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="roomQuantity" value="<?php echo $roomQuantity; ?>">
                            </div>
                            <div class=form-group>
                                <label for="available">Room Availability</label>
                                <input type="number" class="form-control" id="available" name="roomAvailable" value="<?php echo $roomAvailable; ?>">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="update_room" class="btn btn-primary">Save Changes</button>
                            </div>
                            </form>
                            <form method="POST" action="DeleteRoom.php">
                                <input type="hidden" name="roomType" value="<?php echo $roomType; ?>">
                                <button type="submit" name="delete_room">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 ">
                    <div class="box">
                        <div class="img-box">
                            <img src="images/R2.jpg" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                Queen Room
                            </h5>
                            <p>
                                Our Queen Bed Room is designed for those seeking a touch of elegance and extra space during their stay. 
                                The room boasts a luxurious queen-sized bed adorned with high-quality linens, promising a peaceful night's rest. 
                                The en-suite bathroom is a sanctuary of relaxation, featuring modern fixtures and complimentary toiletries. 
                                This room offers a perfect blend of comfort and style, making it an excellent choice for couples or solo travelers 
                                who desire a bit more room to unwind and rejuvenate during their stay at our hotel.
                            </p>
                            <form method="post" action="RoomEdit.php">
                                <div class=form-group>
                                <label for="type">Room Type</label>
                                    <?php $roomType = "Queen Room"; ?>
                                    <input type="text" class="form-control" id="type" name="roomType" value="<?php echo $roomType; ?>" disabled>
                                </div>
                                <div class=form-group>
                                <label for="price">Room Price</label>
                                <input type="number" class="form-control" id="roomPrice" name="roomPrice" value="<?php echo $roomPrice; ?>">
                                </div>
                                <div class=form-group>
                                    <label for="quantity">Room Quantity</label>
                                    <input type="number" class="form-control" id="roomQuantity" name="roomQuantity"
                                        value="<?php echo $roomQuantity; ?>">
                                </div>
                                <div class=form-group>
                                    <label for="available">Room Availability</label>
                                    <input type="number" class="form-control" id="roomAvailable" name="roomAvailable"
                                        value="<?php echo $roomAvailable; ?>">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="update_room" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                            <form method="POST" action="DeleteRoom.php">
                                <input type="hidden" name="roomType" value="<?php echo $roomType; ?>">
                                <button type="submit" name="delete_room">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 ">
                    <div class="box">
                        <div class="img-box">
                            <img src="images/R3.jpg" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                King Room
                            </h5>
                            <p>
                                Indulge in the ultimate comfort and luxury with our King Bed Room. This spacious haven features a plush king-sized bed with premium bedding, 
                                ensuring a restful and opulent night's sleep. 
                                The en-suite bathroom is a serene retreat, complete with modern amenities and complimentary toiletries, creating a spa-like atmosphere for relaxation. 
                                Whether you're celebrating a special occasion or simply desire extra space and extravagance, our King Bed Room is the perfect choice. 
                                Experience the epitome of comfort and style during your stay at our hotel.
                            </p>
                            <form method="post" action="RoomEdit.php">
                                <div class=form-group>
                                <label for="type">Room Type</label>
                                    <?php $roomType = "King Room"; ?>
                                    <input type="text" class="form-control" id="type" name="roomType" value="<?php echo $roomType; ?>"
                                        disabled>
                                </div>
                                <div class=form-group>
                                    <label for="price">Room Price</label>
                                    <input type="number" class="form-control" id="roomPrice" name="roomPrice"
                                        value="<?php echo $roomPrice; ?>">
                                </div>
                                <div class=form-group>
                                    <label for="quantity">Room Quantity</label>
                                    <input type="number" class="form-control" id="roomQuantity" name="roomQuantity"
                                        value="<?php echo $roomQuantity; ?>">
                                </div>
                                <div class=form-group>
                                    <label for="available">Room Availability</label>
                                    <input type="number" class="form-control" id="roomAvailable" name="roomAvailable"
                                        value="<?php echo $roomAvailable; ?>">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="update_room" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                            <form method="POST" action="DeleteRoom.php">
                                <input type="hidden" name="roomType" value="<?php echo $roomType; ?>">
                                <button type="submit" name="delete_room">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 ">
                    <div class="box">
                        <div class="img-box">
                            <img src="images/R3.jpg" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                Budget Room
                            </h5>
                            <p>
                                Indulge in the ultimate comfort and luxury with our King Bed Room. This spacious haven features a plush king-sized bed with premium bedding, 
                                ensuring a restful and opulent night's sleep. 
                                The en-suite bathroom is a serene retreat, complete with modern amenities and complimentary toiletries, creating a spa-like atmosphere for relaxation. 
                                Whether you're celebrating a special occasion or simply desire extra space and extravagance, our King Bed Room is the perfect choice. 
                                Experience the epitome of comfort and style during your stay at our hotel.
                            </p>
                            <form method="post" action="RoomEdit.php">
                                <div class=form-group>
                                <label for="type">Room Type</label>
                                    <?php $roomType = "Budget Room"; ?>
                                    <input type="text" class="form-control" id="type" name="roomType" value="<?php echo $roomType; ?>"
                                        disabled>
                                </div>
                                <div class=form-group>
                                    <label for="price">Room Price</label>
                                    <input type="number" class="form-control" id="roomPrice" name="roomPrice"
                                        value="<?php echo $roomPrice; ?>">
                                </div>
                                <div class=form-group>
                                    <label for="quantity">Room Quantity</label>
                                    <input type="number" class="form-control" id="roomQuantity" name="roomQuantity"
                                        value="<?php echo $roomQuantity; ?>">
                                </div>
                                <div class=form-group>
                                    <label for="available">Room Availability</label>
                                    <input type="number" class="form-control" id="roomAvailable" name="roomAvailable"
                                        value="<?php echo $roomAvailable; ?>">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="update_room" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                            <form method="POST" action="DeleteRoom.php">
                                <input type="hidden" name="roomType" value="<?php echo $roomType; ?>">
                                <button type="submit" name="delete_room">Delete</button>
                            </form>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="AddRoom.php" class="btn btn-success">Add New Room</a>
                    </div>
                    <form method="POST" action="DeleteRoom.php">
                        <input type="hidden" name="roomType" value="<?php echo $row['roomType']; ?>">
                        <button type="submit" name="delete_room">Delete</button>
                    </form>
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
                            Sri Damansara Hotel is a business run by a family from Sabah, east Malaysian Borneo. This
                            stunning hotel
                            is equipped with modern structures and at night sports so many flickering lights that makes
                            it appear as
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
                                No.1, Jalan Cempaka SD 12/5 Bandar Sri Damansara PJU9, 52200 Wilayah Persekutuan,
                                Wilayah Persekutuan Kuala Lumpur
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