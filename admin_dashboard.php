<?php
// admin_dashboard.php
include 'session_manager.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TARA - Admin Dashboard</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    /* Background and font */
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('imgandvideo/BG2.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #1e293b;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 40px 15px;
    }

    /* Main container */
    .container {
      background: rgba(255, 255, 255, 0.95);
      max-width: 600px;
      width: 100%;
      border-radius: 16px;
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);
      padding: 40px 30px;
      text-align: center;
      transition: box-shadow 0.3s ease;
    }

    .container:hover {
      box-shadow: 0 16px 36px rgba(0, 0, 0, 0.28);
    }

    /* Header */
    h1 {
      margin-bottom: 6px;
      font-size: 2rem;
      color: #2563eb;
      letter-spacing: 2px;
      font-weight: 700;
      text-transform: uppercase;
      user-select: none;
    }

    p.welcome {
      margin-bottom: 40px;
      font-size: 1.2rem;
      color: #475569;
      font-weight: 600;
      letter-spacing: 0.05em;
    }

    /* Sections */
    .admin-sections {
      text-align: left;
    }

    .admin-sections h2 {
      font-size: 1.6rem;
      margin-bottom: 12px;
      color: #1e40af;
      border-left: 5px solid #93c5fd;
      padding-left: 12px;
      font-weight: 700;
    }

    .admin-sections p {
      margin: 0 0 20px 24px;
      font-size: 1rem;
    }

    .admin-sections a {
      color: #2563eb;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.25s ease;
    }

    .admin-sections a:hover {
      color: #1e40af;
      text-decoration: underline;
    }

    /* Logout button */
    .logout-container {
      margin-top: 40px;
      text-align: center;
    }

    .logout-container a {
      background: #ef4444;
      color: white;
      padding: 14px 40px;
      border-radius: 30px;
      font-size: 1.1rem;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 6px 15px rgba(239, 68, 68, 0.4);
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      display: inline-block;
      user-select: none;
    }

    .logout-container a:hover {
      background-color: #b91c1c;
      box-shadow: 0 10px 20px rgba(185, 28, 28, 0.6);
    }

    /* Responsive adjustments */
    @media (max-width: 480px) {
      .container {
        padding: 30px 20px;
      }

      h1 {
        font-size: 2.5rem;
      }

      .admin-sections h2 {
        font-size: 1.3rem;
      }

      .logout-container a {
        width: 100%;
        padding: 14px 0;
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>ADMIN</h1>
    <p class="welcome"><?php echo htmlspecialchars($_SESSION['fullname']); ?></p>

    <div class="admin-sections">
      <h2>Manage Users</h2>
      <p><a href="view_users.php">View All Users</a></p>

      <h2>Manage Bookings</h2>
      <p><a href="view_bookings.php">View All Bookings</a></p>

      <h2>Guest Messages</h2>
      <p><a href="guest_messages.php">View Guest Messages</a></p>
    </div>

    <div class="logout-container">
      <a href="logout.php">Logout</a>
    </div>
  </div>
</body>
</html>
