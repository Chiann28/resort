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

  <!-- ======= Intro Section ======= -->
  <div class="intro intro-carousel swiper position-relative">

    <div class="swiper-wrapper">

      <div class="swiper-slide carousel-item-a intro-item bg-image" style="background-image: url(../assets/img/home-1.jpg)">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
          <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <!-- <div class="intro-body">
                    <p class="intro-title-top">Doral, Florida
                      <br> 78345
                    </p>
                    <h1 class="intro-title mb-4 ">
                      <span class="color-b">204 </span> Mount
                      <br> Olive Road Two
                    </h1>
                    <p class="intro-subtitle intro-price">
                      <a href="#"><span class="price-a">rent | $ 12.000</span></a>
                    </p>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-slide carousel-item-a intro-item bg-image" style="background-image: url(../assets/img/home-2.jpg)">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
          <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <!-- <div class="intro-body">
                    <p class="intro-title-top">Doral, Florida
                      <br> 78345
                    </p>
                    <h1 class="intro-title mb-4">
                      <span class="color-b">204 </span> Rino
                      <br> Venda Road Five
                    </h1>
                    <p class="intro-subtitle intro-price">
                      <a href="#"><span class="price-a">rent | $ 12.000</span></a>
                    </p>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-slide carousel-item-a intro-item bg-image" style="background-image: url(../assets/img/home-3.jpg)">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
          <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <!-- <div class="intro-body">
                    <p class="intro-title-top">Doral, Florida
                      <br> 78345
                    </p>
                    <h1 class="intro-title mb-4">
                      <span class="color-b">204 </span> Alira
                      <br> Roan Road One
                    </h1>
                    <p class="intro-subtitle intro-price">
                      <a href="#"><span class="price-a">rent | $ 12.000</span></a>
                    </p>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="swiper-pagination"></div>
  </div><!-- End Intro Section -->

  <section class="section-property section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Rooms</h2>
              </div>
              <div class="title-link">
                <a href="user_property_grid.php">All Rooms
                  <span class="bi bi-chevron-right"></span>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div id="property-carousel" class="swiper">
          <div class="swiper-wrapper">

            <?php


            include('config.php');
          
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

            if ($result->num_rows > 0){
              $counter = 0;
              while($row = $result->fetch_assoc()){
                if ($counter < 4) {
                  
                echo  '<div class="carousel-item-b swiper-slide">';
                echo    '<div class="card-box-a card-shadow">';
                echo      '<div class="img-box-a">';
                echo      '<img src="../assets/img/rooms/'.$row['picture_link'].'" alt="" class="img-a img-fluid">';
                echo      '</div>';
                echo      '<div class="card-overlay">';
                echo        '<div class="card-overlay-a-content">';
                echo          '<div class="card-header-a">';
                echo          '<h2 class="card-title-a">';
                echo             $row['room_number'];
                echo            '</h2>';
                echo          '</div>';
                echo        '<div class="card text-center">';
                echo        '</div>';
                echo        '</div>';
                echo    '</div>';
                echo    '</div>';
                echo  '</div>';
                };

              };
            };


            ?>


          </div>
        </div>
        <div class="propery-carousel-pagination carousel-pagination"></div>

      </div>
  </section>
  




  
    <!-- Form to input check-in and check-out dates -->

<div class="form-container">
    <h2>Check for Available Room</h2>
    <form id="roomSearchForm">
    <div class="form-group">
      <label for="check_in_date">Check-in Date:</label>
      <input type="date" id="check_in_date" name="check_in_date" onchange="updateCheckOutMin()" required>
    </div>

    <div class="form-group">
      <label for="check_out_date">Check-out Date:</label>
      <input type="date" id="check_out_date" name="check_out_date" required>
    </div>

        <div class="form-group">
            <button type="button" onclick="submitForm()">Search Available Rooms</button>
        </div>
    </form>
