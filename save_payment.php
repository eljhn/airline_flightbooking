<?php
session_start();
require_once 'db_connect.php';

// nothing to touch here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null; // optional: if using login system

    $flight_no = $_POST['flight_no'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $departure_date = $_POST['departure_date'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $arrival_date = $_POST['arrival_date'];
    $flight_type = $_POST['flight_type'];
    $return_date = $_POST['return_date'];
    $return_departure_time = $_POST['return_departure_time'];
    $return_arrival_date = $_POST['return_arrival_date'];
    $return_arrival_time = $_POST['return_arrival_time'];
    $cabin_class = $_POST['cabin_class'];
    $passengers = $_POST['passengers'];
    $price = $_POST['price'];
    $total_amount = $_POST['total_amount'];
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];
    $payment_mode = $_POST['payment_mode'];
    $pnr = $_POST['pnr'];

    // Mask card number (keep only the last 4 digits)
    $card_number = substr($card_number, -4); // Save only last 4 digits

    // Prepare the SQL query to insert payment details into the database
    $sql = "INSERT INTO receipt (
                user_id, flight_no, origin, destination, departure_date, departure_time,
                arrival_time, arrival_date, flight_type, return_date, return_departure_time,
                return_arrival_date, return_arrival_time, cabin_class, passengers, price, total_amount,
                card_number, expiry, cvv, payment_mode, pnr
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Correct number of placeholders, match with the variables
    $stmt->bind_param("issssssssssssssdsdssss",
        $user_id, $flight_no, $origin, $destination, $departure_date, $departure_time,
        $arrival_time, $arrival_date, $flight_type, $return_date, $return_departure_time,
        $return_arrival_date, $return_arrival_time, $cabin_class, $passengers, $price, $total_amount,
        $card_number, $expiry, $cvv, $payment_mode, $pnr
    );

    // Execute the query
    if ($stmt->execute()) {
        // If successful, store the PNR and redirect to the receipt page
        $_SESSION['pnr'] = $pnr; // Save PNR for receipt page
        header("Location: receipt.php");
        exit;
    } else {
        // If an error occurs, display the error message
        echo "Error saving payment: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid access.";
}
?>
