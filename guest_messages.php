<?php
include 'session_manager.php';
include 'db_connect.php';

// Fetch all guest messages
$stmt = $conn->prepare("SELECT id, first_name, last_name FROM guest");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Guest Messages</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      background: url('imgandvideo/BG2.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #1e293b;
    }

    .container {
      max-width: 900px;
      margin: 60px auto;
      background: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
    }

    h1 {
      text-align: center;
      font-size: 2.5rem;
      margin-bottom: 30px;
      color: #2563eb;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      background-color: #ffffff;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid #e5e7eb;
    }

    th {
      background-color: #f1f5f9;
      font-size: 1.1rem;
      color: #1e40af;
    }

    td {
      font-size: 1rem;
    }

    a {
      color: #2563eb;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    a:hover {
      color: #1e40af;
      text-decoration: underline;
    }

    .delete-link {
      color: #dc2626;
      font-weight: 500;
    }

    .delete-link:hover {
      color: #b91c1c;
    }

    .btn-back {
      display: block;
      width: fit-content;
      margin: 40px auto 0;
      padding: 12px 28px;
      background-color: #3b82f6;
      color: white;
      border: none;
      border-radius: 30px;
      font-size: 1rem;
      cursor: pointer;
      box-shadow: 0 6px 16px rgba(59, 130, 246, 0.3);
      transition: background-color 0.3s ease;
    }

    .btn-back:hover {
      background-color: #1d4ed8;
    }

    @media (max-width: 600px) {
      .container {
        padding: 20px;
      }

      th, td {
        font-size: 0.95rem;
      }

      h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Guest Messages</h1>

    <table>
      <thead>
        <tr>
          <th>Guest Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
            <td>
              <a href="view_guest_message.php?id=<?= $row['id'] ?>">View</a> |
              <a class="delete-link" href="delete_guest_message.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <a href="admin_dashboard.php"><button class="btn-back">Back to Dashboard</button></a>
  </div>

</body>
</html>
