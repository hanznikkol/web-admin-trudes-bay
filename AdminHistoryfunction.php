<?php
require 'dbcon.php';
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check if the request is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $year = $_GET['year'] ?? '';
    $month = $_GET['month'] ?? '';

    // If no cottage is selected, fetch all reservations
    $stmt = $conn->prepare("SELECT *, GROUP_CONCAT(CASE WHEN rt.reservationType = 'Tent' THEN CONCAT(rt.value, ' Tents') ELSE rt.value END SEPARATOR ', ') AS concatenated_values FROM reservations r INNER JOIN reservation_types rt ON rt.reservationID = r.id WHERE YEAR(check_in_date) = ? AND MONTH(check_in_date) = ? AND r.status = 'Completed' GROUP BY r.id;");
    $stmt->bind_param("ss", $year, $month);
    $stmt->execute();
    $result = $stmt->get_result();
 
    // Check if the query was successful
    if (!$result) {
        echo json_encode(["error" => "Query failed: " . $conn->error]);
        exit;
    }

    // Check if any records were found
    if ($result->num_rows > 0) {
        $res = [];

        while ($row = $result->fetch_assoc()) {
            // Check if 'Cottage 1' exists in the concatenated_values column
            $res[] = $row;
        }


        // Output the result as JSON
        echo json_encode($res);
    } else {
        echo json_encode(["error" => "No reservations found"]);
    }
}

// Handle Edit Reservation

?>