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

  <style>

  </style>

  <script>
 
  function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
    } else {
      passwordInput.type = "password";
    }
  }


    function validatePassword() {
      var password = document.getElementById("password").value;
      var confirmPassword = document.getElementById("confirm-password").value;
      var passwordError = document.getElementById("password-error");

      // Check if the password is at least 8 characters long
      if (password.length < 8) {
        passwordError.textContent = "Password must be at least 8 characters long";
        return false;
      }

      // Check if the password and confirm password match
      if (password !== confirmPassword) {
        passwordError.textContent = "Passwords do not match";
        return false;
      }

      // Clear any previous error messages
      passwordError.textContent = "";

    // Check if the password contains at least one uppercase letter
    if (!/[A-Z]/.test(password)) {
        passwordError.textContent = "Password must contain at least one uppercase letter";
        return false;
    }

    // Check if the password contains at least one special character
    if (!/[^A-Za-z0-9]/.test(password)) {
        passwordError.textContent = "Password must contain at least one special character";
        return false;
    }

    // Clear any previous error messages
    passwordError.textContent = "";

    var email = document.getElementById("email").value;
    var emailError = document.getElementById("email-error");

    // List of recognized domains
    var recognizedDomains = ["gmail.com", "outlook.com", "yahoo.com"]; // Add more domains as needed

    // Check if the email ends with one of the recognized domains
    var isValidDomain = recognizedDomains.some(function (domain) {
        return email.toLowerCase().endsWith("@" + domain);
    });

    if (!isValidDomain) {
        emailError.textContent = "Email must have one of the recognized domains: " + recognizedDomains.join(", ");
        return false;
    }

    // Clear any previous error messages
    emailError.textContent = "";

    return true;
}


  
</script>
</head>



<body style="margin-top: 200px;">
<?php
  require 'registration_navbar.php'
?>




  <main id="main">

  

    <div class="login-container">

      <h2>User Registration</h2>

      <form action="user_registration.php" method="post" onsubmit="return validatePassword();">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
          <i id="eye-icon" class="bi bi-eye eye-icon" onclick="togglePasswordVisibility()" style="margin-left:335px; cursor: pointer; margin-top: -43px;"></i>
          <br>
       <span id="password-error" style="color: red;"></span>
       <br>
       <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
        <i id="eye-icon" class="bi bi-eye eye-icon" onclick="togglePasswordVisibility()" style="margin-left:335px; cursor: pointer; margin-top: -43px;"></i>
        <br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required>
    <span id="email-error" style="color: red;"></span>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <button type="submit">Register</button>
</form>


  </div>









  </main>





  



  <div id="preloader"></div>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>





  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

  <script src="../assets/vendor/php-email-form/validate.js"></script>



  <!-- Template Main JS File -->

  <script src="../assets/js/main.js"></script>


<?php
require 'user_footer.php'
?>
</body>



</html>