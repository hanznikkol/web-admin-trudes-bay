<?php
include 'dbcon.php';

// Check the request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request contains JSON for delete action
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    // Handle delete action
    if (isset($data['id'])) {
        $id = $data['id'];
        $stmt = $conn->prepare("DELETE FROM activities WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo json_encode(["message" => "Activity removed successfully."]);
        } else {
            echo json_encode(["message" => "Failed to remove activity."]);
        }
        $stmt->close();
        exit;
    }

    // Handle add/edit action
    $title = $_POST['title'];
    $description = $_POST['description'];
    $id = $_POST['id'] ?? null;

    if (!empty($_FILES['image']['tmp_name'])) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $imageType = $_FILES['image']['type'];
    } else {
        $imageData = null;
        $imageType = null;
    }

    if ($id) {
        // Update existing activity
        if ($imageData && $imageType) {
            $stmt = $conn->prepare("UPDATE activities SET activity_title = ?, description = ?, image_data = ?, image_type = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $title, $description, $imageData, $imageType, $id);
        } else {
            $stmt = $conn->prepare("UPDATE activities SET activity_title = ?, description = ? WHERE id = ?");
            $stmt->bind_param("ssi", $title, $description, $id);
        }
    } else {
        // Insert new activity
        $stmt = $conn->prepare("INSERT INTO activities (activity_title, description, image_data, image_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $description, $imageData, $imageType);
    }

    if ($stmt->execute()) {
        echo json_encode(["message" => $id ? "Activity updated successfully." : "Activity added successfully."]);
    } else {
        echo json_encode(["message" => "Failed to save activity."]);
    }

    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT id, activity_title, description, image_data, image_type FROM activities";
    $result = $conn->query($sql);

    $activities = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $activities[] = [
                'id' => $row['id'],
                'activity_title' => $row['activity_title'],
                'description' => $row['description'],
                'image_data' => base64_encode($row['image_data']),
                'image_type' => $row['image_type']
            ];

            // Debugging: Check the image data and type
            if ($row['image_data']) {
                // Log the length of the image data for debugging
                error_log("Image ID: " . $row['id'] . " | Type: " . $row['image_type'] . " | Length: " . strlen($row['image_data']));
            } else {
                error_log("Image ID: " . $row['id'] . " has no image data.");
            }
        }
    }

    header('Content-Type: application/json'); // Set header for JSON response
    echo json_encode($activities);
}

$conn->close();
?>
