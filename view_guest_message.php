<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT first_name, last_name, guest_email, phone_number, message, created_at FROM guest WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $email, $phone, $message, $createdAt);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Guest Message</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #1f2937;
      background: url('imgandvideo/BG2.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
    }

    .message-container {
      max-width: 750px;
      margin: 60px auto;
      background-color: rgba(255, 255, 255, 0.97);
      border-radius: 12px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      border-left: 6px solid #2563eb;
    }

    h2 {
      font-size: 26px;
      color: #1e40af;
      margin-bottom: 20px;
    }

    p {
      font-size: 17px;
      margin: 10px 0;
      line-height: 1.6;
    }

    strong {
      color: #374151;
    }

    hr {
      border: none;
      border-top: 1px solid #d1d5db;
      margin: 25px 0;
    }

    button {
      padding: 12px 30px;
      background-color: #3b82f6;
      color: #fff;
      font-size: 16px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      box-shadow: 0 6px 14px rgba(59, 130, 246, 0.2);
    }

    button:hover {
      background-color: #1d4ed8;
    }

    a {
      text-decoration: none;
    }

    @media (max-width: 600px) {
      .message-container {
        padding: 20px;
      }

      h2 {
        font-size: 22px;
      }

      p {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>

  <div class="message-container">
    <h2>Message from <?= htmlspecialchars($firstName . ' ' . $lastName) ?></h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>
    <p><strong>Date/Time:</strong> <?= date("F j, Y, g:i a", strtotime($createdAt)) ?></p>
    <hr>
    <p><?= nl2br(htmlspecialchars($message)) ?></p>
    <br>
    <a href="guest_messages.php"><button>Back to Guest Messages</button></a>
  </div>

</body>
</html>
