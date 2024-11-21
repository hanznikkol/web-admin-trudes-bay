<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_trudes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the image index from the form submission
$imageIndex = $_POST['image_index'];

// Fetch the images from the database
$sql = "SELECT * FROM dashboard_upload";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Get the row for the image to delete
    $images = [];
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }

    if (isset($images[$imageIndex])) {
        // Get the ID of the image to delete
        $imageId = $images[$imageIndex]['id'];

        // Delete the image from the database
        $sqlDelete = "DELETE FROM dashboard_upload WHERE id = $imageId";
        if ($conn->query($sqlDelete) === TRUE) {
            echo "Image removed successfully";
        } else {
            echo "Error removing image: " . $conn->error;
        }
    }
}

$conn->close();

// Redirect back to the homepage after deletion
header("Location: AdminIndex.php");
exit();
?>
