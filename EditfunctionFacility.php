<?php
session_start();

if (!isset($_SESSION['AdminEmail'])) {
    header('Location: LogIn.php');
    exit();
}

require_once "database_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_facility'])) {
        $facilityType = mysqli_real_escape_string($conn, $_POST['facilityType']);
        $facilityPrice = mysqli_real_escape_string($conn, $_POST['facilityPrice']);
        $facilityAvailable = mysqli_real_escape_string($conn, $_POST['facilityAvailable']);
        $facilityDescription = mysqli_real_escape_string($conn, $_POST['facilityDescription']);
        $newImageName = $_FILES['facilityImage']['name']; // Get the new image name

        if ($_FILES['facilityImage']['error'] === 0) {
            $imageTmpName = $_FILES['facilityImage']['tmp_name'];
            $imageType = $_FILES['facilityImage']['type'];

            if (strpos($imageType, 'image/') === 0) {
                $uploadDirectory = 'images/'; // Set your upload directory
                $targetPath = $uploadDirectory . $newImageName; // Use the new image name

                if (move_uploaded_file($imageTmpName, $targetPath)) {
                    // Image uploaded successfully

                    // Remove the old image from the server, if applicable
                    $oldImageName = fetchOldImageName($conn, $facilityType);
                    if ($oldImageName) {
                        // Delete the old image
                        unlink($uploadDirectory . $oldImageName);
                    }

                    // Update the facility data
                    $sql = "UPDATE facilities SET 
                        facilityPrice = '$facilityPrice',
                        facilityAvailable = '$facilityAvailable',
                        facilityDescription = '$facilityDescription',
                        facilityImage = '$newImageName' -- Update with the new image name
                        WHERE facilityType = '$facilityType'";

                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        // Facility data updated successfully
                        header('Location: FacilityEdit.php');
                        exit();
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error uploading image.";
                }
            } else {
                echo "Invalid image type. Please upload a valid image.";
            }
        } else {
            // No new image uploaded, only update other fields
            $sql = "UPDATE facilities SET 
                facilityPrice = '$facilityPrice',
                facilityAvailable = '$facilityAvailable',
                facilityDescription = '$facilityDescription'
                WHERE facilityType = '$facilityType'";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Facility data updated successfully
                header('Location: FacilityEdit.php');
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}

// Helper function to fetch the old image name
function fetchOldImageName($conn, $facilityType) {
    $sql = "SELECT facilityImage FROM facilities WHERE facilityType = '$facilityType'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['facilityImage'];
    } else {
        return false;
    }
}

// Close the database connection
mysqli_close($conn);
?>