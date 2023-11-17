<?php
session_start();
if (!isset($_SESSION['CustEmail'])) {
  header('Location: LogIn.php');
  exit();
}
require_once "database_connection.php";

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

// Get room information if roomType is set in the URL
if (isset($_GET['roomType'])) {
    $roomType = $_GET['roomType'];
    $selectedRoomInfo = getRoomInfo($conn, $roomType);
}

// Fetch customer name based on the current customer email
$CustEmail = $_SESSION['CustEmail'];
$sqlCust = "SELECT * FROM customer WHERE CustEmail = '$CustEmail'";
$resultCust = mysqli_query($conn, $sqlCust);
if ($rowCust = mysqli_fetch_assoc($resultCust)) {
    $CustName = $rowCust['CustName'];
} else {
    $CustName = ''; // Set a default value if the customer email is not found
}

// Function to get facility prices from the database
function getFacilityPrices($conn)
{
    $facilityPrices = array();

    $sql = "SELECT facilityType, facilityPrice FROM facilities";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $facilityPrices[$row['facilityType']] = $row['facilityPrice'];
    }

    return $facilityPrices;
}

// Fetch facility prices from the database
$facilityPrices = getFacilityPrices($conn);

// Fetch facility types from the database
$facilityTypes = array();
$sqlFacilities = "SELECT facilityType FROM facilities";
$resultFacilities = mysqli_query($conn, $sqlFacilities);

while ($rowFacilities = mysqli_fetch_assoc($resultFacilities)) {
    $facilityTypes[] = $rowFacilities['facilityType'];
}

