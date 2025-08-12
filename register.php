<?php
include 'db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TARA - Register</title>
  <link rel="stylesheet" href="style.css">
  <style>

    body {
            background-image: url('imgandvideo/BG2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

.container {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.register-form input,
.register-form select {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  box-sizing: border-box;
  font-size: 14px;
}
.register-form button {
  display: block;
  margin: 20px auto 0 auto; 
  padding: 10px 20px;
  border: none;
  background-color: #ffc107;
  border-radius: 8px;
  -size: 16px;
  cursor: pointer;
  box-shadow: 2px 2px 8px rgba(0,0,0,0.2);
  transition: background-color 0.3s ease;
}
.register-form button:hover {
  background-color: #e6c200;
}
.register-title {
  text-align: center;
  color: #FFD700;
  font-size: 32px;
}
.links {
  text-align: center;
  margin-top: 20px;
  font-size: 14px;
}
h1{
  text-align: center;
  margin-bottom:20px;
}

  </style>
</head>
<body>
    <?php
    include 'session_manager.php';
    include 'navbar.php';
    ?>
   <!-- Can be designed. -->
  <div class="container">
    <h1>REGISTER</h1>

    <form method="POST" action="" class="register-form">
      <input type="text" name="fullname" placeholder="Full Name" required><br>
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <input type="number" name="age" placeholder="Age" required><br>

      <select name="sex" required>
        <option value="" disabled selected>Select Sex</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select><br>
      <input type="text" name="city" placeholder="City" required><br>
      <input type="text" name="country" placeholder="Country" required><br>
      <input type="text" name="contact" placeholder="Contact Number" required><br>
      <input type="text" name="facebook" placeholder="Facebook Account (Optional)"><br>

      <div class="register-type">
      <label for="user_type">Register as:</label>
      <select name="user_type" required>
      <option value="customer">Customer</option>
      <option value="admin">Admin</option>
      </select>
      </div>

      <button name="register">Register</button>
    </form>

    <div class="links">
    <p>Already have an account? <a href="login.php" style="text-decoration: underline;">Login here</a></p>
    <p>Ready to book? <a href="flight.php" style="text-decoration: underline;">Book here</a></p>

    </div>

    <?php
    if (isset($_POST['register'])) {
        // Collect form data
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $contact = $_POST['contact'];
        $facebook = $_POST['facebook'];
        $user_type = strtolower(trim($_POST['user_type']));

        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<p class='error'>Email already in use. Please choose another one.</p>";
        } else {
            // Insert new user
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, age, sex, city, country, contact, facebook, user_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssissssss", $fullname, $email, $password_hash, $age, $sex, $city, $country, $contact, $facebook, $user_type);

            if ($stmt->execute()) {
                echo "<p class='success'>Registered successfully!</p>";
                // Redirect to login page after successful registration
                echo "<script>window.location.href = 'login.php';</script>";
            } else {
                echo "<p class='error'>Something went wrong. Please try again.</p>";
            }
        }
    }
    ?>
  </div>
</body>
</html>