<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['pnr'])) {
    echo "No booking found.";
    exit;
}

$pnr = $_SESSION['pnr'];

$sql = "SELECT * FROM receipt WHERE pnr = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $pnr);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Receipt not found for PNR: " . htmlspecialchars($pnr);
    exit;
}

$data = $result->fetch_assoc();

$user_id = $data['user_id'];
$user_sql = "SELECT fullname FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

$full_name = "Unknown Passenger";
if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
    $full_name = $user['fullname'];
}

// Generate seat (random row 1-25, column A-F)
$seat_row = rand(1, 25);
$seat_column = chr(rand(65, 70));
$seat = "$seat_row $seat_column";

// Generate gate (Gate 1 to 10 or Gate A to Gate F)
$gate_prefix = "Gate ";
$gate_number = rand(1, 10);
$gate = $gate_prefix . ($gate_number <= 10 ? $gate_number : chr(rand(65, 70)));

// Generate terminal (Terminal 1 to 4)
$terminal = "Terminal " . rand(1, 4);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TARA - Flight Ticket & Receipt</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-image: url('imgandvideo/BG2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 20px;
        }

        .print-btn {
            max-width: 800px;
            margin: auto;
            text-align: right;
            margin-bottom: 10px;
        }

        .print-btn button {
            padding: 8px 16px;
            background-color: #FFD43B;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .print-btn button:hover {
            background-color: #e6c722;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }

        .ticket {
            max-width: 800px;
            margin: auto;
            margin-top: 40px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            overflow: hidden;
            border-left: 10px solid #FFD43B;
        }

        .header {
            background: #FFD43B;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
            color: #333;
        }

        .header small {
            display: block;
            color: #555;
            font-size: 14px;
        }

        .ticket-body {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
        }

        .column {
            flex: 1;
            padding: 10px;
            min-width: 300px;
        }

        .info-box {
            margin-bottom: 20px;
        }

        .info-box h3 {
            font-size: 16px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }

        .info-box p {
            margin: 6px 0;
        }

        .info-box span {
            font-weight: bold;
        }

        .footer {
            background: #f7f7f7;
            padding: 15px 20px;
            font-size: 13px;
            color: #666;
            text-align: center;
            border-top: 1px dashed #ccc;
        }

        .pnr {
            font-size: 20px;
            font-weight: bold;
            color: #d63384;
        }

        .flight-info-bottom {
            display: flex;
            justify-content: space-around;
            padding: 15px 20px;
            border-top: 1px solid #ccc;
            background-color: #fafafa;
        }

        .flight-info-bottom div {
            text-align: center;
            font-size: 15px;
        }

        .flight-info-bottom span.label {
            font-weight: bold;
            display: block;
            color: #555;
            margin-bottom: 4px;
        }

    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="ticket">
    <div class="header">
        <h1>e-Ticket Receipt</h1>
        <small>T.A.R.A</small>
        <small>Travel Asia, Reserve Airlines</small>
    </div>

    <div class="ticket-body">
        <div class="column">
            <div class="info-box">
                <h3>Flight Details</h3>
                <p><span>PNR:</span> <span class="pnr"><?= htmlspecialchars($data['pnr']) ?></span></p>
                <p><span>Flight No:</span> <?= htmlspecialchars($data['flight_no']) ?></p>
                <p><span>Origin:</span> <?= htmlspecialchars($data['origin']) ?></p>
                <p><span>Destination:</span> <?= htmlspecialchars($data['destination']) ?></p>
                <p><span>Departure:</span> <?= htmlspecialchars($data['departure_date']) ?> at <?= htmlspecialchars($data['departure_time']) ?></p>
                <p><span>Arrival:</span> <?= htmlspecialchars($data['arrival_date']) ?> at <?= htmlspecialchars($data['arrival_time']) ?></p>

                <?php if ($data['flight_type'] === 'Round Trip'): ?>
                    <p><span>Return Date:</span> <?= htmlspecialchars($data['return_date']) ?></p>
                    <p><span>Return Departure:</span> <?= htmlspecialchars($data['return_departure_time']) ?></p>
                    <p><span>Return Arrival:</span> <?= htmlspecialchars($data['return_arrival_date']) ?> at <?= htmlspecialchars($data['return_arrival_time']) ?></p>
                <?php endif; ?>

                <p><span>Flight Type:</span> <?= htmlspecialchars($data['flight_type']) ?></p>
                <p><span>Cabin Class:</span> <?= htmlspecialchars($data['cabin_class']) ?></p>
            </div>
        </div>

        <div class="column">
            <div class="info-box">
                <h3>Passenger & Payment</h3>
                <p><span>Name of passenger:</span> <?= htmlspecialchars($full_name) ?></p>
                <p><span>Passengers:</span> <?= htmlspecialchars($data['passengers']) ?></p>
                <p><span>Price per Passenger:</span> $<?= number_format($data['price'], 2) ?></p>
                <p><span>Total Amount Paid:</span> $<?= number_format($data['total_amount'], 2) ?></p>
                <p><span>Payment Mode:</span> <?= htmlspecialchars($data['payment_mode']) ?></p>
                <p><span>Card Number:</span> **** **** **** <?= htmlspecialchars($data['card_number']) ?></p>
                <p><span>Transaction Date:</span> <?= htmlspecialchars($data['created_at']) ?></p>
            </div>
        </div>
    </div>

    <div class="flight-info-bottom">
        <div>
            <span class="label">Flight No.</span>
            <?= htmlspecialchars($data['flight_no']) ?>
        </div>
        <div>
            <span class="label">Seat</span>
            <?= htmlspecialchars($seat) ?>
        </div>
        <div>
            <span class="label">Gate</span>
            <?= htmlspecialchars($gate) ?>
        </div>
        <div>
            <span class="label">Terminal</span>
            <?= htmlspecialchars($terminal) ?>
        </div>
    </div>

    <div class="footer">
        This e-Ticket serves as proof of your flight booking. Please present a valid ID during check-in.
    </div>
</div>

<div class="print-btn">
    <button onclick="window.print()">🖨️ Print Ticket</button>
</div>

</body>
</html>
