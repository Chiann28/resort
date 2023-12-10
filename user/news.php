<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kamantigue Beach Resort</title>
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
    /* Form container */
      .form-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
      }

      /* Form elements */
      .form-group {
        margin-bottom: 15px;
      }

      .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
      }

      .form-group input[type="date"],
      .form-group button[type="submit"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
      }

      /* Submit button */
      .form-group button[type="submit"] {
        background-color: #4CAF50;
        color: #ffffff;
        cursor: pointer;
        transition: background-color 0.3s;
      }

      .form-group button[type="submit"]:hover {
        background-color: #45a049;
      }

      /* Error message */
      .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
      }

      /* Success message */
      .success-message {
        color: green;
        font-size: 14px;
        margin-top: 5px;
      }
      .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 9999; /* Ensure the popup overlaps other content */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            overflow-y: auto;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 60%; 
            max-height: 90%; 
            background-color: white;
            overflow-y: auto;
        }

        .modal-content-qr {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 80%; 
            max-height: 90%; 
            background-color: #fff;
            border: 2px solid #00cc00; 
            border-radius: 10px; 
            padding: 20px;
        }

        .modal-content-reserve {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 60%; 
            max-height: 90%; 
            background-color: #fff;
            border: 2px solid #00cc00; 
            border-radius: 10px; 
            padding: 20px;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }
        .title{
            padding-top: 200px;
        }
        .img-news{
           text-align: center;
           margin-top: 100px;
           margin-bottom: ;
        }
  </style>
</head>

<body>

<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "260816322472121");
  chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v18.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>


<div class="img-news">
<img src="../assets/img/news1.png" alt="resort" width="100%">
</div>
<?php
    require 'user_navbar.php';
    require 'user_footer.php';

?>
 


  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
</body>
</html>