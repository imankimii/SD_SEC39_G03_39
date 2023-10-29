<?php
session_start();
if (!isset($_SESSION['CustEmail'])) {
    header('Location: LogIn.php');
    exit();
}
require_once "database_connection.php";

function getFacilityInfo($conn, $facilityType)
{
    $facilityInfo = array();

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
        $facilityInfo['facilityAvailability'] = 0; // Facility not available
        $facilityInfo['facilityPrice'] = "N/A";
        $facilityInfo['facilityImage'] = "images/DefaultFacility.png";
        $facilityInfo['facilityDescription'] = "N/A";
    }

    return $facilityInfo;
}

if (isset($_GET['facilityType'])) {
    $facilityType = $_GET['facilityType'];
    $selectedFacilityInfo = getFacilityInfo($conn, $facilityType);
}

$CustEmail = $_SESSION['CustEmail'];
$sqlCust = "SELECT * FROM customer WHERE CustEmail = '$CustEmail'";
$resultCust = mysqli_query($conn, $sqlCust);
if ($rowCust = mysqli_fetch_assoc($resultCust)) {
    $CustName = $rowCust['CustName'];
} else {
    $CustName = '';
}

function getFacilityTypes($conn)
{
    $facilityTypes = array();
    $sql = "SELECT facilityType FROM facilities";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $facilityTypes[] = $row['facilityType'];
    }
    return $facilityTypes;
}

$facilityTypes = getFacilityTypes($conn);

$facilityCheckboxes = '';
foreach ($facilityTypes as $facilityType) {
    $facilityCheckboxes .= '<label style="display: inline-block; margin-right: 10px;">';
    $facilityCheckboxes .= '<input type="radio" name="facilityType" value="' . $facilityType . '" id="facility-' . $facilityType . '"> ' . $facilityType;
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
            align-items: center;
        }

        .booking-form {
            text-align: center;
            width: 80%;
            margin: 0 auto;
        }

        .booking-form label,
        .booking-form input,
        .booking-form textarea,
        .booking-form button {
            display: block;
            margin: 10px 0;
            width: 100%;
            text-align: left;
        }

        .booking-form input,
        .booking-form textarea {
            padding: 5px;
        }

        .disabled-field {
            background-color: #f0f0f0;
            color: #777;
        }

        img.facility-image {
            width: 100%;
            max-width: 600px;
            max-height: 350px;
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
            <h2>Book a Facility</h2>
            <img src="images/<?php echo $selectedFacilityInfo['facilityImage']; ?>" alt="<?php echo $facilityType; ?>"
                class="facility-image">

            <form id="booking-form" class="booking-form" action="processFacilityBooking.php" method="post">
                <br>
                <label for="facility">Facility Type:</label>
                <input type="text" id="facilityType" name="facilityType" class="form-control disabled-field" readonly
                    value="<?php if (isset($_GET['facilityType'])) echo htmlspecialchars($_GET['facilityType']); ?>">

                <br>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control disabled-field" readonly
                    value="<?php echo isset($CustName) ? htmlspecialchars($CustName) : 'Your Name'; ?>">

                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control disabled-field" readonly
                    value="<?php if (isset($_SESSION['CustEmail'])) echo htmlspecialchars($_SESSION['CustEmail']); ?>">

                <br>
                <label for="booking-date">Booking Date:</label>
                <input type="date" id="booking-date" name="booking-date" required>

                <br>
                <label for="no-of-persons">Number of Persons/Facility:</label>
                <input type="number" id="no-of-persons" name="no-of-persons" min="1" required>

                <br>
                <label for="hours-booked">Hours Booked:</label>
                <input type="number" id="hours-booked" name="hours-booked" min="1" required>

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
        function calculateTotalPrice() {
            var noOfPersons = document.getElementById("no-of-persons");
            var hoursBooked = document.getElementById("hours-booked");
            var totalPrice = noOfPersons.value * hoursBooked.value * <?php echo json_encode($selectedFacilityInfo['facilityPrice']); ?>;
            var priceValue = document.getElementById("price-value");
            priceValue.textContent = totalPrice.toFixed(2);
            var totalPriceInput = document.getElementById("totalPrice");
            totalPriceInput.value = priceValue.textContent;
        }

        calculateTotalPrice();

        var noOfPersons = document.getElementById("no-of-persons");
        var hoursBooked = document.getElementById("hours-booked");
        var specialRequest = document.getElementById("special-request");

        noOfPersons.addEventListener("input", calculateTotalPrice);
        hoursBooked.addEventListener("input", calculateTotalPrice);
        specialRequest.addEventListener("input", calculateTotalPrice);
    </script>
</body>

</html>