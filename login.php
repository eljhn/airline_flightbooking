<?php
ob_start();
include 'db_connect.php';
include 'session_manager.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TARA - Login</title>
    <link rel="stylesheet" href="style.css">
    <style>

        body {
            background-image: url('imgandvideo/BG2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .admin-form { display: none; margin-top: 20px; }
        .error-message { color: red; text-align: center; }

        .login-dashboard {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 45vh; 
            margin-top: 55px;
        }
        .login-dashboard form {
            background-color: white;
            padding: 65px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        .login-dashboard form button {
            display: block;
            margin: 30px auto 0 auto; 
            padding: 10px 20px;
            border: none;
            background-color: #ffc107;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.2);
            transition: background-color 0.3s ease;
        }
        .login-dashboard form button:hover {
            background-color: #e0a800;
        }
        .login-dashboard form input[type="email"],
        .login-dashboard form input[type="password"] {
            width: 300px;        
            padding: 10px;
            margin: 10px auto;
            display: block;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        .radio-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="text-loginpage">
    <p class="banner2">TRAVEL ASIA, RESERVED AIRLINES</p>
    <p class="brand2">TARA</p>
</div>

<div class="login-dashboard">
    <!-- Customer Login Form -->
    <form method="POST" id="customerForm">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>

        <div class="radio-group">
            <label>Login as:</label>
            <label><input type="radio" name="user_type" value="customer" checked> Customer</label>
            <label><input type="radio" name="user_type" value="admin"> Admin</label>
        </div>

        <button type="submit" name="login">Login</button>
    </form>

    <!-- Admin Login Form (redirects to admin_login.php) -->
    <form method="POST" action="admin_login.php" id="adminForm" class="admin-form">
        <input type="email" name="email" placeholder="Admin Email" required><br>
        <input type="password" name="password" placeholder="Admin Password" required><br>

        <div class="radio-group">
            <label>Login as:</label>
            <label><input type="radio" name="user_type" value="customer"> Customer</label>
            <label><input type="radio" name="user_type" value="admin" checked> Admin</label>
        </div>

        <button type="submit" name="admin_login">Login</button>

    </form>
</div>

<?php if (!isset($_SESSION['user_id'])): ?>
    <div style="text-align:center; margin-top: 20px;">
        <a href="flight.php">Book here</a> | <a href="register.php">Register here</a>
    </div>
<?php endif; ?>


<script>
    const customerForm = document.getElementById('customerForm');
    const adminForm = document.getElementById('adminForm');
    const allRadios = document.querySelectorAll('input[name="user_type"]');

    allRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'admin') {
                customerForm.style.display = 'none';
                adminForm.style.display = 'block';
            } else {
                adminForm.style.display = 'none';
                customerForm.style.display = 'block';
            }
        });
    });
</script>

<?php
// Customer login processing
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user_type = $_POST['user_type'];

    if ($user_type !== 'customer') {
        echo "<p class='error-message'>Please switch to the Admin form to login as Admin.</p>";
    } else {
        $stmt = $conn->prepare("SELECT id, fullname, password, user_type FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $fullname, $hashed_password, $db_user_type);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                if (strtolower($db_user_type) === 'customer') {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['user_type'] = $db_user_type;
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<p class='error-message'>Incorrect user type selected.</p>";
                }
            } else {
                echo "<p class='error-message'>Invalid password.</p>";
            }
        } else {
            echo "<p class='error-message'>No user found with that email.</p>";
        }

        $stmt->close();
    }
}
?>

<?php 
ob_end_flush();
?>
</body>
</html>
