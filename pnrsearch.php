<?php   
include 'session_manager.php'; 
include 'db_connect.php';

$booking = null;
$error = "";
$showForm = true;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pnr = trim($_POST['pnr']);

    $stmt = $conn->prepare("
        SELECT r.*, u.fullname 
        FROM receipt r 
        JOIN users u ON r.user_id = u.id 
        WHERE r.pnr = ?
    ");
    $stmt->bind_param("s", $pnr);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
        $showForm = false; 
    } else {
        $error = "PNR not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TARA - PNR Search</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            height: 100%;
            background-image: url('imgandvideo/BG2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .container {
            margin: 100px auto;
            padding: 20px;
            width: 100%;
            max-width: 700px;
            text-align: center;
        }

        h2, h3 {
            margin-bottom: 20px;
            color: #fff;
        }

        .frm {
            max-width: 750px;
            margin: auto;
            margin-top: 25px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding-bottom: 15px;
            backdrop-filter: blur(2px) saturate(180%);
            -webkit-backdrop-filter: blur(2px) saturate(180%);
            background-color: rgba(0, 0, 0, 0.32);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.125);
        }

        .form {
            background: linear-gradient(to right, rgba(255, 214, 58, 0.7), rgba(255, 165, 93, 0.7));
            max-width: 720px;
            margin: auto;
            margin-top: 1px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        input[type="text"] {
            font-family: "SF Pro", sans-serif;
            padding: 0.875rem;
            font-size: 1rem;
            border: 1.5px solid #000;
            border-radius: 0.5rem;
            box-shadow: 2.5px 3px 0 #000;
            outline: none;
            transition: ease 0.25s;
            margin-bottom: 20px;
        }

        input[type="text"]:focus {
            box-shadow: 5.5px 7px 0 black;
        }

        button {
            font-size: 1rem;
            padding: 10px 20px;
            background-color: #FBB034;
            color: black;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 2px 2px 0 #000;
        }

        button:hover {
            background-color: #f79b0b;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .booking-summary table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        .booking-summary th {
            background-color: #FFD43B;
            text-align: left;
            padding: 12px;
            font-size: 1rem;
            color: #333;
        }

        .booking-summary td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            font-size: 0.95rem;
        }

        .booking-summary td:first-child {
            width: 40%;
            font-weight: bold;
            color: #555;
        }

        .print-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="frm">
    <div class="form">
        <div class="container">
            <h2>Search Flight Booking by PNR</h2>

            <?php if ($showForm): ?>
                <form method="POST">
                    <input type="text" placeholder="Enter PNR" name="pnr" required>
                    <button type="submit">Search</button>
                </form>
            <?php endif; ?>

            <?php if ($error): ?>
                <p class="error"><?= $error ?></p>

            <?php elseif ($booking): ?>
                <div class="booking-summary">
                    <h3>Booking Reference: <?= htmlspecialchars($booking['pnr']) ?></h3>

                    <table>
                        <tr><th colspan="2">Passenger Information</th></tr>
                        <tr><td>Name</td><td><?= htmlspecialchars($booking['fullname']) ?></td></tr>
                        <tr><td>Passengers</td><td><?= $booking['passengers'] ?></td></tr>
                    </table>

                    <table>
                        <tr><th colspan="2">Flight Information</th></tr>
                        <tr><td>Flight Number</td><td><?= $booking['flight_no'] ?></td></tr>
                        <tr><td>Origin</td><td><?= $booking['origin'] ?></td></tr>
                        <tr><td>Destination</td><td><?= $booking['destination'] ?></td></tr>
                        <tr><td>Departure Date</td><td><?= $booking['departure_date'] ?></td></tr>
                        <tr><td>Departure Time</td><td><?= $booking['departure_time'] ?></td></tr>
                        <tr><td>Arrival Time</td><td><?= $booking['arrival_time'] ?></td></tr>
                        <tr><td>Return Date</td><td><?= $booking['return_date'] ?: 'N/A' ?></td></tr>
                        <tr><td>Flight Type</td><td><?= ucfirst($booking['flight_type']) ?></td></tr>
                        <tr><td>Cabin Class</td><td><?= $booking['cabin_class'] ?></td></tr>
                    </table>

                    <table>
                        <tr><th colspan="2">Payment Information</th></tr>
                        <tr><td>Fare per Passenger</td><td>$<?= number_format($booking['price'], 2) ?></td></tr>
                        <tr><td>Total Paid</td><td>$<?= number_format($booking['total_amount'], 2) ?></td></tr>
                        <tr><td>Payment Method</td><td><?= $booking['payment_mode'] ?></td></tr>
                        <tr><td>Date Booked</td><td><?= $booking['created_at'] ?></td></tr>
                    </table>

                    <div class="print-btn">
                        <button onclick="window.print()">🖨️ Print Booking</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
