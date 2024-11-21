<?php
include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Add Reservation
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $date = $_POST['date'];
    $event_quantity = $_POST['tentquantity']; // Changed variable name to match the new schema
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $guests = $_POST['guests'];

    $sql = "INSERT INTO eventres (Name, Contact_Number, Email, Address, Note, Date, Event_quantity, Check_in, Check_out, Number_of_Guests) 
            VALUES ('$name', '$contact', '$email', '$address', '$note', '$date', '$event_quantity', '$checkin', '$checkout', '$guests')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Reservation added successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch all reservations from the database
    $sql = "SELECT * FROM eventres"; // Fetching all records
    $result = $conn->query($sql);
    $eventres = []; // Changed variable name for clarity

    while ($row = $result->fetch_assoc()) {
        $eventres[] = $row;
    }
    echo json_encode($eventres);
}

// Handle Edit Reservation
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $id = $_PUT['id'];
    $name = $_PUT['name'];
    $contact = $_PUT['contact'];
    $email = $_PUT['email'];
    $address = $_PUT['address'];
    $note = $_PUT['note'];
    $date = $_PUT['date'];
    $event_quantity = $_PUT['tentquantity']; // Updated to new variable name
    $checkin = $_PUT['checkin']; // Ensure this matches the expected input
    $checkout = $_PUT['checkout']; // Ensure this matches the expected input
    $guests = $_PUT['guests'];

    $sql = "UPDATE eventres SET Name='$name', Contact_Number='$contact', Email='$email', Address='$address', Note='$note', Date='$date', Event_quantity='$event_quantity',
    Check_in='$checkin', Check_out='$checkout', Number_of_Guests='$guests' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Reservation updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
}

// Handle Remove Reservation
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'];

    $sql = "DELETE FROM eventres WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Reservation removed successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
}

$conn->close();
?>
