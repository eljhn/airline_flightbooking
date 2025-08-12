<?php
include 'session_manager.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_option'])) {
    $selected = $_POST['selected_option'];

    $flight_no = $_POST['flight_no_' . $selected];
    $departure_time = $_POST['departure_time_' . $selected];
    $arrival_time = $_POST['arrival_time_' . $selected];
    $arrival_date = $_POST['arrival_date_' . $selected];

    $return_departure_time = $_POST['return_departure_time_' . $selected] ?? null;
    $return_departure_date = $_POST['return_departure_date_' . $selected] ?? null;
    $return_arrival_time = $_POST['return_arrival_time_' . $selected] ?? null;
    $return_arrival_date = $_POST['return_arrival_date_' . $selected] ?? null;

    $origin = $_SESSION['origin'];
    $destination = $_SESSION['destination'];
    $departure_date = $_SESSION['departure_date'];
    $flight_type = $_SESSION['flight_type'];
    $return_date = $_SESSION['return_date'] ?? null;
    $cabin_class = $_SESSION['cabin_class'];
    $passengers = $_SESSION['passengers'];

    $prices = [
    "Beijing Capital International Airport (PEK) – China" => 350,
    "Tokyo Haneda Airport (HND) – Japan" => 300,
    "Incheon International Airport (ICN)- South Korea" => 250,
    "Ninoy Aquino International Airport (MNL/NAIA) – Philippines" => 250,
    "Hong Kong International Airport (HKG) – Hong Kong" => 180,
    "Suvarnabhumi Airport (BKK) – Thailand" => 190,
    "Noi Bai International Airport (HAN) – Vietnam" => 200,
    "Kuala Lumpur International Airport (KUL) – Malaysia" => 170,
    "Indira Gandhi International Airport (DEL) – India" => 450,
    "Taoyuan International Airport (TPE) – Taiwan" => 200,
    "Hazrat Shahjalal International Airport (DAC) – Bangladesh" => 500,
    "Bandaranaike International Airport (CMB) – Sri Lanka" => 500,
    "Tribhuvan International Airport (KTM) – Nepal" => 550,
    "Yangon International Airport (RGN) – Myanmar" => 250,
    "Hamad International Airport (DOH) – Qatar" => 450,
    "Imam Khomeini International Airport (IKA) – Iran" => 800,
    "King Khalid International Airport (RUH) – Saudi Arabia" => 800,
    "Jinnah International Airport (KHI) – Pakistan" => 600,
    "Phnom Penh International Airport (PNH) – Cambodia"=> 200
];

    $base_price = $prices[$destination] ?? 0;

    // Cabin class price adjustment
    switch (strtolower($cabin_class)) {
        case 'business':
            $price = $base_price * 1.5;
            break;
        case 'first class':
            $price = $base_price * 2;
            break;
        default: // economy or unspecified
            $price = $base_price;
            break;
    }

    $total_amount = $price * $passengers;
} else {
    echo "Invalid access.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Flight Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('imgandvideo/BG2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .frm {
            max-width: 710px;
            margin: auto;
            margin-top: 25px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
            backdrop-filter: blur(2px) saturate(180%);
            -webkit-backdrop-filter: blur(2px) saturate(180%);
            background-color: rgba(0, 0, 0, 0.32);
            border: 1px solid rgba(255, 255, 255, 0.125);
        }

        .form {
            background: linear-gradient(to right, rgba(255, 214, 58, 0.7), rgba(255, 165, 93, 0.7));
            max-width: 700px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding-bottom: 30px;
        }

        h2 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
            font-size: 15px;
        }

        li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #5CB338;
            color: white;
            border: none;
            border-radius: 20px;
            margin-top: 20px;
            cursor: pointer;
            transition: 0.5s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="frm">
    <div class="form">
        <h2>Flight Confirmation</h2>
        <ul>
            <li><strong>Flight No:</strong> <?= htmlspecialchars($flight_no) ?></li>
            <li><strong>Flight Type:</strong> <?= htmlspecialchars($flight_type) ?></li>
            <li><strong>Origin:</strong> <?= htmlspecialchars($origin) ?></li>
            <li><strong>Destination:</strong> <?= htmlspecialchars($destination) ?></li>
            <li><strong>Departure Date:</strong> <?= htmlspecialchars($departure_date) ?></li>
            <li><strong>Departure Time:</strong> <?= htmlspecialchars($departure_time) ?></li>
            <li><strong>Arrival Date:</strong> <?= htmlspecialchars($arrival_date) ?></li>
            <li><strong>Arrival Time:</strong> <?= htmlspecialchars($arrival_time) ?></li>
            <?php if ($flight_type === 'Round Trip' && $return_date): ?>
                <li><strong>Return Date:</strong> <?= htmlspecialchars($return_date) ?></li>
                <li><strong>Return Departure Date:</strong> <?= htmlspecialchars($return_departure_date) ?></li>
                <li><strong>Return Departure Time:</strong> <?= htmlspecialchars($return_departure_time) ?></li>
                <li><strong>Return Arrival Date:</strong> <?= htmlspecialchars($return_arrival_date) ?></li>
                <li><strong>Return Arrival Time:</strong> <?= htmlspecialchars($return_arrival_time) ?></li>
            <?php endif; ?>
            <li><strong>Cabin Class:</strong> <?= htmlspecialchars($cabin_class) ?></li>
            <li><strong>Passengers:</strong> <?= htmlspecialchars($passengers) ?></li>
            <li><strong>Fare per Passenger ($):</strong> <?= number_format($price, 2) ?> (<?= htmlspecialchars($cabin_class) ?>)</li>
            <li><strong>Total Amount ($):</strong> <?= number_format($total_amount, 2) ?></li>
        </ul>

        <form action="payment.php" method="POST">
            <input type="hidden" name="flight_no" value="<?= $flight_no ?>">
            <input type="hidden" name="origin" value="<?= $origin ?>">
            <input type="hidden" name="destination" value="<?= $destination ?>">
            <input type="hidden" name="departure_date" value="<?= $departure_date ?>">
            <input type="hidden" name="departure_time" value="<?= $departure_time ?>">
            <input type="hidden" name="arrival_date" value="<?= $arrival_date ?>">
            <input type="hidden" name="arrival_time" value="<?= $arrival_time ?>">
            <input type="hidden" name="flight_type" value="<?= $flight_type ?>">
            <input type="hidden" name="return_date" value="<?= $return_date ?>">
            <input type="hidden" name="return_departure_date" value="<?= $return_departure_date ?>">
            <input type="hidden" name="return_departure_time" value="<?= $return_departure_time ?>">
            <input type="hidden" name="return_arrival_date" value="<?= $return_arrival_date ?>">
            <input type="hidden" name="return_arrival_time" value="<?= $return_arrival_time ?>">
            <input type="hidden" name="cabin_class" value="<?= $cabin_class ?>">
            <input type="hidden" name="passengers" value="<?= $passengers ?>">
            <input type="hidden" name="price" value="<?= $price ?>">
            <input type="hidden" name="total_amount" value="<?= $total_amount ?>">

            <button type="submit" class="btn">Proceed to Payment</button>
        </form>
    </div>
</div>

</body>
</html>
