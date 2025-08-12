<?php
    include 'session_manager.php';
include 'db_connect.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_number']);
    $message = trim($_POST['message']);

    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO guest (first_name, last_name, guest_email, phone_number, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $message);
        if ($stmt->execute()) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --yellow: #f2b705;
      --yellow-dark: #e0a500;
      --dark: #222;
      --light: #fff;
      --grey-text: #555;
      --splat: url("paint‑splat.png") no-repeat center/contain;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      color: black;
    }

    body {
      font-family: Arial, sans-serif;
      color: var(--dark);
      line-height: 1.4;
      background-image: url('imgandvideo/BG2.jpg');
      background-size: cover;
      background-repeat: no-repeat;
    }

    .site-nav {
      background: var(--yellow);
      padding: 1rem 2rem;
    }

    .site-nav ul {
      display: flex;
      list-style: none;
    }

    .site-nav li + li {
      margin-left: 2rem;
    }

    .site-nav a {
      text-decoration: none;
      color: var(--dark);
      font-weight: bold;
      padding: 0.3rem 0.6rem;
      border-radius: 4px;
    }

    .site-nav .active a {
      background: var(--yellow-dark);
    }

    .contact-section {
      position: relative;
      display: flex;
      overflow: hidden;
      min-height: 80vh;
    }

    .wave {
      position: absolute;
      bottom: 0;
      left: -50%;
      width: 200%;
      height: 300px;
      border-radius: 50%;
      z-index: 1;
    }

    .info-panel {
      position: relative;
      z-index: 2;
      flex: 1;
      padding: 3rem 2rem;
      background: rgba( 0, 0, 0, 0.15 );
      box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
      backdrop-filter: blur( 0.5px );
      -webkit-backdrop-filter: blur( 0.5px );
      border-radius: 10px;
      border: 1px solid rgba( 255, 255, 255, 0.18 );
    }

    .info-section + .info-section {
      margin-top: 2rem;
    }

    .info-section h3 {
      font-size: 1.2rem;
      margin-bottom: 0.2rem;
    }

    hr.dashed {
      border: none;
      border-top: 2px dashed var(--dark);
      margin-bottom: 0.8rem;
    }

    .contact-item {
  display: flex;
  align-items: center;
  gap: 0.8rem;
}

.contact-item ul {
  list-style: none;
  padding-left: 0;
  margin: 0;
}

.contact-item ul li {
  font-size: 0.95rem;
  line-height: 1.2;
  margin: 0.2rem 0;
}

    .social-buttons {
      display: flex;
      gap: 0.6rem;
    }

    .social-buttons a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      color: var(--light);
      text-decoration: none;
      font-size: 1rem;
    }

    .social-buttons a:hover {
      background: rgba(255, 255, 255, 0.5);
    }

    .form-panel {
      position: relative;
      z-index: 2;
      flex: 2;
      padding: 4rem 3rem;
    }

    .form-panel::before {
      content: "";
      position: absolute;
      top: 1rem;
      right: 1rem;
      width: 60%;
      height: 80%;
      background: var(--splat);
      opacity: 0.1;
      pointer-events: none;
    }

    .form-panel h2 {
      font-size: 2rem;
      margin-bottom: 1rem;
      margin-left: 80px;
    }

    .intro {
      color: var(--grey-text);
      margin-bottom: 2rem;
    }

    form .row {
      display: flex;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .field {
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .field.full {
      width: 100%;
    }

    label {
      font-size: 0.9rem;
      color: var(--grey-text);
      margin-bottom: 0.3rem;
    }

    input,
    textarea {
      padding: 0.6rem 0.8rem;
      border: 2px dashed var(--yellow);
      border-radius: 25px;
      font-size: 1rem;
      outline: none;
    }

    input:focus,
    textarea:focus {
      border-style: solid;
    }

    button {
      margin-top: 1rem;
      padding: 0.8rem 1.6rem;
      background: var(--yellow);
      border: none;
      border-radius: 25px;
      font-size: 1rem;
      cursor: pointer;
      color: var(--dark);
    }

    button:hover {
      background: var(--yellow-dark);
    }

    @media (max-width: 800px) {
      .contact-section {
        flex-direction: column;
      }

      .info-panel {
        clip-path: none;
        border-bottom-left-radius: 50% 20%;
      }
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<section class="contact-section">
  <div class="wave"></div>

  <!-- Info Panel -->
  <div class="info-panel">
    <div class="info-section">
      <h3>Phones</h3>
      <hr class="dashed">
      <div class="contact-item">
        <i class="fas fa-phone"></i>
        <br>
          <li>1‑800‑1213‑249</li></br>
          <li>1‑800‑5426‑374</li>
        </ul>
      </div>
    </div>

    <div class="info-section">
      <h3>Address</h3>
      <hr class="dashed">
      <div class="contact-item">
        <i class="fas fa-map-marker-alt"></i>
        <p>2133 Valhalla Street, San Fidel,<br>CA 96225‑2403 PH</p>
      </div>
    </div>

    <div class="info-section">
      <h3>E‑mail</h3>
      <hr class="dashed">
      <div class="contact-item">
        <i class="fas fa-envelope"></i>
        <p>T.A.R.A@Gmail.com</p>
      </div>
    </div>

    <div class="info-section">
      <h3>Opening Hours</h3>
      <hr class="dashed">
      <div class="contact-item">
        <i class="fas fa-calendar-alt"></i>
        <p>24hrs</p>
      </div>
    </div>

    <div class="info-section">
      <h3>Socials</h3>
      <hr class="dashed">
      <div class="social-buttons">
        <a href="https://www.facebook.com" class="fb"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.twitter.com" class="tw"><i class="fab fa-twitter"></i></a>
        <a href="https://www.youtube.com" class="yt"><i class="fab fa-youtube"></i></a>
        <a href="https://www.pinterest.com" class="pt"><i class="fab fa-pinterest-p"></i></a>
      </div>
    </div>
  </div>

  <!-- Form Panel -->
  <div class="form-panel">
    <h2>Get in Touch</h2>
    <p class="intro">
      You can contact us any way that is convenient for you. We are available 24/7 via fax or email.
      You can also use a quick contact form below or visit our office personally. We would be happy
      to answer your questions.
    </p>
    <form method="POST">
      <div class="row">
        <div class="field">
          <label>First name</label>
          <input type="text" name="first_name" placeholder="First Name" required>
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" placeholder="Email Address" required>
        </div>
      </div>
      <div class="row">
        <div class="field">
          <label>Last name</label>
          <input type="text" name="last_name" placeholder="Last Name" required>
        </div>
        <div class="field">
          <label>Phone</label>
          <input type="text" name="phone_number" placeholder="Phone Number" required>
        </div>
      </div>
      <div class="field full">
        <label>Message</label>
        <textarea name="message" placeholder="Enter your message here..." rows="5" required></textarea>
      </div>
      <button type="submit">Send Message</button>
    </form>
  </div>
</section>

</body>
</html>

  </section>

</body>
</html>
