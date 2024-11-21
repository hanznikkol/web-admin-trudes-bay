<?php  
// Database connection
$servername = "localhost"; // or your server name
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "db_trudes"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file-upload'])) {
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["file-upload"]["name"], PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($_FILES["file-upload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file-upload"]["size"] > 500000) { // Limit file size to 500KB
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Get image data and encode to Base64
        $image_data = file_get_contents($_FILES["file-upload"]["tmp_name"]);
        $base64Image = base64_encode($image_data); // Encode to Base64
        $image_type = mysqli_real_escape_string($conn, $_FILES["file-upload"]["type"]); // Get the image type

        // Save the Base64 encoded image data to the database
        $sql = "INSERT INTO dashboard_upload (image_data, image_type) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $base64Image, $image_type); // s for string, since base64 is a string

        if ($stmt->execute() === TRUE) {
            echo "The file has been uploaded and the image data has been saved to the database.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close(); // Close the prepared statement
    }
}

// Close the database connection
$conn->close();

// At the end of upload.php
header('Location: AdminIndex.php'); // Redirect back to AdminIndex.php
exit();
?>
