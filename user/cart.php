!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reservations</title>

    <!-- Favicon -->
    <link rel="icon" href="../assets/img/favicon.png">
    <link rel="apple-touch-icon" href="../assets/img/apple-touch-icon.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="../assets/vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/vendor/swiper/swiper-bundle.min.css">

    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        /* Your custom styles go here */
        .reservation,
        .cart {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            background-color: #f9f9f9;
        }

        .reservation form,
        .cart-item {
            margin-top: 5px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
        }

        .cart-total {
            margin-top: 10px;
            font-weight: bold;
            text-align: right;
        }

        /* Add your additional styles here */
    </style>
    
</head>

<body>
<body>
    <div class="container">
<?php

session_start();

require_once 'config.php';
require 'user_navbar.php';

// Assuming you have the user ID stored in the session
$user_id = $_SESSION['user_id'];
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Query to fetch user reservations
$sql = "SELECT reservations.*, rooms.room_number, rooms.price
        FROM reservations
        INNER JOIN rooms ON reservations.room_id = rooms.room_id
        WHERE user_id = '{$_SESSION['user_id']}'";

// $sql = "SELECT reservations.*, services.description, services.price AS service_price, rooms.room_number, rooms.price AS room_price
//         FROM reservations
//         INNER JOIN services ON reservations.services_number = services.services_number
//         INNER JOIN rooms ON reservations.room_id = rooms.room_id
//         WHERE user_id = '{$_SESSION['user_id']}'";

$result = $conn->query($sql);

$servicesQuery = "SELECT user_id, services_number, services_description, services_price, reservation_id, status, reference_number
                    FROM reservations
                    WHERE user_id = '{$_SESSION['user_id']}'
                    AND services_number IS NOT NULL
                    AND services_description IS NOT NULL
                    AND services_price IS NOT NULL";

$servicesResult = $conn->query($servicesQuery);

// Initialize total price
$totalPrice = 0;
$_SESSION['totalPrice'] = $totalPrice;

$roomPrice = 0; // Initialize the room's price

if($result->num_rows == 0 && $servicesResult->num_rows == 0){
    echo "<div style='
    margin-top: 200px;
    margin-left: 20%;
    text-align: center; /* Center text horizontally */
    background-color: #f9f9f9;
    padding: 10px;
    border: 1px solid #ccc;
    font-weight: bold;
    width: fit-content;
    left: 50%;
    '>No Reservations Found</div>";
}
function getStatusClass($status) {
    switch ($status) {
        case 'Pending':
            return 'pending';
        case 'Approved':
            return 'approved';
        case 'Rejected':
            return 'rejected';
        default:
            return ''; // Default to no class for other statuses
    }
}

if ($result->num_rows > 0) {
    echo "<div class='row justify-content-center' style='margin-top:120px;'>";
    while ($row = $result->fetch_assoc()) {

    // $roomPrice = 0; // Initialize the room's price
    $roomQuery = "SELECT price FROM rooms WHERE room_id = '{$row['room_id']}'";
    $roomResult = $conn->query($roomQuery);

    


    if ($roomResult->num_rows > 0) {
        $roomData = $roomResult->fetch_assoc();
        $roomPrice = $roomData['price'];
    }



    // Use the getStatusClass function to get the appropriate class
    $statusClass = getStatusClass($row['status']);

    // Display reservation details in a cart-style div
    echo "<div class='cart col-lg-3 " . $statusClass . "'>";

    echo "<div class='cart-item'>Reservation ID: " . $row['reservation_id'] . "</div>";
    echo "<div class='cart-item'>Room Number: " . $row['room_number'] . "</div>";
    echo "<div class='cart-item'>Check-in Date: " . $row['check_in_date'] . "</div>";
    echo "<div class='cart-item'>Check-out Date: " . $row['check_out_date'] . "</div>";
    echo "<div class='cart-item'>Adults: " . $row['adults'] . "</div>";
    echo "<div class='cart-item'>Children: " . $row['children'] . "</div>";
    echo "<div class='cart-item'>Status: " . $row['status'] . "</div>";
    echo "<div class='cart-item'>Price: " . $row['price'] . "</div>";

    // echo "<div class='cart-item'>Price: " . $servicesRow['services_number'] . "</div>";

    $reservationPrice = $roomPrice;
    $totalPrice += $reservationPrice;
    
    if ($row['status'] === 'Approved') {
        echo "<div class='cart-item'>Reference Number: " . $row['reference_number'] . "</div>";

        // Calculate the price for this reservation
        // $reservationPrice = $row['price'];
        // $totalPrice += $reservationPrice;
    } else {
        // Provide a form to add/edit reference number
        // echo "<form action='update_reference.php' method='post'>";
        // echo "<input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>";
        // if (!empty($row['reference_number'])) {
        //     echo "Reference Number: <input type='text' name='reference_number' value='" . $row['reference_number'] . "'>";
        // } else {
        //     echo "Reference Number: <input type='text' name='reference_number'>";
        // }
        // echo "<button type='submit' name='submit_reference'>Submit Reference</button>";
        // echo "</form>";
    }

    echo "<form action='delete_reservation.php' method='post'>";
    echo "<input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>";
    echo "<button type='submit' name='delete_reservation' class='btn btn-danger'>Delete</button>";
    echo "</form>";

    echo "</div>"; // Close the cart div
    }
    
    echo "</div>";

    
} else {
    
}

