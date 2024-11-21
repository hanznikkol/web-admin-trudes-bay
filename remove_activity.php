<?php
// Database connection
require 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'];

    $sql = "DELETE FROM activities WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Activity removed successfully.']);
    } else {
        echo json_encode(['message' => 'Error removing activity: ' . $stmt->error]);
    }

    $stmt->close();
}
$conn->close();
?>
