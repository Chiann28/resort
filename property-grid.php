<?php

  session_start();

  require_once 'config.php';

  // Create a database connection
  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Query all rooms from the database
  $sql = "SELECT * FROM rooms WHERE status = 1";

  $result = $conn->query($sql);

  // $conn->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kamantigue Beach and Diving Resort</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: EstateAgency
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/real-estate-agency-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <?php
    require 'navbar.php';
  ?>

  <main id="main">

    <!-- ======= Intro Single ======= -->
    <section class="intro-single">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-8">
            <div class="title-single-box">
              <h1 class="title-single">Our Amazing Rooms</h1>
              <span class="color-text-a">Grid Rooms</span>
            </div>
          </div>
          <div class="col-md-12 col-lg-4">
            <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="index.html">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Properties Grid
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section><!-- End Intro Single-->

    <!-- ======= Property Grid ======= -->
    
    <section class="property-grid grid">
      <div class="container">
        <div class="row">


          <?php

          if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
              
              echo '<div class="col-md-4">';
              echo '<div class="card-box-a card-shadow">';
              echo '<div class="img-box-a" onclick="window.location=\'user/user_login.html\';" style="cursor: pointer;">'; // Update the onclick event
              echo '<img src="assets/img/rooms/'.$row['picture_link'].'" alt="" class="img-a img-fluid">';
              echo '</div>';
               

              echo '<div class="card-overlay">';
              echo '<div class="card-overlay-a-content">';
              echo '<div class="card-header-a">';
              echo '<h2 class="card-title-a">';
              echo '<a href="user/user_login.html">'. $row['room_number'] .'</a>';
              echo '</h2>';
              echo '</div>';

                echo '<div class="card-body-a">';
                echo '<div class="price-box d-flex">';
                echo '<span class="price-a">Price | '.$row['price'].'</span>';
                echo '</div>';
                echo '</div>';

                  // Add a button with a link to a new variable
                  echo        '<div class="card text-center">';
                  echo         '<a href="rooms/'.$row['site_link'].'" class="btn btn-primary">Details</a>';
                  echo        '</div>';

              echo '</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
             

            };
          };
          
          ?>
        </div>



        <!-- <div class="row">
          <div class="col-sm-12">
            <nav class="pagination-a">
              <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">
                    <span class="bi bi-chevron-left"></span>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item active">
                  <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item next">
                  <a class="page-link" href="#">
                    <span class="bi bi-chevron-right"></span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div> -->
      </div>
    </section>
    
    <!-- End Property Grid Single-->

  </main><!-- End #main -->

  <?php
    require 'footer.php';
  ?>


  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>