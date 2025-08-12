<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
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
            padding-bottom: 15px;
            backdrop-filter: blur(2px) saturate(180%);
            -webkit-backdrop-filter: blur(2px) saturate(180%);
            background-color: rgba(0, 0, 0, 0.32);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.125);
        }

        .form {
            background: linear-gradient(to right, rgba(255, 214, 58, 0.7), rgba(255, 165, 93, 0.7));
            max-width: 700px;
            margin: auto;
            margin-top: 1px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding-bottom: 30px;
        }

        form {
            font-size: 15px;
            margin-top: 30px;
        }

        .headTitle {
            display: flex;
            margin: 30px 60px;
        }

        h2 {
            text-align: left;
            font-size: 20px;
            margin: -2px 10px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            gap: 40px;
            margin-bottom: 30px;
            margin-left: 60px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            padding: 7px;
            border: 1px solid #ccc;
            border-radius: 7px;
        }

        .form-row input, select {
            border: 1px solid;
            width: 200px;
        }

        #flight_type_section {
            text-align: left;
            margin-bottom: 30px;
            margin-left: 70px;
        }

        #round_trip {
            margin-left: 60px;
        }

        button {
            display: block;
            margin: 20px auto 0;
            padding: 10px 16px;
            font-size: 12px;
            border: none;
            border-radius: 20px;
            background-color: #5CB338;
            color: white;
            cursor: pointer;
            transition: 0.5s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
    <title>Flight Search</title>
</head>
<body>

<?php
    include 'session_manager.php';
    include 'navbar.php';
?>
<div class="frm">
<div class="form">
<div class="headTitle">
<i class="fas fa-plane" style="font-size: 20px; color: #333;"></i>
<h2>TARA - Flights</h2>
</div>

<form action="searchflight.php" method="POST">

    <div id="flight_type_section">
        
        <input type="radio" id="one_way" name="flight_type" value="One-way" checked>
        <label for="one_way">One-way</label>
        <input type="radio" id="round_trip" name="flight_type" value="Round Trip">
        <label for="round_trip">Round Trip</label>
    </div>

    <div class="form-row">

        <div class="form-group">
            <label for="origin">Origin</label>
            <select name="origin" name="origin" id="origin" required>
                <option>Beijing Capital International Airport (PEK) – China</option>
                <option>Tokyo Haneda Airport (HND) – Japan</option>
                <option>Incheon International Airport (ICN)- South Korea</option>
                <option>Ninoy Aquino International Airport (MNL/NAIA) – Philippines</option>
                <option>Hong Kong International Airport (HKG) – Hong Kong</option>
                <option>Suvarnabhumi Airport (BKK) – Thailand</option>
                <option>Noi Bai International Airport (HAN) – Vietnam</option>
                <option>Kuala Lumpur International Airport (KUL) – Malaysia</option>
                <option>Indira Gandhi International Airport (DEL) – India</option>
                <option>Taoyuan International Airport (TPE) – Taiwan</option>
                <option>Jinnah International Airport (KHI) – Pakistan</option>
                <option>Hazrat Shahjalal International Airport (DAC) – Bangladesh</option>
                <option>Bandaranaike International Airport (CMB) – Sri Lanka</option>
                <option>Tribhuvan International Airport (KTM) – Nepal</option>
                <option>Phnom Penh International Airport (PNH) – Cambodia</option>
                <option>Yangon International Airport (RGN) – Myanmar</option>
                <option>Hamad International Airport (DOH) – Qatar</option>
                <option>Imam Khomeini International Airport (IKA) – Iran</option>
                <option>King Khalid International Airport (RUH) – Saudi Arabia</option>
            </select>
        </div>

        <div class="form-group">
            <label for="destination">To</label>
            <select name="destination" id="destination" required>
                <option value="Beijing Capital International Airport (PEK) – China">Beijing Capital International Airport (PEK) – China</option>
                <option value="Tokyo Haneda Airport (HND) – Japan">Tokyo Haneda Airport (HND) – Japan</option>
                <option value="Incheon International Airport (ICN)- South Korea">Incheon International Airport (ICN)- South Korea</option>
                <option value="Ninoy Aquino International Airport (MNL/NAIA) – Philippines">Ninoy Aquino International Airport (MNL/NAIA) – Philippines</option>
                <option value="Hong Kong International Airport (HKG) – Hong Kong">Hong Kong International Airport (HKG) – Hong Kong</option>
                <option value="Suvarnabhumi Airport (BKK) – Thailand">Suvarnabhumi Airport (BKK) – Thailand</option>
                <option value="Noi Bai International Airport (HAN) – Vietnam">Noi Bai International Airport (HAN) – Vietnam</option>
                <option value="Kuala Lumpur International Airport (KUL) – Malaysia">Kuala Lumpur International Airport (KUL) – Malaysia</option>
                <option value="Indira Gandhi International Airport (DEL) – India">Indira Gandhi International Airport (DEL) – India</option>
                <option value="Taoyuan International Airport (TPE) – Taiwan">Taoyuan International Airport (TPE) – Taiwan</option>
                <option value="Jinnah International Airport (KHI) – Pakistan">Jinnah International Airport (KHI) – Pakistan</option>
                <option value="Hazrat Shahjalal International Airport (DAC) – Bangladesh">Hazrat Shahjalal International Airport (DAC) – Bangladesh</option>
                <option value="Bandaranaike International Airport (CMB) – Sri Lanka">Bandaranaike International Airport (CMB) – Sri Lanka</option>
                <option value="Tribhuvan International Airport (KTM) – Nepal">Tribhuvan International Airport (KTM) – Nepal</option>
                <option value="Phnom Penh International Airport (PNH) – Cambodia">Phnom Penh International Airport (PNH) – Cambodia</option>
                <option value="Yangon International Airport (RGN) – Myanmar">Yangon International Airport (RGN) – Myanmar</option>
                <option value="Hamad International Airport (DOH) – Qatar">Hamad International Airport (DOH) – Qatar</option>
                <option value="Imam Khomeini International Airport (IKA) – Iran">Imam Khomeini International Airport (IKA) – Iran</option>
                <option value="King Khalid International Airport (RUH) – Saudi Arabia">King Khalid International Airport (RUH) – Saudi Arabia</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="departure_date">Departure</label>
            <input type="date" name="departure_date" id="departure_date" required>
        </div>
        <div class="form-group">
            <label for="return_date">Return</label>
            <input type="date" name="return_date" id="return_date" disabled>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="cabin_class">Cabin Class</label>
            <select name="cabin_class" id="cabin_class" required>
                <option value="Economy">Economy</option>
                <option value="Business">Business</option>
                <option value="First Class">First Class</option>
            </select>
        </div>
        <div class="form-group">
            <label for="passengers">Passengers</label>
            <input type="number" name="passengers" id="passengers" min="1" required>
        </div>
    </div>

    <button type="submit">Search Flights</button>
</form>
</div>
</div>

<script>
    function toggleReturnDate() {
        const returnDateInput = document.getElementById('return_date');
        if (document.getElementById('round_trip').checked) {
            returnDateInput.disabled = false;
        } else {
            returnDateInput.disabled = true;
            returnDateInput.value = '';
        }
    }

    toggleReturnDate();

    document.querySelectorAll('input[name="flight_type"]').forEach(radio => {
        radio.addEventListener('change', toggleReturnDate);
    });
</script>

</body>
</html>