// Generate checkboxes and labels for facilities
$facilityCheckboxes = '';
foreach ($facilityTypes as $facilityType) {
    $facilityCheckboxes .= '<label style="display: inline-block; margin-right: 10px;">';
    $facilityCheckboxes .= '<input type="checkbox" name="facilities[]" value="' . $facilityType . '" id="facility-' . $facilityType . '"> ' . $facilityType;
    $facilityCheckboxes .= '</label>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('b1.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        main {
            margin: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center; /* Center the content horizontally */
        }

        .booking-form {
            text-align: center;
            width: 80%; /* Adjust the form width */
            margin: 0 auto; /* Center the form horizontally */
        }

        .booking-form label,
        .booking-form input,
        .booking-form textarea,
        .booking-form button {
            display: block;
            margin: 10px 0;
            width: 100%; /* Make labels and inputs full width */
            text-align: left; /* Align text to the left */
        }

        .booking-form input,
        .booking-form textarea {
            padding: 5px;
        }

        .disabled-field {
            background-color: #f0f0f0; /* Gray background color */
            color: #777; /* Gray text color */
        }

        img.room-image {
            width: 100%; /* Ensure the image takes the full width of its container */
            max-width: 600px; /* Adjust the maximum width to fit your design */
            max-height: 350px; /* Set maximum height to maintain aspect ratio */
        }

        #facilities {
            text-align: left; /* Align the facilities to the left */
        }

        #facilities label {
            display: inline-block; /* Display labels as inline-block to place them next to each other */
            margin-right: 10px; /* Add some spacing between each checkbox and label */
        }

        #facilities label input {
            margin-right: 5px; /* Add some spacing between the checkbox and the label */
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <header>
        <h1>Hotel S Damansara</h1>
    </header>

    <main>
        <section class="booking-form">
            <h2>Book a Room</h2>
            <img src="images/<?php echo $selectedRoomInfo['roomImage']; ?>" alt="<?php echo $roomType; ?>"
                class="room-image">

            <form id="booking-form" class="booking-form" action="processBooking.php" method="post">
					<br>
					<label for="roomType">Room Type:</label>
					<input type="text" id="roomType" name="roomType" class="form-control disabled-field" readonly
						value="<?php if (isset($_GET['roomType'])) echo htmlspecialchars($_GET['roomType']); ?>">

					<br>
					<label for="name">Name:</label>
					<input type="text" id="name" name="name" class="form-control disabled-field" readonly
						value="<?php echo isset($CustName) ? htmlspecialchars($CustName) : 'Your Name'; ?>">

					<br>
					<label for="email">Email:</label>
					<input type="email" id="email" name="email" class="form-control disabled-field" readonly
						value="<?php if (isset($_SESSION['CustEmail'])) echo htmlspecialchars($_SESSION['CustEmail']); ?>">

					<br>
					<label for="check-in">Check-In Date:</label>
					<input type="date" id="check-in" name="check-in" required>

					<br>
					<label for="check-out">Check-Out Date:</label>
					<input type="date" id="check-out" name="check-out" required>

					<br>
					<label for="adult-age">Number of Occupants:</label>
					<input type="number" id="adult-age" name="adult-age" min="0" required>

					<br>
					<label for="facilities">Select Facilities:</label>
					<div id="facilities">
						<?php
						foreach ($facilityTypes as $facilityType) {
							echo '<div style="margin-bottom: 10px;">';
							echo '<span>' . $facilityType . '</span>';
							$inputId = 'facility-hours-' . $facilityType;
							echo '<input type="number" name="facilityHours[' . $facilityType . ']" id="' . $inputId . '" min="0" placeholder="Insert hours for booking any facility">';
							echo '<input type="checkbox" name="facilities[' . $facilityType . ']" value="' . $facilityType . '" id="facility-' . $facilityType . '">';
							echo '</div>';
						}
						?>
					</div>

					<br>
					<label for="special-request">Special Request:</label>
					<textarea id="special-request" name="special-request" rows="4"></textarea>

					<div id="total-price">
						Total Price: RM<span id="price-value">0.00</span>
					</div>
					
					<input type="hidden" id="totalPrice" name="totalPrice" value="">
					
					<button type="submit" style="text-align: center; width: 100%;">Book Now</button>
				</form>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Hotel S Damansara</p>
    </footer>

	<script>
    var facilityPrice = <?php echo json_encode($facilityPrices); ?>;
    var facilityTypes = <?php echo json_encode($facilityTypes); ?>;

    function calculateTotalPrice() {
        var roomPrice = <?php echo $selectedRoomInfo['roomPrice']; ?>;
        var checkInDate = document.getElementById("check-in");
        var checkOutDate = document.getElementById("check-out");
        var totalDaysBooking = 0;

        if (checkInDate.value && checkOutDate.value) {
            var checkIn = new Date(checkInDate.value);
            var checkOut = new Date(checkOutDate.value);
            totalDaysBooking = Math.floor((checkOut - checkIn) / (1000 * 60 * 60 * 24));
        }

        var totalPriceFacility = 0;

        for (var i = 0; i < facilityTypes.length; i++) {
            var facilityType = facilityTypes[i];
            var facilityHoursInput = document.getElementById("facility-hours-" + facilityType);
            var facilityHours = parseFloat(facilityHoursInput.value) || 0;

            if (!isNaN(facilityPrice[facilityType])) {
                totalPriceFacility += facilityHours * facilityPrice[facilityType];
            }
        }

        var totalRoomPrice = roomPrice * totalDaysBooking;
        var totalPrice = totalRoomPrice + totalPriceFacility;

        var priceValue = document.getElementById("price-value");
        priceValue.textContent = totalPrice.toFixed(2);
		
		var priceValue = document.getElementById("price-value");
		var totalPriceInput = document.getElementById("totalPrice");
		totalPriceInput.value = priceValue.textContent;
    }

    calculateTotalPrice();

    var checkInDate = document.getElementById("check-in");
    var checkOutDate = document.getElementById("check-out");
    var adultAge = document.getElementById("adult-age");
    var specialRequest = document.getElementById("special-request");

    checkInDate.addEventListener("change", calculateTotalPrice);
    checkOutDate.addEventListener("change", calculateTotalPrice);
    adultAge.addEventListener("input", calculateTotalPrice);
    specialRequest.addEventListener("input", calculateTotalPrice);

    // Add an event listener to set the input value to 0 when it is focused
    for (var i = 0; i < facilityTypes.length; i++) {
        var facilityType = facilityTypes[i];
        var facilityHoursInput = document.getElementById("facility-hours-" + facilityType);

        if (facilityHoursInput) {
            facilityHoursInput.addEventListener("focus", function () {
                if (this.value === "0") {
                    this.value = "";
                }
            });

            facilityHoursInput.addEventListener("input", function () {
                calculateTotalPrice(); // Update the total price when the user inputs a value
            });
        }
    }

    // PHP variables with selected facility choices
    <?php
    if (isset($_POST['facilities']) && isset($_POST['facilityHours'])) {
        $selectedFacilities = $_POST['facilities'];
        $facilityHours = $_POST['facilityHours'];
    } else {
        $selectedFacilities = [];
        $facilityHours = [];
    }
    ?>

    // Pre-fill input fields based on selected facilities and their hours
    <?php foreach ($facilityTypes as $facilityType) { ?>
        var selectedFacility = <?php echo json_encode($selectedFacilities[$facilityType] ?? ''); ?>;
        var facilityHours = <?php echo json_encode($facilityHours[$facilityType] ?? ''); ?>;
        var facilityHoursInput = document.getElementById('facility-hours-<?php echo $facilityType; ?>');
        var facilityCheckbox = document.getElementById('facility-<?php echo $facilityType; ?>');

        if (selectedFacility) {
            facilityHoursInput.value = facilityHours;
            facilityCheckbox.checked = true;
        }
    <?php } ?>
</script>
</html>