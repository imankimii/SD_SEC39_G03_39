<?php
session_start();
require_once "database_connection.php";

if (isset($_POST['add_room'])) {
    // Retrieve form data
    $roomType = $_POST['roomType'];
    $roomNum = $_POST['roomNum'];
    $roomPrice = $_POST['roomPrice'];
    $roomQuantity = $_POST['roomQuantity'];
    $roomAvailable = $_POST['roomAvailable'];
    $roomImage = $_POST['roomImage'];
    $roomDescription = $_POST['roomDescription'];

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO room (roomType, roomNum, roomPrice, roomQuantity, roomAvailable, roomImage, roomDescription) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameters to the statement
        mysqli_stmt_bind_param($stmt, "ssiiiss", $roomType, $roomNum, $roomPrice, $roomQuantity, $roomAvailable, $roomImage, $roomDescription);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Insertion successful, redirect to the same page or another page
            header("Location: RoomEditS.php"); // Replace with the actual page name
            exit();
        } else {
            // Insertion failed, display an error message or handle it accordingly
            echo "Error: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Statement preparation failed, display an error message or handle it accordingly
        echo "Error: " . mysqli_error($conn);
    }

    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["roomImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if it's a valid image file
    $check = getimagesize($_FILES["roomImage"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File is not an image.')</script>";
        echo "<script>window.location.href='RoomEditS.php'</script>";
        $uploadOk = 0;
    }

    // Check if file already exists, you may want to handle this differently
    if (file_exists($targetFile)) {
        echo "<script>alert('Sorry, file already exists.')</script>";
        echo "<script>window.location.href='RoomEditS.php'</script>";
        $uploadOk = 0;
    }

    // Check file size (you can adjust this limit as needed)
    if ($_FILES["roomImage"]["size"] > 500000) {
        echo "<script>alert('Sorry, your file is too large.')</script>";
        echo "<script>window.location.href='RoomEditS.php'</script>";
        $uploadOk = 0;
    }

    // Allow only certain file formats (you can add more formats)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "<script>alert('Sorry, only JPG, JPEG, and PNG files are allowed.')</script>";
        echo "<script>window.location.href='RoomEditS.php'</script>";
        $uploadOk = 0;
    }

    // If everything is okay, upload the file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["roomImage"]["tmp_name"], $targetFile)) {
            // Update the profile picture in the database
            $sql = "UPDATE room SET roomImage = '$targetFile' WHERE roomType = '$roomType'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                // Successfully updated the profile picture
                echo "<script>alert('Room Image Updated Successfully!')</script>";
                echo "<script>window.location.href='RoomEditS.php'</script>";
            } else {
                echo "<script>alert('Error updating room image in the database.')</script>";
                echo "<script>window.location.href='RoomEditS.php'</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
            echo "<script>window.location.href='RoomEditS.php'</script>";
        }
    }

} else {
    echo "Invalid request.";
}
?>