if ($servicesResult->num_rows > 0) {
    echo "<div class='row justify-content-center' style='margin-top:125px;'>";
    while ($servicesRow = $servicesResult->fetch_assoc()) {

        // Display reservation details in a cart-style div
        echo "<div class='cart col-lg-3'>";
        echo "<div class='cart-item'>Reservation ID: " . $servicesRow['reservation_id'] . "</div>";
        echo "<div class='cart-item'>Services Number: " . $servicesRow['services_number'] . "</div>";
        echo "<div class='cart-item'>Description: " . $servicesRow['services_description'] . "</div>";

        // echo "<div class='cart-item'>Status: " . $row['status'] . "</div>";
        echo "<div class='cart-item'>Price: " . $servicesRow['services_price'] . "</div>";
        // echo "<div class='cart-item'>Price: " . $row['price'] . "</div>";

        // echo "<div class='cart-item'>Price: " . $servicesRow['services_number'] . "</div>";

        $reservationPrice = $roomPrice;

        $servicesPrice = $servicesRow['services_price'];
        if ($servicesRow['services_price'] > 0) {
            $reservationPrice += $servicesRow['services_price'];
        }
        $totalPrice += $reservationPrice;
        // $totalPrice += $servicesPrice;
        
        
        if ($servicesRow['status'] === 'Approved') {
            echo "<div class='cart-item'>Reference Number: " . $servicesRow['reference_number'] . "</div>";
            // Calculate the price for this reservation
            // $reservationPrice = $row['price'];
            // $totalPrice += $reservationPrice;
        } else {
            
        }

        echo "<form action='delete_reservation.php' method='post'>";
        echo "<input type='hidden' name='reservation_id' value='" . $servicesRow['reservation_id'] . "'>";
        echo "<button type='submit' name='delete_reservation' class='btn btn-danger'>Delete</button>";
        echo "</form>";

        echo "</div>"; // Close the cart div
    }
    
    echo "</div>";

   
} else {
    
}






?>


<div class="container d-flex justify-content-center align-items-center">
    <a href="payment.php">
  <button class="btn btn-primary">Proceed to Payment</button></a>
</div>


<div id="qrSection" class="modal">
    <div class="modal-content-qr">
      <span class="close" onclick="closeQrPopup()">&times;</span>
      <h2>Please send your Downpayment or Fullpayment to:</h2>
        <div class="row">
            
          <div class="col-lg-6">
            <img src="../assets/img/qrcode/qrcode.jpg" alt="QR Code" style="height:600px; margin-left:20%;">
          </div>
          <div class="col-lg-6">

            <h2>Input your reference number:</h2>

              <!-- Add the reference number form -->
              <form action="update_reference.php" method="post">
                    <label for="reference_number">Reference Number:</label>
                    <input type="text" name="reference_number" id="reference_number" required>
                    <input type="submit" value="Submit Reference Number">
                    <!-- Include hidden input fields for room_id, check_in_date, and check_out_date -->
                    <input type="hidden" name="room_id_reserve" value="">
                    <input type="hidden" name="check_in_date_reserve" value="">
                    <input type="hidden" name="check_out_date_reserve" value="">
              </form>

              <p>Amount to pay:</p>
              <p id='amount-to-pay'>Please select a payment term</p>


          </div>
        </div>
    </div>
  </div>

<script>
    function openQrPopup() {
        const qrCodeSection = document.getElementById('qrSection');
        qrCodeSection.style.display = 'block';

     

    }

    function closeQrPopup() {
        const qrCodeSection = document.getElementById('qrSection');
        qrCodeSection.style.display = 'none';
    }

    function downpayment(){
       // Get the element by its ID
        var totalPriceElement = document.getElementById("total-price");

        // Extract the text content from the element
        var totalPriceText = totalPriceElement.textContent;

        // Extract the numeric value from the text
        var totalPrice = parseFloat(totalPriceText.replace("Total Price: Php ", "").replace(",", ""));

        var downpayment = totalPrice * 0.3;
        document.getElementById("priceContainer").innerHTML = "Downpayment: Php " + downpayment.toFixed(2);
        document.getElementById("priceContainer").style.visibility = 'visible';

           // Get the element by its ID
        var amountToPay = document.getElementById("amount-to-pay");

        // Set the text content of the element
        amountToPay.textContent = "Php " + downpayment.toFixed(2);
}

    function fullpayment(){
         // Get the element by its ID
         var totalPriceElement = document.getElementById("total-price");

        // Extract the text content from the element
        var totalPriceText = totalPriceElement.textContent;

        // Extract the numeric value from the text
        var totalPrice = parseFloat(totalPriceText.replace("Total Price: Php ", "").replace(",", ""));

        var fullpayment = totalPrice;
        document.getElementById("priceContainer").innerHTML = "Downpayment: Php " + fullpayment.toFixed(2);
        document.getElementById("priceContainer").style.visibility = 'visible';

        // Get the element by its ID
        var amountToPay = document.getElementById("amount-to-pay");

        // Set the text content of the element
        amountToPay.textContent = "Php " + fullpayment.toFixed(2);
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