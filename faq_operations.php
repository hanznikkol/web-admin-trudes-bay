<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_trudes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if ($data['action'] == 'add') {
    $question = $data['question'];
    $answer = $data['answer'];
    $stmt = $conn->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
    $stmt->bind_param("ss", $question, $answer);
    $stmt->execute();
    echo "FAQ added successfully";
} elseif ($data['action'] == 'edit') {
    $id = $data['id'];
    $question = $data['question'];
    $answer = $data['answer'];
    $stmt = $conn->prepare("UPDATE faqs SET question = ?, answer = ? WHERE id = ?");
    $stmt->bind_param("ssi", $question, $answer, $id);
    $stmt->execute();
    echo "FAQ updated successfully";
} elseif ($data['action'] == 'remove') {
    $id = $data['id'];
    $stmt = $conn->prepare("DELETE FROM faqs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "FAQ removed successfully";
}

$conn->close();
?>
