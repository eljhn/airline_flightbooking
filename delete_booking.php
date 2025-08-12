<?php
include 'session_manager.php';
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM receipt WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: view_bookings.php");
        exit();
    } else {
        echo "Error deleting booking.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
