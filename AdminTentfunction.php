<?php
include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Add Reservation
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $contact_number = $_POST['contact_contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $checkindate = $_POST['checkindate'];
    $checkoutdate = $_POST['checkoutdate'];
    $reservationtype = $_POST['reservationtype']; // Added for Reservation_Type
    $tentquantity = $_POST['tentquantity'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $guests = $_POST['guests'];
    $reference = $_POST['reference'];

    $sql = "INSERT INTO reservations (first_name, last_name, middle_name, contact_number, email, address, note, check_in_date, check_out_date, reservation_type, tent_quantity, check_in, check_out, guests, reference) 
    VALUES ('$firstname', '$lastname', '$middlename', '$contact_number', '$email', '$address', '$note', '$checkindate', '$checkoutdate', '$reservationtype', '$tentquantity', '$checkin', '$checkout', '$guests', '$reference')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Reservation added successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
}


// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Ensure you have a valid database connection here
// e.g., $conn = new mysqli("hostname", "username", "password", "database");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Sanitize the input 'tentquantity'
    if (isset($_GET['tentquantity']) && !empty($_GET['tentquantity'])) {
        $tentquantity = $conn->real_escape_string($_GET['tentquantity']);
        
        // SQL query to fetch reservations for the selected tent_quantity
        $sql = "SELECT * FROM reservations WHERE tent_quantity = '$tentquantity' AND tent_quantity IS NOT NULL";
    } else {
        // SQL query to fetch all reservations that have a non-null 'tent_quantity'
        $sql = "SELECT * FROM reservations WHERE tent_quantity IS NOT NULL";
    }

    // Execute the SQL query
    $result = $conn->query($sql);

    // Check if the query was successful
    if (!$result) {
        echo json_encode(["error" => "Query failed: " . $conn->error]);
        exit;
    }

    // Check if any records were found
    if ($result->num_rows > 0) {
        $cottageres = [];

        while ($row = $result->fetch_assoc()) {
            $cottageres[] = $row;
        }

        // Output the result as JSON
        echo json_encode($cottageres);
    } else {
        echo json_encode(["error" => "No reservations found"]);
    }
}



// Handle Edit Reservation
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $id = $_PUT['id'];
    $firstname = $_PUT['firstname'];
    $lastname = $_PUT['lastname'];
    $middlename = $_PUT['middlename'];
    $contactnumber = $_PUT['contactnumber'];
    $email = $_PUT['email'];
    $address = $_PUT['address'];
    $note = $_PUT['note'];
    $checkindate = $_PUT['checkindate'];
    $checkourdate = $_PUT['checkoutdate'];
    $tentquantity = $_PUT['tentquantity'];
    $checkin = $_PUT['checkin'];
    $checkout = $_PUT['checkout'];
    $guests = $_PUT['guests'];
    $reference = $_PUT['reference'];

    $sql = "UPDATE reservations SET first_name='$firstname', last_name='$lastname', middle_name='$middlename', address='$address', contact_number='$contactnumber', email='$email', note='$note', tent_quantity='$tentquantity', check_in_date='$checkindate', check_out_date='$checkourdate', check_in='$checkin', check_out='$checkout', guests='$guests', reference='$reference' WHERE id='$id'";


    if (!$id || !$firstname || !$lastname) {
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit;
    }    
    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
        exit;
    }    
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

    $sql = "DELETE FROM reservations WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Reservation removed successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
}

$conn->close();
?>