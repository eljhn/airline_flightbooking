<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['payment_data'] = $_POST;
} elseif (isset($_SESSION['payment_data'])) {
    $_POST = $_SESSION['payment_data'];
} else {
    echo "No flight selected.";
    exit;
}

$pnr = strtoupper(substr(md5(uniqid()), 0, 6));

$price = $_POST['price'];
$total_amount = $_POST['total_amount'];
$flight_no = $_POST['flight_no'];
$origin = $_POST['origin'];
$destination = $_POST['destination'];
$departure_date = $_POST['departure_date'];
$departure_time = $_POST['departure_time'];
$arrival_time = $_POST['arrival_time'];
$arrival_date = $_POST['arrival_date'];
$flight_type = $_POST['flight_type'];
$return_date = $_POST['return_date'];
$return_departure_time = $_POST['return_departure_time'];
$return_arrival_date = $_POST['return_arrival_date'];
$return_arrival_time = $_POST['return_arrival_time'];
$cabin_class = $_POST['cabin_class'];
$passengers = $_POST['passengers'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>TARA - Flight Payment</title>
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
            margin-top: 18px;
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
            font-size: 17px;
        }

        h2 {
            text-align: center;
            font-size: 30px;
            margin-top: 60px;
            color: #3A59D1;
        }

        form {
            margin-top: 20px;
            border: 2px solid grey;
            padding-top: 40px;
            padding-bottom: 40px
        }

        label {
            display: block;
            margin-top: 7px;
            margin-left: 40px;
            font-weight: bold;
            margin-bottom: -5px;
        }

        .inputs {
            margin-top: 60px;
            margin-left: 30px;
        }

        .inputs2 {
            margin-top: 40px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 30%;
            padding: 8px;
            margin-top: 6px;
            margin-left: 30px;
            border: 2px solid black;
            border-top: none;
            border-left: none;
            border-right: none;
            border-radius: 3px;
            background-color: transparent;
        }

        .cvv {
            display: inline-flex;
            position: relative; top: -31px;
            margin-left: 90px;
            margin-top: -40px;
        }

        .cvv input {
            width: 190px;
        }

        .payment-mode {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
            margin-right: 140px;
        }

        .payment-mode label {
            font-weight: normal;
        }

        .btn {
            display: block;
            width: 80%;
            padding: 12px;
            font-size: 16px;
            background-color: #5CB338;
            color: white;
            border: none;
            border-radius: 20px;
            margin: 30px auto 0;
            cursor: pointer;
            transition: 0.5s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .details {
            margin-left: 50px;
            margin-top: 40px;
        }

        .details p {
            margin: 6px 0;
        }

        #payment {
            margin-left: 70px;
        }

        hr {
            margin-top: 40px;
            color: grey;
        }

        .cards {
            display: flex;
            margin-left: 80px;
            margin-top: -14px;
        }

        h3 {
            font-size: 16px;
            margin-left: 70px;
        }

        .pay {
            margin-top: 40px;
        }

    </style>
</head>
<body>

<div class="frm">
    <div class="form">

        <div class="details">
            <p><strong>Flight No:</strong> <?= htmlspecialchars($flight_no) ?></p>
            <p><strong>Origin:</strong> <?= htmlspecialchars($origin) ?></p>
            <p><strong>Destination:</strong> <?= htmlspecialchars($destination) ?></p>
            <p><strong>Total Amount:</strong> $<?= number_format($total_amount, 2) ?></p>
        </div>

        <hr>
         <h2> PAY INVOICE </h2>
         
        <form action="save_payment.php" method="POST">

            <h3>ACCEPTED CARDS</h3>
            <div class="cards">
            <img src="imgandvideo/visa.png" alt="card" width="30">
            <img src="imgandvideo/mastercard.jpg" alt="card" width="30">
            <img src="imgandvideo/americanexpress.png" alt="card" width="30">
            <img src="imgandvideo/discover.png" alt="Logo" width="30">
            </div>

            <div class="pay">
            <label for="payment_mode" id="payment">Payment Mode:</label>
            <div class="payment-mode">
                <label><input type="radio" name="payment_mode" value="Credit Card" required> Credit Card</label>
                <label><input type="radio" name="payment_mode" value="Debit Card" required> Debit Card</label>
                <label><input type="radio" name="payment_mode" value="GCash" required> GCash</label>
            </div>

            <div class="inputs">
                <label for="card_number">Card Number:</label>
                <input type="text" name="card_number" id="card_number" required maxlength="16" pattern="\d{16}">

                <div class="inputs2">
                    <label for="expiry">Expiry Date (MM/YY):</label>
                    <input type="text" name="expiry" id="expiry" required pattern="\d{2}/\d{2}">

                    <div class="cvv">
                        <div style="display:flex; flex-direction: column;">
                            <label for="cvv">CVV:</label>
                            <input type="text" name="cvv" id="cvv" required maxlength="3" pattern="\d{3}">
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <!-- Hidden fields -->
            <?php
            $hidden_fields = [
                'flight_no', 'origin', 'destination', 'departure_date', 'departure_time', 'arrival_time', 'arrival_date',
                'flight_type', 'return_date', 'return_departure_time', 'return_arrival_date', 'return_arrival_time',
                'cabin_class', 'passengers', 'price', 'total_amount', 'pnr'
            ];
            foreach ($hidden_fields as $field) {
                echo '<input type="hidden" name="' . $field . '" value="' . htmlspecialchars($$field) . '">' . "\n";
            }
            ?>

            <button type="submit" class="btn">Confirm & Pay</button>
        </form>
    </div>
</div>

</body>
</html>
