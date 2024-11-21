<?php
session_start();

// Include your database connection
require 'dbcon.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM admin_accounts WHERE username=?");
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
           
           if($row['Position'] === 'ADMIN') {
            // Redirect to a welcome page or dashboard
            header("Location: AdminIndex.php");
            exit();
           } elseif ($row['Position'] === 'STAFF')  {
            // Redirect to a welcome page or dashboard
            header("Location: StaffIndex.php");
            exit();
           }
     
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that username!";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
