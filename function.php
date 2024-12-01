<?php
session_start();

// Include your database connection
require 'dbcon.php';

class User {
    public $id;
    public $username;
    public $name;
    public $position;

    public function __construct($id, $username, $name, $position) {
        $this->id = $id;
        $this->username = $username;
        $this->name = $name;
        $this->position = $position;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM admin_accounts WHERE username=? AND status = 'Active'");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Direct comparison of the passwords (no hashing)
        if ($pass === $row['password']) {
            // Set session variables
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];

            $currUser = new User($row['id'], $row['username'], $row['name'], $row['Position']);
           
            // Redirect to a welcome page or dashboard
            echo json_encode($currUser);
            exit();
        } else {
            echo json_encode(['error' => 'Incorrect username or password']);
        }
    } else {
        echo json_encode(['error' => 'Incorrect username or password']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
