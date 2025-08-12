<?php
include 'session_manager.php';
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    $allowedStatuses = ['Pending', 'Confirmed', 'Canceled'];
    if (!in_array($status, $allowedStatuses)) {
        http_response_code(400);
        echo "Invalid status";
        exit;
    }

    $stmt = $conn->prepare("UPDATE receipt SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        echo "Success";
    } else {
        http_response_code(500);
        echo "Failed to update status";
    }
    $stmt->close();
} else {
    http_response_code(405);
    echo "Method not allowed";
}
?>
