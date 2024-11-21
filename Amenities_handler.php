<?php
include 'dbcon.php';
header('Content-Type: application/json'); // Ensure JSON response
ini_set('display_errors', 1); // Show errors for debugging
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the request method is POST to handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?? '');
    $image = $_FILES['image'] ?? null;

    // Debugging output
    if (empty($category)) {
        echo json_encode(["success" => false, "message" => "Category is empty."]);
        exit;
    }

    // Check if image is set and is a valid file type
    if ($image && $image['error'] === 0) {
        $imageData = file_get_contents($image['tmp_name']); // Read the image file
        $imageType = mysqli_real_escape_string($conn, $image['type']); // Get the image type

        // Validate file type and size (limit: 5MB)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($imageType, $allowed_types) && $image["size"] < 52428800) {
            // Insert into database with image data
            $stmt = $conn->prepare("INSERT INTO amenities (category, image, image_type) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $category, $imageData, $imageType); // Correct binding


            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Amenity uploaded successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Database insertion failed: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Invalid file type or file size too large."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Missing category or image."]);
    }
    exit;
}


// Fetch amenities
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM amenities";
    $result = $conn->query($sql);
    $amenities = [];

    while ($row = $result->fetch_assoc()) {
        $row['image'] = base64_encode($row['image']); // This is correct
        $amenities[] = $row;
    }
    
    echo json_encode($amenities);
    exit;
}

// Handle DELETE request to remove an amenity
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = intval($input['id']); // Sanitize ID input

    // Check if the ID exists in the database
    $sql = "SELECT image FROM amenities WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Delete the database entry
        $sql = "DELETE FROM amenities WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Amenity removed successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Amenity not found."]);
    }
    exit;
}

$conn->close();
?>
