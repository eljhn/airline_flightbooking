<?php
include 'db_connect.php';
include 'session_manager.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $departure_date = $_POST['departure_date'];
    $flight_type = $_POST['flight_type'];
    $return_date = $_POST['return_date'] ?? null;
    $cabin_class = $_POST['cabin_class'];
    $passengers = $_POST['passengers'];

    $_SESSION['origin'] = $origin;
    $_SESSION['destination'] = $destination;
    $_SESSION['departure_date'] = $departure_date;
    $_SESSION['flight_type'] = $flight_type;
    $_SESSION['return_date'] = $return_date;
    $_SESSION['cabin_class'] = $cabin_class;
    $_SESSION['passengers'] = $passengers;

    $base_price = $prices[$destination] ?? 0;
    $passenger_count = intval($passengers);
    $multiplier = ($cabin_class === 'Business') ? 1.5 : 1.0;
    $price = $base_price * $multiplier;
    $total_price = $price * $passenger_count;

    $tables = [];

    for ($i = 1; $i <= 3; $i++) {
        $flight_no = "FL" . rand(1000, 9999);
        $departure_time = date("H:i", strtotime(rand(6, 18) . ":00"));
        $arrival_time = date("H:i", strtotime(rand(8, 22) . ":00"));
        $arrival_date = date('Y-m-d', strtotime($departure_date . ' + 1 day'));

        $return_departure_time = $return_arrival_time = $return_arrival_date = null;

        if ($flight_type === 'Round Trip' && !empty($return_date)) {
            $return_departure_time = date("H:i", strtotime(rand(6, 18) . ":00"));
            $return_arrival_time = date("H:i", strtotime(rand(8, 22) . ":00"));
            $return_arrival_date = date('Y-m-d', strtotime($return_date . ' + 1 day'));
        }

        $tables[] = [
            'flight_no' => $flight_no,
            'departure_time' => $departure_time,
            'arrival_time' => $arrival_time,
            'arrival_date' => $arrival_date,
            'return_departure_time' => $return_departure_time,
            'return_arrival_time' => $return_arrival_time,
            'return_arrival_date' => $return_arrival_date
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TARA - Flight Search Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('imgandvideo/BG2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .frm {
            max-width: 1300px;
            margin: 25px ;
            padding: 15px;
            border-radius: 20px;
            backdrop-filter: blur(2px) saturate(180%);
            -webkit-backdrop-filter: blur(2px) saturate(180%);
            background-color: rgba(0, 0, 0, 0.32);
            border: 1px solid rgba(255, 255, 255, 0.125);
        }

        .form {
            background: linear-gradient(to right, rgba(255, 214, 58, 0.7), rgba(255, 165, 93, 0.7));
            padding: 15px;
            border-radius: 20px;
        }

        .headTitle {
            display: flex;
            margin: 15px 70px;
        }

        h2 {
            text-align: left;
            margin: -4px 10px;
            padding-bottom: 10px;
            color: #333;
        }

        h3 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #888;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #ffcc70;
        }

        tbody tr:nth-child(odd) {
            background-color: #fffacd;
        }

        tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 12px 30px;
            font-size: 14px;
            border: none;
            border-radius: 20px;
            background-color: #5CB338;
            color: white;
            cursor: pointer;
            transition: 0.5s;
        }

        button:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>
<div style="display: flex;
    justify-content: center;
    align-items: center;">
<div class="frm">
<div class="form">

    <div class="headTitle">
    <i class="fas fa-plane" style="font-size: 20px; color: #333;"></i>
    <h2>Flights</h2>
    </div>

    <form action="confirmation.php" method="POST">
        <?php foreach ($tables as $index => $data): ?>
            <div style="display: none;"><h3>Flight <?= $index + 1 ?></h3></div>
            <table>
                <thead>
                <tr>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Flight No</th>
                    <th>Cabin Class</th>
                    <th>Passengers</th>
                    <th>Total Fare ($)</th>
                    <th>Buy</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= htmlspecialchars($origin) ?></td>
                    <td><?= htmlspecialchars($destination) ?></td>
                    <td><?= htmlspecialchars($departure_date) . ' ' . $data['departure_time'] ?></td>
                    <td><?= $data['arrival_date'] . ' ' . $data['arrival_time'] ?></td>
                    <td><?= $data['flight_no'] ?></td>
                    <td><?= htmlspecialchars($cabin_class) ?></td>
                    <td><?= htmlspecialchars($passenger_count) ?></td>
                    <td>$<?= number_format($total_price, 2) ?></td>
                    <td><input type="radio" name="selected_option" value="<?= $index ?>" required></td>
                </tr>

                <?php if ($flight_type === 'Round Trip' && !empty($return_date)): ?>
                    <tr>
                        <td><?= htmlspecialchars($destination) ?></td>
                        <td><?= htmlspecialchars($origin) ?></td>
                        <td><?= htmlspecialchars($return_date) . ' ' . $data['return_departure_time'] ?></td>
                        <td><?= $data['return_arrival_date'] . ' ' . $data['return_arrival_time'] ?></td>
                        <td><?= $data['flight_no'] ?>-R</td>
                        <td><?= htmlspecialchars($cabin_class) ?></td>
                        <td><?= htmlspecialchars($passenger_count) ?></td>
                        <td>$<?= number_format($total_price, 2) ?></td>
                        <td></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <input type="hidden" name="flight_no_<?= $index ?>" value="<?= $data['flight_no'] ?>">
            <input type="hidden" name="departure_time_<?= $index ?>" value="<?= $data['departure_time'] ?>">
            <input type="hidden" name="arrival_time_<?= $index ?>" value="<?= $data['arrival_time'] ?>">
            <input type="hidden" name="arrival_date_<?= $index ?>" value="<?= $data['arrival_date'] ?>">
            <input type="hidden" name="total_price_<?= $index ?>" value="<?= $total_price ?>">
            <?php if ($flight_type === 'Round Trip'): ?>
                <input type="hidden" name="return_departure_time_<?= $index ?>" value="<?= $data['return_departure_time'] ?>">
                <input type="hidden" name="return_arrival_time_<?= $index ?>" value="<?= $data['return_arrival_time'] ?>">
                <input type="hidden" name="return_arrival_date_<?= $index ?>" value="<?= $data['return_arrival_date'] ?>">
            <?php endif; ?>
        <?php endforeach; ?>

        <button type="submit">Confirm</button>
    </form>

</div>
</div>
</div>

</body>
</html>
