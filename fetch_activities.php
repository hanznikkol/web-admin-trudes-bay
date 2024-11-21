<?php
// Database connection
require 'dbcon.php';

// Query to fetch activities
$sql = "SELECT id, activity_title, description, image_data, image_type FROM activities";
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    $activities = [];
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row; // Add each row to the activities array
    }
    // Check if there are any activities
    if (empty($activities)) {
        echo json_encode([]); // Return an empty array if no activities found
    } else {
        echo json_encode($activities); // Return the activities as JSON
    }
} else {
    // Return JSON error response
    echo json_encode(["error" => "Query failed: " . $conn->error]);
}

$conn->close();
?>
