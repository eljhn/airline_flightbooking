<?php include 'session_manager.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TARA - About</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">


  <style>
  @font-face {
  font-family: 'Kenao';
  src: url('fonts/kenao.woff2') format('woff2');
}


@font-face {
  font-family: 'Gill Sans Display';
  src: url('fonts/gill-sans-display.woff2') format('woff2');
}


    body {
      height: 100%;
      margin: 0;
      padding: 0;
      overflow: hidden;
      font-family: 'Poppins', sans-serif;
      background-image: url('imgandvideo/BG2.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center -133px;
    }


    .content-wrapper {
      width: 100vw;
      height: 100vh;
      overflow: hidden;
    }


    .content-slide {
      display: flex;
      width: 300vw; /* 3 slides */
      height: 100vh;
      transition: transform 0.5s ease-in-out;
    }


    .slide {
      width: 100vw;
      height: 100vh;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
    }


    .content {
      display: flex;
      padding: 60px 80px;
      align-items: center;
      justify-content: space-between;
    }


    .descript {
      max-width: 50%;
    }


    .text-title {
      font-size: 40px;
      font-weight: bold;
      padding-bottom: 20px;
    }


    .text {
      font-size: 22px;
      color: #594100;
      line-height: 1.6;
      text-align: justify;
    }


    .content-video video {
      max-height: 90vh;
      max-width: 100%;
      object-fit: contain;
    }


    .content2 {
      display: flex;
      justify-content: center;
      gap: 40px;
      padding: 60px 80px;
      flex-wrap: wrap;
    }


    .descript2 {
      flex: 1;
      min-width: 300px;
      max-width: 500px;
      margin-top: 20px;
      padding: 30px;
      background: rgba(255, 255, 255, 0.05);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      backdrop-filter: blur(2px);
      -webkit-backdrop-filter: blur(2px);
      border-radius: 10px;
      border: 1px solid rgba(255, 255, 255, 0.18);
    }


    .text-title2 {
      font-size: 30px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #1a2751;
      text-align: center;
    }


    .text3 {
      color: #594100;
      font-size: 20px;
      line-height: 1.6;
      text-align: justify;
    }


    .buttons {
      position: fixed;
      bottom: 50px;
      left: 50px;
      z-index: 20;
      pointer-events: auto;
    }


    button {
      font-size: 18px;
      padding: 10px 20px;
      margin-left: 10px;
      cursor: pointer;
      background: rgba(255, 255, 255, 0.05);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      border-radius: 10px;
      border: 1px solid rgba(255, 255, 255, 0.18);
      transition: 0.2s ease-in-out;
    }


    button:hover {
      transform: scale(1.1);
      color: white;
    }


    .next-button {
      color: rgb(255, 242, 148);
      font-size: 30px;
      background: linear-gradient(to right, #FFD63A, #FFA55D);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      border-radius: 50%;
      border: 1px solid rgba(255, 255, 255, 0.2);
      width: 80px;
      height: 80px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-left: 1733%;
      margin-top: 110px;
    }


    .slide:last-child {
      flex-direction: row;
      justify-content: center;
      align-items: center;
    }


    .final-text {
  font-family: 'Patrick Hand', 'cursive';
  font-size: 65px;
  font-weight: bold;
  color: transparent;
  -webkit-text-stroke: 2px #D8A909;
  -webkit-text-stroke: 2px #D8A909;
  text-align: center;
  padding: 30px;
  letter-spacing: 4px;
  line-height: 1.3;
  margin-right: -300px;
  margin-top: -150px; /* move it up */




}


.final-section {
  flex: 1.3;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-end; /* push content to the right */
  padding: 0 80px;
  text-align: right;
}


.final-sub{
  font-family: 'Gill Sans Display', sans-serif;
  font-size: 50px;
      font-weight: 600;
      color:rgb(197, 149, 38);
      margin-bottom: 15px;
  margin-right: -230px; /* align flush with the right side */
}


    .book-now-btn {
      font-family: 'Montserrat', sans-serif;
      background-color: #ffd700;
      color:rgb(246, 253, 211);
      font-size: 60px;
      font-weight: bold;
      padding: 14px 40px;
      border: none;
      border-radius: 50px;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      transition: transform 0.2s ease-in-out;
      margin-right: -300px;
      margin-bottom: -100px; /* move it up */
        }


        .book-now-btn:hover {
      animation: wiggle 0.5s ease-in-out;
    }


    @keyframes wiggle {
      0%, 100% { transform: rotate(0deg); }
      25% { transform: rotate(3deg); }
      50% { transform: rotate(-3deg); }
      75% { transform: rotate(3deg); }
    }


    .content-image {
      flex: 1;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  padding-right: 0; /* remove any padding */
}
    .attendant-img {
   height: 500px;
    width: 400px;
  object-fit: contain;
  margin: 0; /* remove leftover margins */
    }
   
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="content-wrapper">
  <div class="content-slide" id="slider">
    <div class="slide">
      <div class="content">
        <div class="descript">
          <p class="text-title">A Few Words About Us</p>
          <p class="text">
            T.A.R.A is the world’s first inspirational <br>
            travel search service that focuses on what’s really <br>
            important: your Comfort and your Budget!
          </p>
        </div>
        <div class="content-video">
          <video width="570" autoplay loop muted>
            <source src="imgandvideo/Video.mp4" type="video/mp4" />
          </video>
        </div>
      </div>
    </div>


    <div class="slide">
  <div class="content2">
   
    <!-- VISION -->
    <div class="section-wrapper">
      <p class="text-title2">VISION</p>
      <div class="descript2">
        <p class="text3">
          TARA is committed to providing safe, efficient, and affordable air travel across Asia. We aim to connect people and cultures with seamless journeys, exceptional service, and a commitment to sustainability. Our goal is to make travel more accessible while ensuring comfort, reliability, and top-tier hospitality.
        </p>
      </div>
    </div>


    <!-- MISSION -->
    <div class="section-wrapper">
      <p class="text-title2">MISSION</p>
      <div class="descript2">
        <p class="text3">
          To be Asia’s most trusted local airline, pioneering innovative and eco-friendly travel solutions while fostering stronger connections between the diverse destinations of the region. We envision a future where flying is not only convenient but also enriching, bringing people closer through exceptional air travel experiences.
        </p>
      </div>
    </div>


  </div>
</div>


    <!-- Slide 3 -->
    <div class="slide">
      <div class="final-section">
      <p class="final-text"><i>“ Your Gateway to Asia’s Wonders. ”</i></p>
        <p class="final-sub">Book</p>
        <button class="book-now-btn"id="bookNowButton" onclick="handleBookNow()"><b>NOW!</b></button>
      </div>
      <div class="content-image">
        <img src="imgandvideo/model.png" alt="Flight Attendant" class="attendant-img" />
      </div>
    </div>
  </div>
</div>


<div class="buttons">
  <button class="next-button" onclick="slideRight()"><b>&gt;</b></button>
</div>


<script>
  let currentIndex = 0;


  function slideRight() {
    currentIndex = (currentIndex + 1) % 3;
    updateSlide();
    document.getElementById("bookNowButton").style.display = (currentIndex === 0) ? "block" : "none";
  }


  function updateSlide() {
    document.getElementById("slider").style.transform = `translateX(-${currentIndex * 100}vw)`;
    document.body.style.backgroundImage = backgrounds[currentIndex];
  }


  function handleBookNow() {
    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    window.location.href = isLoggedIn ? 'flight.php' : 'login.php';
  }
</script>
</body>
</html>
