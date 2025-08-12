<?php
  include 'session_manager.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TARA</title>

  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <style>
    body {
      margin: 0;
      padding: 0;
      overflow: hidden;
      font-family: 'Poppins', sans-serif;
      background: #f0f0f0 url('imgandvideo/BG1.jpg') center center / cover no-repeat fixed;
    }

    .banner {
      font-family: Georgia, serif;
      text-transform: uppercase;
      letter-spacing: 6px;
      font-size: 15px;
      color: #1a2751;
      margin: 6px 50px 6px 6px;
    }

    .brand {
      font-family: 'League Spartan', sans-serif;
      font-size: 90px;
      font-weight: 900;
      color: #FFD700;
      letter-spacing: 60px;
      -webkit-text-stroke: 2px #1a2751;
      text-shadow: 1px 1px 0 #1a2751;
      transform: scaleY(1.1);
      margin: 60px 0 0 100px;
    }

    .text1 {
      font-size: 55px;
      color: black;
      font-family: 'League Spartan', sans-serif;
      position: absolute;
      top: 180px;
      left: 130px;
    }

    .next-button {
      color: rgb(255, 242, 148);
      font-size: 30px;
      background: linear-gradient(to right, #FFD63A, #FFA55D);
      border-radius: 50%;
      border: 1px solid rgba(255, 255, 255, 0.2);
      width: 80px;
      height: 80px;
      cursor: pointer;
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      right: 30px;
      bottom: 40px;
      transition: 0.2s ease-in-out;
    }
    
    .next-button:hover {
      transform: scale(1.1);
      color: white;
    }

    .book-now {
      font-size: 60px;
      font-weight: bold;
      color: white;
      padding: 15px 30px;
      border-radius: 10px;
      cursor: pointer;
      filter: drop-shadow(0 0 4px #ffdf00) drop-shadow(0 0 7px #ffa500);
      transition: transform 0.2s ease-in-out;
      font-family: 'League Spartan', sans-serif;
      white-space: nowrap;
      position: absolute;
      top: 400px;
      left: 95px;
      background: none;
      border: none;
    }

    .book-now:hover {
      animation: wiggle 0.5s ease-in-out;
    }

    @keyframes wiggle {
      0%, 100% { transform: rotate(0deg); }
      25% { transform: rotate(3deg); }
      50% { transform: rotate(-3deg); }
      75% { transform: rotate(3deg); }
    }

    .content-wrapper {
      overflow: hidden;
      width: 100vw;
    }

    .content-slide {
      display: flex;
      transition: transform 0.5s ease-in-out;
      width: 500vw;
    }

    .slide {
      width: 100vw;
      flex-shrink: 0;
      position: relative;
    }

    .content {
      display: flex;
      justify-content: center;
      padding: 90px;
    }

    .content-box {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(255, 255, 255, 0.1);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      backdrop-filter: blur(1px);
      -webkit-backdrop-filter: blur(1px);
      border-radius: 20px;
      padding: 35px;
      gap: 40px;
    }

    .description {
      font-family: 'League Spartan', sans-serif;
      font-size: 20px;
      color: rgb(112, 86, 0);
      line-height: 1.9;
    }

    .content-image img {
      height: 350px;
      width: 555px;
      border-radius: 5px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }

    .slide:not(:first-child) .banner,
    .slide:not(:first-child) .brand {
      display: none;
    }

  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="content-wrapper">
  <div class="content-slide" id="slider">
    <!-- Slide 1 -->
    <div class="slide">
      <div class="text2">
        <p class="banner">TRAVEL ASIA, RESERVE AIRLINES</p>
        <p class="brand">TARA</p>
      </div>
      <div class="text1">
        <p>Hi, <span style="color: #FFD700;">Where</span> would <br> you like to go?</p>
      </div>
      <button class="book-now" id="bookNowButton" onclick="handleBookNow()">Book Now!</button>
    </div>

    <!-- Slides 2 to 5 -->
    <?php
      $slides = [
        ["El Nido in Palawan is most famous for its  paradise-like islands and lagoons<br> but a 45-minute ride from its main town takes you to another idyllic destination:<br> Nacpan Beach.
Island hopping escapades in<br> El Nido, including a visit to El Nido Big Lagoon and other top Palawan beaches should<br> not be missed. But after a jam-packed day of visiting <br>coves, white-sand beaches in El Nido, limestone cliffs, and<br> other El Nido Palawan tourist spots, a trip to relaxing <br>Nacpan Beach is highly recommended.", "content2image.png", "El Nido"],
        ["The world’s most perfect volcanic cone and the most active <br>volcano in the Philippines greets you with its majesty. Mayon Volcano <br>is one of the most beautiful places to visit in the Philippines and<br> is a top attraction in any Bicol tour.
Its sheer beauty (the name Mayon<br> comes from the Bicolano word ‘magayon,’ which means<br> beautiful) hides a violent core, with past eruptions<br> that flattened several towns.", "content3image.png", "Mayon Volcano"],
        ["Take a stroll through history lane within the walled city of Intramuros <br>in Manila, one of the top landmarks in the Philippines. The <br>area can be explored via Intramuros tours or a Manila bike<br> tour. The area has become home to several universities and establishments.<br> Here, you can find centuries-old churches, which are  architectural landmarks <br>in the Philippines, and historical places in Manila like the grand Manila Cathedral<br> and San Agustin Church, the oldest church in the <br>Philippines, making the area a great place for a Philippines staycation.", "content4image.png", "Intramuros"],
        ["If you like jumping into or swimming in cool cascading waters,<br> Kawasan Falls in Cebu hits the sweet spot. It is a multi-layered<br> waterfall in the town of Badian and is best known for its<br> turquoise waters. Kawasan Falls is also the endpoint of the popular<br> adventure activity, Kawasan Falls canyoneering. This tour starts in Kanlaob<br> River in the town of Alegria. You’ll make your way to Kawasan, swimming along <br>streams, rappelling through natural rock walls, and finally jumping<br> off mini-waterfalls.", "content5image.png", "Kawasan Falls"],
      ];

      foreach ($slides as [$desc, $img, $alt]) {
        echo "
        <div class='slide'>
          <div class='content'>
            <div class='content-box'>
              <div class='descript'>
                <p class='description'>{$desc}</p>
              </div>
            </div>
            <div class='content-image'>
              <img src='imgandvideo/{$img}' alt='{$alt}' />
            </div>
          </div>
        </div>";
      }
    ?>
  </div>
</div>

<!-- Next Slide Button -->
<button class="next-button" onclick="slideRight()" aria-label="Next Slide"><b>&gt;</b></button>

<script>
  let currentIndex = 0;

  function slideRight() {
    currentIndex = (currentIndex + 1) % 5;
    updateSlide();
  }

  function updateSlide() {
    document.getElementById("slider").style.transform = `translateX(-${currentIndex * 100}vw)`;
    document.getElementById("bookNowButton").style.display = currentIndex === 0 ? "block" : "none";
  }

  function handleBookNow() {
    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    window.location.href = isLoggedIn ? 'flight.php' : 'login.php';
  }
</script>

</body>
</html>
