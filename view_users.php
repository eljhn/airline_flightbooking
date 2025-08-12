<?php
include 'session_manager.php';
include 'db_connect.php';

// Handle search query
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = $conn->real_escape_string($_GET['search']);
    $searchTerm = "%" . $search . "%";
    $stmt = $conn->prepare("SELECT id, fullname, email, age, sex, city, country, user_type FROM users WHERE fullname LIKE ? OR email LIKE ?");
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
} else {
    $stmt = $conn->prepare("SELECT id, fullname, email, age, sex, city, country, user_type FROM users");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Users</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('imgandvideo/BG2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 80px auto;
            max-width: 95%;
            background-color: rgba(255, 255, 255, 0.93);
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.25);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .search-bar {
            text-align: right;
            margin-bottom: 15px;
        }

        .search-bar input[type="text"] {
            padding: 8px;
            font-size: 15px;
            width: 250px;
            border: 1px solid #aaa;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 0.95rem;
        }

        th, td {
            padding: 12px 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #ffd43b;
            color: #222;
        }

        tr:nth-child(even) {
            background-color: #fdf7e3;
        }

        tr:hover {
            background-color: #ffeaae;
        }

        .actions a {
            color: #d90000;
            text-decoration: none;
            font-weight: bold;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .btn-container {
            text-align: center;
            margin-top: 25px;
        }

        .btn-container button {
            background-color: #fbb034;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 2px 2px 0 #000;
        }

        .btn-container button:hover {
            background-color: #f79b0b;
        }

        @media screen and (max-width: 768px) {
            table, th, td {
                font-size: 0.85rem;
            }

            .search-bar input[type="text"] {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Registered Users</h1>

    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by Name or Email" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        </form>
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>User Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['age']) ?></td>
                        <td><?= htmlspecialchars($row['sex']) ?></td>
                        <td><?= htmlspecialchars($row['city']) ?></td>
                        <td><?= htmlspecialchars($row['country']) ?></td>
                        <td><?= htmlspecialchars($row['user_type']) ?></td>
                        <td class="actions">
                            <a href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No users found.</p>
    <?php endif; ?>

    <div class="btn-container">
        <a href="admin_dashboard.php"><button>← Back to Admin Dashboard</button></a>
    </div>
</div>

</body>
</html>
