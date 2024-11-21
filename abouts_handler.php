<?php
// Database connection function
function getDatabaseConnection() {
    $servername = "localhost"; // Adjust if your server differs
    $username = "root";
    $password = "";
    $dbname = "db_trudes";

    // Create a new connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        http_response_code(500); // Internal Server Error
        echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
        exit;
    }

    return $conn;
}

// Create connection
$conn = getDatabaseConnection();

// Handle Fetching Data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM about_contacts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id); // Bind the ID parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo json_encode($row); // Return the single entry
        } else {
            echo json_encode(["success" => false, "message" => "No record found"]);
        }
    } else {
        // Fetch all records
        $sql = "SELECT * FROM about_contacts";
        $result = $conn->query($sql);
        $about_contacts = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $about_contacts[] = $row;
            }
            echo json_encode($about_contacts);
        } else {
            echo json_encode(["success" => false, "message" => "Error fetching data: " . $conn->error]);
        }
    }
}

// Handle Adding Data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone']; // Only handle phone

    $sql = "INSERT INTO about_contacts (phone) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phone); // Use prepared statements to prevent SQL injection

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Successfully Added!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }
    $stmt->close(); // Close the statement
}

// Handle Edit Reservation
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents("php://input"), true); // Decode the JSON input
    $id = $input['id'];
    $phone = $input['phone']; // Only handle phone

    $sql = "UPDATE about_contacts SET phone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $phone, $id); // Use prepared statements

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Successfully Updated!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }
    $stmt->close(); // Close the statement
}

// Handle Deleting Data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents("php://input"), true); // Decode the JSON input
    $id = $input['id'];

    $sql = "DELETE FROM about_contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Use prepared statements

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Successfully Removed!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }
    $stmt->close(); // Close the statement
}

// Close the connection
$conn->close();
?>
