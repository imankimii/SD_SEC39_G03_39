<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hotel Booking</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/ekko-lightbox.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap">
  <style>
    /* Add your custom styles here */

    /* Styles for the background carousel */
    .carousel-container {
      position: relative;
      width: 100%;
      height: 100vh;
      overflow: hidden;
    }

    .carousel {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .carousel img {
      object-fit: cover;
      width: 100%;
      height: 100%;
    }

    /* Additional styles for the booking form */
    .booking-form {
      background: rgba(255, 255, 255, 0.7);
      padding: 20px;
      border-radius: 10px;
      max-width: 400px;
      margin: 0 auto;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
    }

    .booking-form h1 {
      font-size: 28px;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="date"],
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-group select {
      padding: 10px;
    }

    .form-group button {
      background-color: #e91e63;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      font-size: 18px;
      cursor: pointer;
    }

    .form-group button:hover {
      background-color: #7b1fa2;
    }
  </style>
</head>

<body>
  <div class="carousel-container">
    <div id="imageCarousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="image1.jpg" alt="Image 1">
        </div>
        <div class="carousel-item">
          <img src="image2.jpg" alt="Image 2">
        </div>
        <div class="carousel-item">
          <img src="image3.jpg" alt="Image 3">
        </div>
      </div>
      <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" ariahidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

      <!-- Booking form is inside the carousel container -->
      <div class="booking-form">
        <h1>Make your reservation</h1>
        <form id="booking-form" class="booking-form" action="processBookingFacilities.php" method="POST">
          <div class="form-group">
            <input type="date" required>
          </div>
          <div class="form-group">
            <input type="date" required>
          </div>
          <div class="form-group">
            <input type="text" placeholder="Check-in Time (EX: 2:30 P.M)" required>
          </div>
          <div class="form-group">
            <select name="occupants" required>
              <option value="1"> Select facilities :- </option>
              <option value="2"> Multi-hall</option>
              <option value="3">Indoor pool</option>
              <option value="4"> Gymnasium </option>
            </select>
          </div>
          <div class="form-group">
            <input type="email" placeholder="Enter number of occupants" required>
          </div>
          <div class="form-group">
            <input type="email" placeholder="Enter your Email" required>
          </div>
          <div class="form-group">
            <input type="tel" placeholder="Enter your Phone" required>
          </div>
          <div class="form-group">
            <button type="submit">Book Now</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Include necessary scripts (Bootstrap and other libraries) -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/ekko-lightbox.min.js"></script>
</body>

</html>