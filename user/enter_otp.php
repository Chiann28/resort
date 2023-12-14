<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">


  <title>Hotel Management and Reservation System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <script>
        // Check if the URL contains the 'registration' parameter with the value 'success'
        const urlParams = new URLSearchParams(window.location.search);
        const registrationSuccess = urlParams.get('registration') === 'success';

        // If registration was successful, show an alert
        if (registrationSuccess) {
            alert('We have sent an email verification in your email!'); // You can customize this message
        }
    </script>


</head>

<body>
  
  <?php
        require 'registration_navbar.php';
    ?>

  <main id="main" style="padding-top:100px;">
  
  <div class="login-container">
    <h2>Enter OTP</h2>
    <form action="reset_password.php" method="post">
        <label for="otp">Enter the OTP sent to your email:</label>
        <input type="text" id="otp" name="otp" required>

        <label for="new_password">Enter your new password:</label>
        <input type="password" id="new_password" name="new_password" required>
    

        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
        <button type="submit">Verify OTP</button>
    </form>
 </div>




  </main>
  
  <?php
        require '../footer.php';
    ?>

  

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>