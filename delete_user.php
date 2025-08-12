<?php
include 'session_manager.php';
include 'db_connect.php';

// Check if an ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL query to delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute the deletion query
    if ($stmt->execute()) {
        // Redirect to the user list page after successful deletion
        header("Location: view_users.php");
        exit();
    } else {
        // If there was an error executing the query
        echo "Error deleting the user. Please try again.";
    }

    $stmt->close();
} else {
    // If no ID is passed, show an error message
    echo "Invalid request.";
}

$conn->close();
?>
