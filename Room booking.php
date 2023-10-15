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
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        main {
            margin: 20px;
        }

        .booking-form {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        form label, form input, form button {
            display: block;
            margin: 10px 0;
        }

        form label {
            display: inline-block;
            width: 40%; /* Set the width for labels to align properly */
        }

        form input {
            display: inline-block;
            width: 40%; /* Set the width for inputs to align properly */
            padding: 5px; /* Add some padding for better spacing */
        }

        #facilities {
            display: flex;
            flex-wrap: wrap;
        }

        #facilities input {
            margin-left: 1px;
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
        <h1>Hotel Booking</h1>
    </header>

    <main>
        <section class="booking-form">
            <h2>Book a Room</h2>
            <form id="booking-form">
                <label for="check-in">Check-In Date:</label>
                <input type="date" id="check-in" required>

                <label for="check-out">Check-Out Date:</label>
                <input type="date" id="check-out" required>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <div id="occupant-ages">
                    <label for="adult-age">(Number of occupants):</label>
                    <input type="number" id="adult-age" name="adult-age" min="0" required>

                </div>

                <label for="facilities">Select Facilities:</label>
                <div id="facilities">
                    <input type="checkbox" id="pool" name="facilities" value="Pool">
                    <label for="pool">Pool</label>

                    <input type="checkbox" id="gym" name="facilities" value="Gym">
                    <label for="gym">Gym</label>

                    <input type="checkbox" id="spa" name="facilities" value="Spa">
                    <label for="spa">Spa</label>
                </div>

                <label for="special-request">Special Request:</label>
                <textarea id="special-request" name="special-request" rows="4"></textarea>

                <button type="submit">Book Now</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Your Hotel</p>
    </footer>
</body>
</html>