<<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['AdminEmail'])) {
    header('Location: Login.php'); // Change this to your admin login page
    exit();
}

// Database connection code
require_once "database_connection.php";

// File upload handling
if (isset($_POST['upload'])) {
    $AdminEmail = $_SESSION['AdminEmail']; // Change this to the admin's session variable

    $targetDirectory = "uploads/"; // Directory to store uploaded images
    $targetFile = $targetDirectory . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if it's a valid image file
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File is not an image.')</script>";
        echo "<script>window.location.href='profileAdmin.php'</script>"; // Change this to your profileAdmin.php page
        $uploadOk = 0;
    }

    // Check if file already exists, you may want to handle this differently
    if (file_exists($targetFile)) {
        echo "<script>alert('Sorry, file already exists.')</script>";
        echo "<script>window.location.href='profileAdmin.php'</script>"; // Change this to your profileAdmin.php page
        $uploadOk = 0;
    }

    // Check file size (you can adjust this limit as needed)
    if ($_FILES["profile_picture"]["size"] > 500000) {
        echo "<script>alert('Sorry, your file is too large.')</script>";
        echo "<script>window.location.href='profileAdmin.php'</script>"; // Change this to your profileAdmin.php page
        $uploadOk = 0;
    }

    // Allow only certain file formats (you can add more formats)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "<script>alert('Sorry, only JPG, JPEG, and PNG files are allowed.')</script>";
        echo "<script>window.location.href='profileAdmin.php'</script>"; // Change this to your profileAdmin.php page
        $uploadOk = 0;
    }

    // If everything is okay, upload the file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
            // Update the profile picture in the database
            $sql = "UPDATE admin SET ProfilePicture = '$targetFile' WHERE AdminEmail = '$AdminEmail'"; // Change the table and column names
            $result = mysqli_query($conn, $sql);
            if ($result) {
                // Successfully updated the profile picture
                echo "<script>alert('Profile Picture Updated Successfully!')</script>";
                echo "<script>window.location.href='profileAdmin.php'</script>"; // Change this to your profileAdmin.php page
            } else {
                echo "<script>alert('Error updating profile picture in the database.')</script>";
                echo "<script>window.location.href='profileAdmin.php'</script>"; // Change this to your profileAdmin.php page
            }
        } else {
            echo "<script>alert('Error uploading profile picture.')</script>";
            echo "<script>window.location.href='profileAdmin.php'</script>"; // Change this to your profileAdmin.php page
        }
    }
}
?>