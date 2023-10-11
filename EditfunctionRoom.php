<?php
session_start();

if (!isset($_SESSION['AdminEmail'])) {
    header('Location: LogIn.php');
    exit();
}

require_once "database_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_room'])) {
        $roomType = mysqli_real_escape_string($conn, $_POST['roomType']);
        $roomNum = mysqli_real_escape_string($conn, $_POST['roomNum']);
        $roomPrice = mysqli_real_escape_string($conn, $_POST['roomPrice']);
        $roomQuantity = mysqli_real_escape_string($conn, $_POST['roomQuantity']);
        $roomAvailable = mysqli_real_escape_string($conn, $_POST['roomAvailable']);
        $roomDescription = mysqli_real_escape_string($conn, $_POST['roomDescription']);
        $newImageName = $_FILES['roomImage']['name']; // Get the new image name

        if ($_FILES['roomImage']['error'] === 0) {
            $imageTmpName = $_FILES['roomImage']['tmp_name'];
            $imageType = $_FILES['roomImage']['type'];

            if (strpos($imageType, 'image/') === 0) {
                $uploadDirectory = 'images/';
                $targetPath = $uploadDirectory . $newImageName; // Use the new image name

                if (move_uploaded_file($imageTmpName, $targetPath)) {
                    // Image uploaded successfully

                    // Remove the old image from the server, if applicable
                    $oldImageName = fetchOldImageName($conn, $roomType);
                    if ($oldImageName) {
                        // Delete the old image
                        unlink($uploadDirectory . $oldImageName);
                    }

                    // Update the room data
                    $sql = "UPDATE room SET 
                        roomNum = '$roomNum',
                        roomPrice = '$roomPrice',
                        roomQuantity = '$roomQuantity',
                        roomAvailable = '$roomAvailable',
                        roomDescription = '$roomDescription',
                        roomImage = '$newImageName'  -- Update with the new image name
                        WHERE roomType = '$roomType'";

                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        // Room data updated successfully
                        header('Location: RoomEdit.php');
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
            $sql = "UPDATE room SET 
                roomNum = '$roomNum',
                roomPrice = '$roomPrice',
                roomQuantity = '$roomQuantity',
                roomAvailable = '$roomAvailable',
                roomDescription = '$roomDescription'
                WHERE roomType = '$roomType'";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Room data updated successfully
                header('Location: RoomEdit.php');
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}

// Helper function to fetch the old image name
function fetchOldImageName($conn, $roomType) {
    $sql = "SELECT roomImage FROM room WHERE roomType = '$roomType'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['roomImage'];
    } else {
        return false;
    }
}

// Close the database connection
mysqli_close($conn);
?>