<?php 
ob_start();
include 'session_manager.php'; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Navigation</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');


    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f0f0f0;
    }


    nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 80px;
      background: linear-gradient(to right, #FFD63A, #FFA55D);
      border-bottom-left-radius: 20px;
      border-bottom-right-radius: 20px;
      padding: 0 40px;
    }


    .logo-wrapper {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }


    .logo-wrapper img {
      height: 100%;
      width: auto;
      object-fit: contain;
    }


    ul#navbar {
      list-style: none;
      display: flex;
      align-items: center;
      gap: 60px; /* Reduced the gap between items */
      margin-left: 90px;
      padding: 0;
    }


    ul#navbar li a {
      color: black;
      text-decoration: none;
      padding: 8px 14px;
      border-radius: 10px;
      font-weight: 400;
      transition: 0.3s;
      font-size: 22px;
    }


    ul#navbar li a.active,
    ul#navbar li a:hover {
      background-color: yellow;
      font-weight: 600;
    }


    /* User dropdown */
    .user-menu {
      position: relative;
      cursor: pointer;
    }


    .user-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }


    .user-icon::before {
      content: '';
      position: absolute;
      bottom: 3px;
      right: 3px;
      width: 8px;
      height: 8px;
      background-color: limegreen;
      border-radius: 50%;
      border: 2px solid white;
    }


    .user-icon img {
      width: 90px;
      height: 90px;
    }


    .dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 50px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 10px rgba(0,0,0,0.1);
      padding: 10px 15px;
      z-index: 99;
      text-align: left;
    }


    .dropdown.show {
      display: block;
    }


    .dropdown p {
      margin: 0 0 8px 0;
      font-weight: 600;
    }


    .dropdown a {
      text-decoration: none;
      color: #333;
      background-color: #eee;
      padding: 6px 10px;
      border-radius: 6px;
      display: inline-block;
      font-size: 14px;
    }


    .dropdown a:hover {
      background-color: #ddd;
    }
  </style>
</head>
<body>


<div class="navigation">
  <nav>
    <div class="logo-wrapper">
      <img src="imgandvideo/logo.png" alt="Logo">
    </div>


    <ul id="navbar">
      <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Home</a></li>
      <li><a href="about.php" class="<?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : '' ?>">About</a></li>
      <li><a href="flight.php" class="<?= basename($_SERVER['PHP_SELF']) == 'flight.php' ? 'active' : '' ?>">Flights</a></li>
      <li><a href="pnrsearch.php" class="<?= basename($_SERVER['PHP_SELF']) == 'pnrsearch.php' ? 'active' : '' ?>">PNR Search</a></li> <!-- Added PNR Search -->
      <li><a href="guest_message.php" class="<?= basename($_SERVER['PHP_SELF']) == 'guest_message.php' ? 'active' : '' ?>">Contact</a></li>


      <?php if (isset($_SESSION['user_id'])): ?>
        <li class="user-menu" onclick="toggleDropdown()">
          <div class="user-icon">
            <img src="imgandvideo/icon.png" alt="User">
          </div>
          <div id="dropdownMenu" class="dropdown">
            <p><?= htmlspecialchars($_SESSION['fullname']); ?></p>
            <a href="logout.php">Logout</a>
          </div>
        </li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</div>


<script>
  function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    menu.classList.toggle("show");
  }


  // Optional: close dropdown when clicking outside
  window.addEventListener("click", function(e) {
    const menu = document.getElementById("dropdownMenu");
    const userMenu = document.querySelector(".user-menu");


    if (!userMenu.contains(e.target)) {
      menu.classList.remove("show");
    }
  });
</script>


</body>
</html>
