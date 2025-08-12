<?php
include 'session_manager.php';
include 'db_connect.php';

// Handle search query for flight_no or user fullname
$search = '';
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = trim($_GET['search']);
    $searchTerm = "%" . $search . "%";

    // Prepare with JOIN to search fullname or flight_no
    $stmt = $conn->prepare("
        SELECT r.*, u.fullname, u.email, u.contact 
        FROM receipt r 
        JOIN users u ON r.user_id = u.id 
        WHERE r.flight_no LIKE ? OR u.fullname LIKE ?
    ");
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
} else {
    // No search - select all bookings with user info
    $stmt = $conn->prepare("
        SELECT r.*, u.fullname, u.email, u.contact 
        FROM receipt r 
        JOIN users u ON r.user_id = u.id
    ");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - View Bookings</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        body {
            background-image: url('imgandvideo/BG2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        select.status-dropdown {
            padding: 5px;
            font-size: 14px;
            border-radius: 4px;
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
    <h1>All Bookings</h1>

    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by Flight Number or Traveler Name" value="<?= htmlspecialchars($search) ?>">
        </form>
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Flight Number</th>
                <th>Traveler</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Departure Date</th>
                <th>Cabin Class</th>
                <th>Passengers</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['flight_no']) ?></td>
                <td><?= htmlspecialchars($row['fullname']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['contact']) ?></td>
                <td><?= htmlspecialchars($row['origin']) ?></td>
                <td><?= htmlspecialchars($row['destination']) ?></td>
                <td><?= htmlspecialchars($row['departure_date']) ?></td>
                <td><?= htmlspecialchars($row['cabin_class']) ?></td>
                <td><?= htmlspecialchars($row['passengers']) ?></td>
                <td>
                    <select class="status-dropdown" data-booking-id="<?= $row['id'] ?>">
                        <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Confirmed" <?= $row['status'] === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                        <option value="Canceled" <?= $row['status'] === 'Canceled' ? 'selected' : '' ?>>Canceled</option>
                    </select>
                </td>
                <td class="actions">
                    <a href="delete_booking.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="text-align:center;">No bookings found.</p>
    <?php endif; ?>

    <div class="btn-container">
        <a href="admin_dashboard.php"><button>← Back to Admin Dashboard</button></a>
    </div>
</div>

<script>
    document.querySelectorAll('.status-dropdown').forEach(dropdown => {
        dropdown.addEventListener('change', function() {
            const bookingId = this.dataset.bookingId;
            const newStatus = this.value;

            fetch('update_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${encodeURIComponent(bookingId)}&status=${encodeURIComponent(newStatus)}`
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'Success') {
                    alert('Status updated to ' + newStatus);
                } else {
                    alert('Failed to update status: ' + data);
                }
            })
            .catch(error => {
                alert('Error updating status');
                console.error(error);
            });
        });
    });
</script>

</body>
</html>