</div>

  

   <!-- The pop-up container -->
  <div id="availableRoomsPopup" class="modal">
      <div class="modal-content" style='border-radius:2vh;'>
          <span class="close" onclick="closeAvailableRoomsPopup()">&times;</span>
          <h2>Available Rooms:</h2>
          <div id="availableRoomsContent">
              <!-- The content of the available rooms will be loaded here using AJAX -->
          </div>
      </div>
  </div>

  <div id="qrSection" class="modal">
    <div class="modal-content-qr">
      <span class="close" onclick="closeQrPopup()">&times;</span>
      <h2>Please send your Downpayment to:</h2>
        <div class="row">
          <div class="col-lg-6">
            <img src="../assets/img/qrcode/qrcode.jpg" alt="QR Code" style="height:600px; margin-left:20%;">
          </div>
          <div class="col-lg-6">
            <h2>After sending your downpayment, please proceed to Profile -> Reservations to input your Reference Number for confirmation.</h2>

            <h2>Or you can input it here:</h2>

              <!-- Add the reference number form -->
              <form action="process_reference.php" method="post">
                    <label for="reference_number">Reference Number:</label>
                    <input type="text" name="reference_number" id="reference_number" required>
                    <input type="submit" value="Submit Reference Number">
                    <!-- Include hidden input fields for room_id, check_in_date, and check_out_date -->
                    <input type="hidden" name="room_id_reserve" value="">
                    <input type="hidden" name="check_in_date_reserve" value="">
                    <input type="hidden" name="check_out_date_reserve" value="">
              </form>


          </div>
        </div>
    </div>
  </div>

  <div id="reservedSucess" class="modal">
    <div class="modal-content-reserve">
      <span class="close" onclick="closeQrPopup()">&times;</span>
      <h2>Successfully reserved, please proceed to Profile -> Reservations to know the status of your reservation.</h2>
    </div>
  </div>

<!-- ======= Services Section ======= -->
<section class="section-services section-t8" style="padding-top: 0px;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="title-wrap d-flex justify-content-between">
          <div class="title-box">
            <h2 class="title-a">Services</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 mx-auto">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Service</th>
              <th>Price</th>
              <th>Add To Reservation</th>
            </tr>
          </thead>
          <tbody>
            <?php
           require_once 'config.php';

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch services from the database
            $sql = "SELECT description, price, services_number FROM services WHERE type = 'Service' ";
            $result = $conn->query($sql);
            $services_room = 0;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['description'] . '</td>';
                    echo '<td>' . $row['price'] . '</td>';
                    echo '<td>';
                    echo '<form action="make_reservation_services.php" method="post">';
                    echo "<input type='hidden' name='services_room' value='" . $services_room . "'>";
                    echo "<input type='hidden' name='services_number' value='" . $row['services_number'] . "'>";
                    echo "<input type='hidden' name='services_description' value='" .  $row['description'] . "'>";
                    echo "<input type='hidden' name='services_price' value='" . $row['price'] . "'>";
                    echo '<button type="submit" class="btn btn-primary">Add</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3">No services available.</td></tr>';
            }

            // Close the database connection
            $conn->close();
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section><!-- End Services Section -->




<?php
    require 'user_navbar.php';
    require 'user_footer.php';

?>
 
