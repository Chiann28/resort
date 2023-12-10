<?php
        session_start();
        require_once 'config.php';


$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        $price = '0';
        $price_request = $_SESSION['initialPrice']; 
        $payment_option = $_REQUEST['type'];

        if($payment_option == 'full'){
          $price = $price_request;


                $audit_userid = $_SESSION['user_id'];
                $audit_name = $_SESSION['user_nameaudit'];
                $audit_action = "Guest attempt to access gcash gateway to pay full payment";
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}

        }else{
          $price = $price_request * 0.3;


                $audit_userid = $_SESSION['user_id'];
                $audit_name = $_SESSION['user_nameaudit'];
                $audit_action = "Guest attempt to access gcash gateway to pay down payment";
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}
        }

          if(isset($_SESSION['promo_percentage']) && $_SESSION['promo_percentage'] != '' && $payment_option != 'half')
          {
                  $discount_percentage = $_SESSION['promo_percentage'];
                  $price = $price - ($price * $discount_percentage);
          }
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

         <div style="padding-left:4vh; padding-right:4vh; padding-top:4vh; width:100%;">
        <center><img src="https://m.gcash.com/gcash-login-web/img/Gcash-white-new-logo.81ba859.png" width="150" height="35"></img></center>
      </div>
        <!-- Menu -->
      <div class="content-box" id="step1" style="background: linear-gradient(to bottom, #f0f0f0 30%, white  20%);">
        <div style="padding-left:2vh; padding-right:4vh; padding-top:0.5vh;"> 
          <p style="font-size:1.7vh; font-weight:Bold; color:silver;">Merchant <span style="color:gray; margin-left:6vh;">Michaelle Bagon</span></p>
          <p style="font-size:1.7vh; font-weight:Bold; color:silver;">Amount Due <span style="color:#007BFF; margin-left:4vh;">₱ <?php echo number_format($price,2); ?></span></p>
        </div>

        <div style="padding-left:10vh; padding-right:10vh; padding-top:1.5vh;">
          <p style="font-size:1.7vh; font-weight:Bold; color:Black;">Login to pay with GCash</p>

          <div class="input-container2">
            <span class="input-prefix">+63</span>
            <input type="text" class="input-box2" placeholder="Mobile Phone Number" id="phoneNumber" value="" required="Please input your valid phone number.">
          </div>

          <center>
           <button type="submit" class="btn btn-primary" id="nextButton" onclick="nextStep1()" style="margin-top:3.5vh;"><span style="color:white; font-weight:bold;">NEXT</span></button>
          </center>    
        </div>
      </div>

      <div class="content-box" id="step2" style="display:none;">
         <div style="padding-left:4vh; padding-right:4vh; padding-top:2vh;">
          <p style="font-size:2vh; font-weight:bold; color:black;">Login to pay with GCash</p>
          <p style="font-size:1.5vh; font-weight:regular; color:gray;">Enter the 6-digit authentication code sent to your registered mobile number.</p>
      
           <div class="input-container">
            <input type="text" class="input-box" maxlength="1" value="<?php echo rand(0, 9); ?>">
            <input type="text" class="input-box" maxlength="1" value="<?php echo rand(0, 9); ?>">
            <input type="text" class="input-box" maxlength="1" value="<?php echo rand(0, 9); ?>">
            <input type="text" class="input-box" maxlength="1" value="<?php echo rand(0, 9); ?>">
            <input type="text" class="input-box" maxlength="1" value="<?php echo rand(0, 9); ?>">
            <input type="text" class="input-box" maxlength="1" value="<?php echo rand(0, 9); ?>">
          </div>
          <center><p style="font-size:1.5vh; font-weight:semi-bold; color:gray; margin-top:0.5vh;">Didn`t get the code? Resend <span  id="timer">300</span>s.</p></center>
        
          <center>
           <button type="submit" class="btn btn-primary" id="nextButton2" onclick="nextStep2()" style="margin-top:2.5vh;"><span style="color:white; font-weight:bold;">NEXT</span></button>
          </center>             
        </div>
      </div>

      <div class="content-box" id="step3" style="display:none;">
         <div style="padding-left:4vh; padding-right:4vh; padding-top:2vh;">
          <p style="font-size:2vh; font-weight:bold; color:black;">Login to pay with GCash</p>
          <p style="font-size:1.5vh; font-weight:regular; color:gray;">Enter your 4-digit MPIN.</p>

          <br>
          <center>
           <div class="circle-input-container">
          <div class="circle" onclick="clearCircle(this)">
            <input type="text" maxlength="1" id="opt1" oninput="updateCircle(this)">
          </div>
          <div class="circle" onclick="clearCircle(this)">
            <input type="text" maxlength="1" id="opt2" oninput="updateCircle(this)">
          </div>
          <div class="circle" onclick="clearCircle(this)">
            <input type="text" maxlength="1" id="opt3" oninput="updateCircle(this)">
          </div>
          <div class="circle" onclick="clearCircle(this)">
            <input type="text" maxlength="1" id="opt4" oninput="updateCircle(this)">
          </div>
            </div>
          </center>

          <center>
           <button type="submit" class="btn btn-primary" id="nextButton3" onclick="nextStep3()" style="margin-top:4.5vh;"><span style="color:white; font-weight:bold;">NEXT</span></button>
          </center>      
        </div>
      </div>
<style>
    /* Your existing styles go here */

    /* Media query for mobile view */
    @media (max-width: 767px) {
        .content-boxend {
            top: 58%;
        }
    }
</style>


        <div class="content-boxend" id="step4" style="display:none;">
           <div style="padding-left:4vh; padding-right:4vh; padding-top:-2vh;">
            <p style="font-size:1.7vh; font-weight:bold; color:#007BFF; text-align:center;">Michaelle Bagon</p>
           </div>

           <div style="padding: 1vh 2vh;">
              <p style="font-size: 1.25vh; font-weight: bold; color: gray; text-align: left;">PAY WITH</p>
              <div class="row">
                <div class="col-6">
                  <p style="font-size: 1.25vh; font-weight: silver; color: silver;">GCash</p>
                </div>
                <div class="col-6 text-right">
                  <p style="font-size: 1.25vh; font-weight: silver; color: gray;text-align:right;">₱ 250,000</p>
                  <p style="font-size: 1.25vh; font-weight: silver; color: silver; margin-top: -1vh;text-align:right;">Available Balance</p>
                </div>
              </div>
            </div>


           <div style="padding: 1vh 2vh;">
              <p style="font-size: 1.25vh; font-weight: bold; color: gray; text-align: left;">YOU ARE ABOUT TO PAY</p>
              <div class="row">
                <div class="col-6">
                  <p style="font-size: 1.25vh; font-weight: silver; color: silver;">Amount</p>
                </div>
                <div class="col-6 text-right">
                  <p style="font-size: 1.25vh; font-weight: silver; color: gray; text-align:right;">PHP <span style="font-size:3vh;"><?php echo number_format($price,2); ?></span></p>
                </div>
              </div>
            </div>

            <hr style="margin-top:-1vh;">

            <div style="padding: 1vh 2vh;">
              <div class="row">
                <div class="col-6 col-xs-6">                  
                  <p style="font-size: 1.25vh; font-weight: silver; color: Gray;">Total</p>
                </div>
                <div class="col-6 text-right">
                  <p style="font-size: 1.25vh; font-weight: silver; color: BLACK; text-align:right;">PHP <span style="font-size:2.5vh;"><?php echo number_format($price,2); ?></span></p>
                </div>
              </div>
            </div>

            <div style="padding-left: 4vh; padding-right: 4vh;">
              <center><small>Please review to ensure that the details are correct before you proceed.</small></center>
            </div>


           <div style="padding-left:4vh; padding-right:4vh; padding-top:2vh;">
            <form action="payment_success.php" method="post">
              <input type="hidden" name="payment_type" id="payment_type" value="<?php echo $payment_option; ?>"/>
              <center>
               <button type="submit" class="btn btn-primary" id="pay"><span style="color:white; font-weight:bold;">PAY PHP <?php echo number_format($price,2); ?></span></button>
              </center>  
            </form>
           </div>
        </div>
      </div>
    </div>


  <script>
    function updateCircle(input) {
      const circle = input.parentElement;
      if (input.value) {
        circle.style.backgroundColor = 'black';
        circle.style.color = 'white';
        circle.innerText = '•'; // Display a bullet character
      } else {
        circle.style.backgroundColor = 'transparent';
        circle.style.color = 'black';
        circle.innerText = '';
      }
    }

  </script>
  <script>
    function nextStep1() {
      const phoneNumberInput = document.getElementById('phoneNumber');
      const phoneNumber = phoneNumberInput.value;
      // Validate the phone number (starts with 9 and length is 10)
      if (phoneNumber.startsWith('9') && phoneNumber.length === 10) {
        // Valid phone number, proceed to step 2
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'block';
      } else {
        alert('Please enter a valid phone number (starting with 9 and length 10).');
      }
    }
    function nextStep2() {
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step3').style.display = 'block';
    }

    function nextStep3() {

        document.getElementById('step3').style.display = 'none';
        document.getElementById('step4').style.display = 'block';
     
    }
  </script>
    <script>
      // Countdown function
      function startCountdown() {
        let timeLeft = 300; // 300 seconds (5 minutes)

        const countdownElement = document.getElementById('timer');

        const countdownInterval = setInterval(() => {
          if (timeLeft <= 0) {
            clearInterval(countdownInterval);
            countdownElement.textContent = '0';
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