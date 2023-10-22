<?php
session_start();
require_once "database_connection.php";

if (isset($_POST['add_facility'])) {
    // Retrieve form data
    $facilityType = $_POST['facilityType'];
    $facilityPrice = $_POST['facilityPrice'];
    $facilityAvailable = $_POST['facilityAvailable'];
    $facilityDescription = $_POST['facilityDescription'];

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO facilities (facilityType, facilityPrice, facilityAvailable, facilityDescription, facilityImage) 
        VALUES (?, ?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        $facilityImage = $_FILES['facilityImage']['name']; // Get the new image name

        // Bind the parameters to the statement
        mysqli_stmt_bind_param($stmt, "siss", $facilityType, $facilityPrice, $facilityAvailable, $facilityDescription, $facilityImage);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Insertion successful, redirect to the same page or another page
            header("Location: FacilityEdit.php"); // Adjust to the appropriate destination
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
    $targetFile = $targetDirectory . basename($_FILES["facilityImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if it's a valid image file
    $check = getimagesize($_FILES["facilityImage"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File is not an image.')</script>";
        echo "<script>window.location.href='FacilityEdit.php'</script>"; // Adjust to the appropriate destination
        $uploadOk = 0;
    }

    // Check if file already exists, you may want to handle this differently
    if (file_exists($targetFile)) {
        echo "<script>alert('Sorry, file already exists.')</script>";
        echo "<script>window.location.href='FacilityEdit.php'</script>"; // Adjust to the appropriate destination
        $uploadOk = 0;
    }

    // Check file size (you can adjust this limit as needed)
    if ($_FILES["facilityImage"]["size"] > 500000) {
        echo "<script>alert('Sorry, your file is too large.')</script>";
        echo "<script>window.location.href='FacilityEdit.php'</script>"; // Adjust to the appropriate destination
        $uploadOk = 0;
    }

    // Allow only certain file formats (you can add more formats)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "<script>alert('Sorry, only JPG, JPEG, and PNG files are allowed.')</script>";
        echo "<script>window.location.href='FacilityEdit.php'</script>"; // Adjust to the appropriate destination
        $uploadOk = 0;
    }

    // If everything is okay, upload the file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["facilityImage"]["tmp_name"], $targetFile)) {
            // Update the facility image in the database
            $sql = "UPDATE facilities SET facilityImage = '$targetFile' WHERE facilityType = '$facilityType'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                // Successfully updated the facility image
                echo "<script>alert('Facility Image Updated Successfully!')</script>";
                echo "<script>window.location.href='FacilityEdit.php'</script>"; // Adjust to the appropriate destination
            } else {
                echo "<script>alert('Error updating facility image in the database.')</script>";
                echo "<script>window.location.href='FacilityEdit.php'</script>"; // Adjust to the appropriate destination
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
            echo "<script>window.location.href='FacilityEdit.php'</script>"; // Adjust to the appropriate destination
        }
    }

} else {
    echo "Invalid request.";
}
?>