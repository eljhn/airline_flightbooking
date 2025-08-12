<?php
include 'db_connect.php';
include 'session_manager.php';

// nothing to touch here

if (isset($_POST['admin_login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, fullname, password, user_type FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $fullname, $hashed_password, $user_type);
        $stmt->fetch();

        if (password_verify($password, $hashed_password) && strtolower($user_type) === 'admin') {
            $_SESSION['user_id'] = $id;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['user_type'] = $user_type;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid credentials or not an admin'); window.location.href = 'login.php';</script>";
        }
    } else {
        echo "<script>alert('Email not found'); window.location.href = 'login.php';</script>";
    }

    $stmt->close();
}
?>
