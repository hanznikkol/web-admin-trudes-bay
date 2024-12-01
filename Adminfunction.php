<?php
include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Add Admin Account
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $contact = $_POST['contact_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $position = $_POST['position'];

    $sql = "INSERT INTO admin_accounts (username, password, name, contact_number, email, address, status, Position) 
            VALUES ('$username', '$password', '$name', '$contact', '$email', '$address', '$status', '$position')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Staff account added successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch all admin accounts from the database
    $sql = "SELECT * FROM admin_accounts"; // Fetching all records
    $result = $conn->query($sql);
    $adminAccounts = [];

    while ($row = $result->fetch_assoc()) {
        $adminAccounts[] = $row;
    }
    echo json_encode($adminAccounts);
}

// Handle Edit Admin Account
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $id = $_PUT['id'];
    $username = $_PUT['username'];
    $password = $_PUT['password'];
    $name = $_PUT['name'];
    $contact = $_PUT['contact_number'];
    $email = $_PUT['email'];
    $address = $_PUT['address'];
    $status = $_PUT['status'];
    $position = $_PUT['position'];

    $sql = "UPDATE admin_accounts SET username='$username', password='$password', name='$name', contact_number='$contact', email='$email', address='$address', status='$status', position='$position'
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Admin account updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
}

// Handle Remove Admin Account
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'];

    $sql = "DELETE FROM admin_accounts WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Admin account removed successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
}

$conn->close();
?>
