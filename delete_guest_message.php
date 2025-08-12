<?php
include 'session_manager.php';
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM guest WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the guest messages list
        header("Location: guest_messages.php?deleted=success");
        exit();
    } else {
        echo "Error deleting message.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>