<script>

    const urlParams = new URLSearchParams(window.location.search)
    const showQRCode = urlParams.get('showQRCode');
    const room_id = urlParams.get('room_id');
    const check_in_date = urlParams.get('check_in_date');
    const check_out_date = urlParams.get('check_out_date');
    const reserve = urlParams.get('reserved')

    const room_idInput = document.querySelector('input[name="room_id_reserve"]');
    const check_in_dateInput = document.querySelector('input[name="check_in_date_reserve"]');
    const check_out_dateInput = document.querySelector('input[name="check_out_date_reserve"]');

    room_idInput.value = room_id;
    check_in_dateInput.value = check_in_date;
    check_out_dateInput.value = check_out_date;

    if (showQRCode === 'true') {
            const qrCodeSection = document.getElementById('qrSection');
            qrCodeSection.style.display = 'block';
    }

    if(reserve === 'true'){
      const reservedSuccess = document.getElementById('reservedSucess');
      reservedSuccess.style.dispay = 'block' 

    }

    function submitForm() {
        // Get form element by ID
        var form = document.getElementById("roomSearchForm");

        // Check if the form is valid (required fields are filled)
        if (form.checkValidity()) {
            // Call your custom function or perform any other actions
            showAvailableRooms();
        } else {
            // If the form is not valid, you can provide feedback to the user
            alert("Please fill in all required fields.");
        }
    }


      // Function to show the available rooms pop-up
    function showAvailableRooms() {

        var check_in_date = document.getElementById("check_in_date").value;
        var check_out_date = document.getElementById("check_out_date").value;


        // Get the availableRoomsPopup element
        var availableRoomsPopup = document.getElementById("availableRoomsPopup");

        // Show the availableRoomsPopup
        availableRoomsPopup.style.display = "block";

        // Load the available rooms content using AJAX
        var availableRoomsContent = document.getElementById("availableRoomsContent");
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              availableRoomsContent.innerHTML = this.responseText;
            }
        };
        xhttp.open("POST", "available_rooms.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var params = "check_in_date=" + check_in_date + "&check_out_date=" + check_out_date;
        xhttp.send(params);
    }

    // Function to close the available rooms pop-up
    function closeAvailableRoomsPopup() {
        var availableRoomsPopup = document.getElementById("availableRoomsPopup");
        availableRoomsPopup.style.display = "none";
    }

    function closeQrPopup() {
        var qrSection = document.getElementById("qrSection");
        qrSection.style.display = "none";
    }

    function closeReservePopup() {
        var reservesucess = document.getElementById("reservedSucess");
        reservesucess.style.display = "none";
    }

    

</script>

<script>
    // Get the current date in the format "YYYY-MM-DD"
    function getCurrentDate() {
        const today = new Date();
        const year = today.getFullYear();
        let month = today.getMonth() + 1;
        let day = today.getDate();

        // Add leading zero if needed
        month = month < 10 ? `0${month}` : month;
        day = day < 10 ? `0${day}` : day;

        return `${year}-${month}-${day}`;
    }

    // Set the min attribute of the date input to the current date
    document.getElementById('check_in_date').min = getCurrentDate();
    document.getElementById('check_out_date').min = getCurrentDate();

    // Function to update the min attribute of the check-out date based on the check-in date
    function updateCheckOutMin() {
        const checkInDate = document.getElementById('check_in_date').value;
        document.getElementById('check_out_date').min = checkInDate;
    }
</script>


<script>
    // Function to get the next day's date in the format "YYYY-MM-DD"
    function getNextDay(dateString) {
        const currentDate = new Date(dateString);
        currentDate.setDate(currentDate.getDate() + 1);

        const year = currentDate.getFullYear();
        let month = currentDate.getMonth() + 1;
        let day = currentDate.getDate();

        // Add leading zero if needed
        month = month < 10 ? `0${month}` : month;
        day = day < 10 ? `0${day}` : day;

        return `${year}-${month}-${day}`;
    }

    // Function to update the min attribute of the check-out date based on the check-in date
    function updateCheckOutMin() {
        const checkInDate = document.getElementById('check_in_date').value;
        const checkOutDateInput = document.getElementById('check_out_date');

        // Ensure check-out date is always at least one day after check-in date
        checkOutDateInput.min = getNextDay(checkInDate);

        // If the check-out date is the same as the check-in date, show an alert
        if (checkOutDateInput.value === checkInDate) {
            alert('Cannot check in and check out on the same date.');
            // You can also reset the check-out date to the next day
            checkOutDateInput.value = getNextDay(checkInDate);
        }
    }
</script>


  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
</body>
</html>