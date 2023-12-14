<?php
    session_start();
    require_once 'config.php';

        $_SESSION['updatedPrice'] = 0;
        $_SESSION['promo_percentage'] = '';
?>
<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="gcash_css/"
  data-template="vertical-menu-template-free"
  >
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Globe Gcash</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="gcash_css/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="gcash_css/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="gcash_css/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="gcash_css/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="gcash_css/css/demo.css" />
    <link rel="stylesheet" href="gcash_css/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="gcash_css/vendor/libs/apex-charts/apex-charts.css" />
    <script src="gcash_css/vendor/js/helpers.js"></script>
    <script src="gcash_css/js/config.js"></script>
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  </head>

<style>
  body, html {
    height: 100%;
    margin: 0;
    font-family: Arial, sans-serif;
  }

  .colored-background {
    position: relative;
    height: 100%;
    width: 100%;
    background: linear-gradient(to bottom, #007BFF 25%, #f0f0f0  25%);
  }
          .btn-primary {
          display: flex;
          align-items: center;
          justify-content: center;
          background-color: #007BFF; /* Change the background color to match your desired color */
          color: white;
          height: 5vh;
          width: 70%;
          text-decoration: none;
          padding: 10px; /* Adjust padding as needed */
          border: none;
          border-radius: 4vh; /* Optional: Add border-radius for rounded corners */
          cursor: pointer;
          }
          .btn-primary img {
          margin-right: 10px; /* Adjust margin to control the space between the image and text */
          }


    .content-box {
      position: absolute;
      top: 50%; /* Position at the middle of the container */
      left: 50%; /* Position at the center horizontally */
      transform: translate(-50%, -50%); /* Adjust to center the box */
      background-color: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.4); /* Add shadow */
      border-radius: 0.5vh; /* Border radius */
      padding: 20px; /* Adjust padding as needed */
      height:35vh;
      width:55vh;
      margin-top:-20vh;
    }

    .content-boxend {
      position: absolute;
      top: 50%; /* Position at the middle of the container */
      left: 50%; /* Position at the center horizontally */
      transform: translate(-50%, -50%); /* Adjust to center the box */
      background-color: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.4); /* Add shadow */
      border-radius: 0.5vh; /* Border radius */
      padding: 20px; /* Adjust padding as needed */
      height:60;
      width:55vh;
      margin-top:-15vh;
    }

    .input-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 2.5vh; /* Adjust the margin-top as needed */
    }
    .input-box {
      width: 2em;
      border: none;
      border-bottom: 2px solid black;
      margin: 0 0.2em;
      text-align: center;
      font-weight: bold;
      font-size:3vh;
    }  

    .input-container2 {
      display: flex;
      border: none;
      border-bottom: 1px solid gray;
      margin-top: 3vh; /* Adjust the margin-top as needed */
    }

    .input-prefix {
      font-weight: bold;
      padding-right: 10px;
    }

    .input-box2 {
      border: none;
      width: 100%;
      outline: none;
    }

    .circle-input-container {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .circle {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      border: 2px solid black;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      font-size: 1.2em;
    }

    .circle input {
      border: none;
      outline: none;
      width: 100%;
      height: 100%;
      text-align: center;
      font-size: 1.2em;
      border-radius: 50%;
    }
</style>
  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container colored-background" >
        <div class="content-box" id="step3" style="display:block;">
           <div style="padding-left:4vh; padding-right:4vh; padding-top:2vh;">
            <p style="font-size:2vh; font-weight:bold; color:black;">Your Payment Has Been Successfully Submitted.</p>
            <p style="font-size:1.5vh; font-weight:normal; color:gray;">Your reservation request is subject to review by Kamantigue Resort. Please remember to check your "My Reservations" for any updates regarding your request. We appreciate your cooperation!</p>
            <p style="font-size:1.5vh; font-weight:regular; color:gray;">We`re looking forward to serve you here, Thank you!</p>   
            <hr>

          <center><p style="font-size:1.5vh; font-weight:semi-bold; color:red; margin-top:0.5vh;">Closing Payment Section In <span  id="timer">10</span>s.</p></center>
          </div>
        </div>
      </div>
    </div>
    <script>
      // Countdown function
      function startCountdown() {
        let timeLeft = 3; // 300 seconds (5 minutes)

        const countdownElement = document.getElementById('timer');

        const countdownInterval = setInterval(() => {
          if (timeLeft <= 0) {
            clearInterval(countdownInterval);
            countdownElement.textContent = '0';

            window.location.href = 'add_new_reservations.php';
          } else {
            countdownElement.textContent = timeLeft;
            timeLeft--;
          }
        }, 1000); // Update every second
      }

      // Start the countdown when the page loads
      startCountdown();
    </script>

    <script src="gcash_css/vendor/libs/jquery/jquery.js"></script>
    <script src="gcash_css/vendor/libs/popper/popper.js"></script>
    <script src="gcash_css/vendor/js/bootstrap.js"></script>
    <script src="gcash_css/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="gcash_css/vendor/js/menu.js"></script>
    <script src="gcash_css/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="gcash_css/js/main.js"></script>
    <script src="gcash_css/js/dashboards-analytics.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>