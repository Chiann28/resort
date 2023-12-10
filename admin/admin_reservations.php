<?php
    session_start();
    require_once 'config.php';
    $error_message = "";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if(isset($_POST['save_selected_services']))
    {
        $Selected_amenities_names = '';
        $amenities_price = '';
        $totalprice_amenities = 0;
        $reservation_id_amenities = $_POST['reservation_id_amenities'];
        // Check if selected_services and quantity arrays are set in the form data
        if (isset($_POST['selected_services']) && isset($_POST['quantity'])) {
            // Get the selected services and their quantities
            $selectedServices = $_POST['selected_services'];
            $quantity = $_POST['quantity'];

            // Loop through the selected services
            foreach ($selectedServices as $serviceNumber) 
            {

                // Retrieve the service details from the database based on $serviceNumber
                $serviceQuery = "SELECT description, price FROM services WHERE services_number = '$serviceNumber'";
                $serviceResult = $conn->query($serviceQuery);

                if ($serviceResult->num_rows > 0) 
                {
                    $serviceDetails = $serviceResult->fetch_assoc();

                    // Get the service details
                    $description = $serviceDetails['description'];
                    $price = $serviceDetails['price'];
                    

                    
                    // Get the quantity for the current service
                    $selectedQuantity = isset($quantity[$serviceNumber]) ? intval($quantity[$serviceNumber]) : 0;

                    if($selectedQuantity == '')
                    {
                        $selectedQuantity = 1;
                    }

                    $amenities_price .= $price.' | ';
                    $Selected_amenities_names .= $description.' ['.$selectedQuantity.'] | ';
                    $totalprice_amenities = $totalprice_amenities + ($price * $selectedQuantity);



                }
            }

            if($totalprice_amenities != '')
            {
                $_SESSION['updatedPrice'] = '';
                $sql = "UPDATE reservations SET Amenities_totalprice = '$totalprice_amenities', Amenities = '$Selected_amenities_names', Amenities_prices = '$amenities_price' WHERE reservation_id = '$reservation_id_amenities'";
                if ($conn->query($sql) === TRUE) {
                    // header('Location:user_reservations.php');
                    //exit();
                } else {
                    // Error handling
                    echo "Error updating record: " . $conn->error;
                }

            }

        } else {
            echo "No amenities selected.";
        }
    }

    if (isset($_POST['paymentsubmit'])) {

        $payment_type =  $_POST['payment_method'];
        $user_id = $_SESSION['user_id'];

        

        if($validationchecker == 0)
        {
          $sql = "SELECT * FROM reservations WHERE user_id = '$user_id' AND status = 'Pending' AND reference_number IS NULL";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) 
          {
              while ($row = $result->fetch_assoc()) 
              {
                  $room_id = $row['room_id'];
                  $roomPrice = 0;
                  $origroomPrice = 0;

                  if($room_id != ''){
                    $roomQuery = "SELECT price FROM rooms WHERE room_id = '{$row['room_id']}'";
                    $roomResult = $conn->query($roomQuery);

                    if ($roomResult->num_rows > 0) {
                        $roomData = $roomResult->fetch_assoc();
                        $roomPrice = $roomData['price'];
                        $origroomPrice = $roomPrice;
                    }

                    if($payment_type == "half"){
                        $roomPrice = $roomPrice * 0.3;
                        
                    }
                  }else{
                    $roomPrice = $row['services_price'];
                    $origroomPrice = $row['services_price'];

                    if($payment_type == "half"){
                        $roomPrice = $roomPrice * 0.3;
                    }
                  }

                  if(isset($_SESSION['promo_percentage']) && $_SESSION['promo_percentage'] != '' && $payment_type != 'half')
                  {
                    $discount_percentage = $_SESSION['promo_percentage'];
                    $origroomPrice = $origroomPrice - ($origroomPrice * $discount_percentage);
                    $roomPrice = $roomPrice - ($roomPrice * $discount_percentage);
                  }


                  $reservation_id = $row['reservation_id'];
                  // Update the reference number in the reservations table
                  $sql = "UPDATE reservations SET reference_number = '$reference_number', payable_amount = '$origroomPrice', paid_amount = '$roomPrice' WHERE user_id = '$user_id' AND reservation_id = '$reservation_id'";

                  if ($conn->query($sql) === TRUE) {


                    $audit_userid = $_SESSION['user_id'];
                    $audit_name = $_SESSION['user_nameaudit'];
                    $audit_action = "Guest paid its reservation with reservation ID: ".$reservation_id." onsite, payment reference #: ".$reference_number ;
                    $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                    if ($conn->query($auditloginsert) === TRUE) {}

                    $message = "Your Payment Has Been Successfully Submitted";
                    header('Location: payment_success.php');
                  } 
                  else 
                  {
                      $error_message = "Error: " . $sql . "<br>" . $conn->error;
                  }
              }
          }
        }
        else
        {
            $error_message = 'Payment Reference # is already existing, please try again!';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Hotel Management and Reservation System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- local css -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <style>
            .container {
            text-align: center;
            }
            .reservation,
            .cart {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .cart-item {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            }
            .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            }
            .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            }
            .btn-primary:hover,
            .btn-danger:hover {
            filter: brightness(90%);
            }
        </style>

   <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Fetch total reservations from the PHP script
      fetch('getTotalReservations.php')
        .then(response => {
          // Check if the response is a successful HTTP response (status code 2xx)
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          // Update the total reservations on the page
          document.querySelector('.card h2').textContent = data.total_reservations;
        })
        .catch(error => console.error('Error fetching data:', error.message));
    });
  </script>
</head>

<body>

<input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>K<span>amantigue</span></h3>
        </div>
        
        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(admin.jpg)"></div>
                <h4>Admin</h4>
                <small>admin</small>
            </div>

            <div class="side-menu">
              <ul>
                  <li>
                     <a href="admin_dashboard.php" >
                          <span class="las la-home"></span>
                          <small>Dashboard</small>
                      </a>
                  </li>
                  <li>
                     <a href="room_list.php">
                          <span class="las la-boxes"></span>
                          <small>Room List</small>
                      </a>
                  </li>
                  <li>
                     <a href="services_list.php">
                          <span class="lab la-servicestack"></span>
                          <small>Services</small>
                      </a>
                  </li>
                  <li>
                     <a href="cashier_module.php">
                          <span class="las la-clipboard-list"></span>
                          <small>Cashier Module</small>
                      </a>
                  </li>
                  <li>
                     <a href="checkout_list.php">
                          <span class="las la-clipboard-list"></span>
                          <small>Check Out</small>
                      </a>
                  </li>
                  <li>
                     <a href="reservation_list.php">
                          <span class="las la-clipboard-list"></span>
                          <small>Reservations</small>
                      </a>
                  </li>
                  <li>
                     <a href="add_new_reservations.php" class="active">
                          <span class="las la-clipboard-list"></span>
                          <small>New Reservation</small>
                      </a>
                  </li>
                  <li>
                     <a href="admin_users.php">
                          <span class="las la-user-friends"></span>
                          <small>User List</small>
                      </a>
                  </li>
                  <li>
                     <a href="manage_promocode.php">
                          <span class="las la-tasks"></span>
                          <small>Promo Code</small>
                      </a>
                  </li>

                  <li>
                    <a href="reports.php">
                         <span class="las la-tasks"></span>
                         <small>Reports</small>
                     </a>
                 </li>

                  <li>
                    <a href="https://premium121.web-hosting.com:2096/cpsess6146287962/3rdparty/roundcube/index.php?_task=mail&_mbox=INBOX">
                         <span class="las la-envelope"></span>
                         <small>Inquiries</small>
                     </a>
                 </li>

              </ul>
          </div>
      </div>
  </div>

  <div class="main-content">
    <header>
        <div class="header-content">
            <label for="menu-toggle">
                <span class="las la-bars"></span>
            </label>
            
            <div class="header-menu">
                <label for="">
                    <span></span>
                </label>
                
                <div class="notify-icon">
                    <span></span>
                    <span class="notify"></span>
                </div>
                
                <div class="notify-icon">
                    <span></span>
                    <span class="notify"></span>
                </div>
                
                <div class="user">
                    <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                    
                    <span class="las la-power-off"></span>
                    <a class="nav-link" href="logout.php"><span>Logout</span></a>   
                        
                </div>
            </div>
        </div>
    </header>

     <main>
        
        <div class="page-header">
            <h1>Add new reservations</h1>
            <small>Home / Add new reservations</small>
        </div>
 


        <?php 
            // Assuming you have the user ID stored in the session
            $user_id = $_SESSION['user_id'];
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
            
            // Query to fetch user reservations
            $sql = "SELECT reservations.*, rooms.room_number, rooms.price
                    FROM reservations
                    INNER JOIN rooms ON reservations.room_id = rooms.room_id
                    WHERE user_id = '{$_SESSION['user_id']}' AND reservations.status = 'Pending'  AND reservations.reference_number IS NULL";         
            $result = $conn->query($sql);
            $servicesQuery = "SELECT user_id, services_number, services_description, services_price, reservation_id, status, reference_number
                                FROM reservations
                                WHERE user_id = '{$_SESSION['user_id']}'
                                AND services_number IS NOT NULL
                                AND services_description IS NOT NULL
                                AND services_price IS NOT NULL AND status = 'Pending' AND reference_number IS NULL";
            $servicesResult = $conn->query($servicesQuery);
            
            $totalPrice = 0;
            $totalAmenitiesPrice = 0;
            $Amenities_IDS = '';
            $Amenities_PRICES = '';
            $_SESSION['totalPrice'] = $totalPrice;
            

            $roomPrice = 0; // Initialize the room's price
            if($result->num_rows == 0 && $servicesResult->num_rows == 0){
                echo "<center><div style='
                margin-top: 200px;
                text-align: center; /* Center text horizontally */
                background-color: #f9f9f9;
                padding: 10px;
                border: 1px solid #ccc;
                font-weight: bold;
                width: 50%;
                border-radius:1vh;
                '>Currently you have no reservations on the list</div></center><br><br>";
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

                    while ($row = $result->fetch_assoc()) 
                    {   
                        $totalAmenitiesPrice = $row['Amenities_totalprice'];
                        $Amenities_IDS = $row['Amenities'];
                        $Amenities_PRICES = $row['Amenities_prices'];


                        $roomQuery = "SELECT price FROM rooms WHERE room_id = '{$row['room_id']}'";
                        $roomResult = $conn->query($roomQuery);
                    
                        if ($roomResult->num_rows > 0) 
                        {
                            $roomData = $roomResult->fetch_assoc();
                            $roomPrice = $roomData['price'];
                        }

                        $checkInDate = new DateTime($row['check_in_date']);
                        $checkOutDate = new DateTime($row['check_out_date']);
                        $nightCount = $checkInDate->diff($checkOutDate)->format('%a');
                        $rawprice = $row['price'];
                        if($nightCount == 0 || $nightCount == '')
                        {
                            $nightCount = 1;
                        }
                        $total_price = $rawprice * $nightCount;


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
                            echo "<div class='cart-item'>Room Price:  " . number_format($row['price'],2) . " Php / Night</div>";
                            if($totalAmenitiesPrice != '' &&  $totalAmenitiesPrice != '0')
                            {
                                echo "<div class='cart-item'>Amenities Price:  " . number_format($totalAmenitiesPrice,2) . "</div>";
                            }
                            echo "<div class='cart-item'><b>Total Price:  ".number_format($total_price + $totalAmenitiesPrice,2). " Php</b></div>";
                            echo "<hr>";
                    
                        $reservationPrice = $total_price;
                        $totalPrice += $reservationPrice + $totalAmenitiesPrice;
                        
                        if ($row['status'] === 'Approved') 
                        {
                            echo "<div class='cart-item'>Reference Number: " . $row['reference_number'] . "</div>";
                        } 
                    
                            echo "<form action='delete_reservation.php' method='post'>";
                            echo "<input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>";
                            if($totalAmenitiesPrice != '' &&  $totalAmenitiesPrice != '0')
                            {
                                echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal" . $row['reservation_id'] . "'>Update Amenities</button><br>";
                            }
                            else
                            {
                                echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal" . $row['reservation_id'] . "'>Add Amenities</button><br>";
                            }
                            echo "<button type='submit' name='delete_reservation' class='btn btn-danger'>Delete</button>";
                            echo "</form>";
                            echo "</div>";  // Add the button to trigger the modal

                            ?>

                            <div class='modal fade' id='myModal<?php echo $row['reservation_id']; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                <div class='modal-dialog' role='document' style="max-width:100%; width:50%;">
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='exampleModalLabel'>Reservation Details</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <span>Reservation ID: <b><?php echo $row['reservation_id']; ?></b></span> <span style="float:right;">Room Number: <b><?php echo $row['room_number']; ?></b></span><br><br>
                                            <hr>
                                            <label>List of Available Amenities</label>
                                            <?php
                                           $sqlamenity = "SELECT description, price, services_number FROM services WHERE type='Amenities'";
                                            $resultamenity = $conn->query($sqlamenity);

                                            if ($resultamenity->num_rows > 0) 
                                            {
                                                echo "<form action='' method='post'><input type='hidden' id='reservation_id_amenities' name='reservation_id_amenities' value='{$row['reservation_id']}' />";
                                                echo "<table class='table'>";
                                                echo "<thead>";
                                                echo "<tr>";
                                                echo "<th style='width:5%;'>Select</th>";
                                                echo "<th>Description</th>";
                                                echo "<th>Price</th>";
                                                echo "<th style='width:25%;'>Quantity</th>";
                                                echo "</tr>";
                                                echo "</thead>";
                                                echo "<tbody>";

                                                while ($amenityRow  = $resultamenity->fetch_assoc()) 
                                                {
                                                    echo "<tr>";

                                                    if ($totalAmenitiesPrice != '') 
                                                    {
                                                        $amenitiesArray = explode(' | ', $Amenities_IDS);
                                                        $amenities_dict = [];

                                                        // Populate the array
                                                        foreach ($amenitiesArray as $amenity) {
                                                            preg_match('/(\w+) \[(\d+)\]/', $amenity, $matches);

                                                            if (count($matches) == 3) {
                                                                $amenity_name = $matches[1];
                                                                $quantity = (int)$matches[2];
                                                                $amenities_dict[$amenity_name] = $quantity;
                                                            }
                                                        }

                                                        // Check if the description exists in the array
                                                        $isSelected = in_array($amenityRow['description'], array_keys($amenities_dict));

                                                        // Checkbox
                                                        echo "<td><input type='checkbox' name='selected_services[]' value='{$amenityRow['services_number']}'";
                                                        echo $isSelected ? ' checked' : '';
                                                        echo "></td>";

                                                        echo "<td>{$amenityRow['description']}</td>";
                                                        echo "<td>" . number_format($amenityRow['price'], 2) . " Php</td>";

                                                        // Input quantity with buttons
                                                        echo "<td>";
                                                        echo "<button style='margin-top:-0.4vh;' type='button' class='btn btn-sm btn-outline-success' onclick='incrementQuantity(this, {$amenityRow['services_number']})'>+</button>&nbsp;";
                                                        echo "<input style='border-radius:1vh; width: 40px; text-align: center;' type='number' name='quantity[{$amenityRow['services_number']}]' value='" . ($isSelected ? $amenities_dict[$amenityRow['description']] : 0) . "' min='0' class='quantity-input'>";
                                                        echo "&nbsp;<button style='margin-top:-0.4vh;' type='button' class='btn btn-sm btn-outline-danger' onclick='decrementQuantity(this, {$amenityRow['services_number']})'>-</button>";
                                                        echo "</td>";
                                                    } 
                                                    else 
                                                    {
                                                        echo "<td>{$amenityRow['description']}</td>";
                                                        echo "<td>" . number_format($amenityRow['price'], 2) . " Php</td>";

                                                        // If no amenities selected, just display checkboxes and default quantity input
                                                        echo "<td><input type='checkbox' name='selected_services[]' value='{$amenityRow['services_number']}'></td>";
                                                        echo "<button style='margin-top:-0.4vh;' type='button' class='btn btn-sm btn-outline-success' onclick='incrementQuantity(this, {$amenityRow['services_number']})'>+</button>&nbsp;";
                                                        echo "<td><input style='border-radius:1vh; width: 40px; text-align: center;' type='number' name='quantity[{$amenityRow['services_number']}]' value='0' min='0' class='quantity-input'></td>";
                                                        echo "<button style='margin-top:-0.4vh;' type='button' class='btn btn-sm btn-outline-danger' onclick='decrementQuantity(this, {$amenityRow['services_number']})'>-</button>";
                                                    }

                                                    echo "</tr>";
                                                }

                                                echo "</tbody>";
                                                echo "</table>";

                                                // Add a submit button to save selected services in the session
                                                echo "<center><button style='width:40%;' type='submit' name='save_selected_services' class='btn btn-primary'>Add Selected Amenities</button></center>";

                                                echo "</form>";
                                            } 
                                            else 
                                            {
                                                echo "No amenities found.";
                                            }
                                            ?>


                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                    }

                echo "</div>";
            } 

            if ($servicesResult->num_rows > 0) {
                echo "<div class='row justify-content-center' style='margin-top:125px;'>";
                while ($servicesRow = $servicesResult->fetch_assoc()) {
                    echo "<div class='cart col-lg-3'>";
                    echo "<div class='cart-item'>Reservation ID: " . $servicesRow['reservation_id'] . "</div>";
                    echo "<div class='cart-item'>Services Number: " . $servicesRow['services_number'] . "</div>";
                    echo "<div class='cart-item'>Description: " . $servicesRow['services_description'] . "</div>";
                    echo "<div class='cart-item'>Price: " . $servicesRow['services_price'] . "</div>";
                    $reservationPrice = $roomPrice;
            
                    $servicesPrice = $servicesRow['services_price'];
                    if ($servicesRow['services_price'] > 0) {
                        $reservationPrice += $servicesRow['services_price'];
                    }
                    $totalPrice += $reservationPrice;
                    
                    
                    if ($servicesRow['status'] === 'Approved') {
                        echo "<div class='cart-item'>Reference Number: " . $servicesRow['reference_number'] . "</div>";
                    } else {
                    }
            
                    echo "<form action='delete_reservation.php' method='post'>";
                    echo "<input type='hidden' name='reservation_id' value='" . $servicesRow['reservation_id'] . "'>";
                    echo "<button type='submit' name='delete_reservation' class='btn btn-danger'>Delete</button>";
                    echo "</form>";
            
                    echo "</div>"; // Close the cart div
                }
                
                echo "</div>";          
            }
            ?>
        <div class="container text-center mt-5">
    <?php // Display the total price at the bottom ?>
    <div id='total-price' class="mb-3 mx-auto" style='
        background-color: #f9f9f9;
        padding: 10px;
        border: 1px solid #ccc;
        font-weight: bold;
        width: 25vh;
    '>Total Price: Php <?php echo number_format($totalPrice, 2); ?></div>
    <?php $_SESSION['initialPrice'] = $totalPrice; ?>

    <?php
    // Display the total price at the bottom
    // Display the updated price only if a promo code has been applied
    if (isset($_SESSION['updatedPrice']) && $_SESSION['updatedPrice'] > 0) ?>
        

    <div id="DG" class="container mb-3 mx-auto" style='
        background-color: #f9f9f9;
        padding: 10px;
        border: 1px solid #ccc;
        font-weight: bold;
        visibility: hidden;
        display:none;
    '>
        <div class="price-container" id="priceContainer">Payable Amt: Php <?php echo  number_format($totalPrice, 2); ?></div>
    </div>

    

    <?php if($error_message != '') { ?>
        <div class="mb-3">
            <label style="background-color:red; border-radius:2vh; padding:5px; color:white; width:30vh;">
                <?php echo $error_message; $error_message = ''; ?>
            </label>
        </div>
    <?php } ?>

    <div class="container d-flex justify-content-center align-items-center">
        <form action=""  id="fullgcash" method="post" style="display:block;">
        <input type="submit" class="btn btn-primary" id="paymentsubmit" name="paymentsubmit" value="Proceed">
    </div>
</div>

        
            </div>
        </div>
<script>
    function incrementQuantity(button) {
        var input = button.parentNode.querySelector('.quantity-input');
        input.value = parseInt(input.value) + 1;
    }

    function decrementQuantity(button) {
        var input = button.parentNode.querySelector('.quantity-input');
        input.value = Math.max(0, parseInt(input.value) - 1);
    }
</script>

        <script>
            function openQrPopup() {
                const qrCodeSection = document.getElementById('qrSection');
                qrCodeSection.style.display = 'block';
            }
            
            function closeQrPopup() {
                const qrCodeSection = document.getElementById('qrSection');
                qrCodeSection.style.display = 'none';
            }
        </script>
        <script>
            function downpayment(){
            
                document.getElementById("fullgcash").style.display = 'none';
                document.getElementById("halfgcash").style.display = 'block';
            
                var downpaymentButton = document.getElementById("downpaymentButton");
                var fullpaymentButton = document.getElementById("fullpaymentButton");
            
                fullpaymentButton.style.backgroundColor = '#007bff';
                fullpaymentButton.style.color = 'white';
            
                downpaymentButton.style.backgroundColor = 'lightgreen';
                downpaymentButton.style.color = 'black';
            
               // Get the element by its ID
                var totalPriceElement = document.getElementById("total-price");
            
                // Extract the text content from the element
                var totalPriceText = totalPriceElement.textContent;
            
                // Extract the numeric value from the text
                var totalPrice = parseFloat(totalPriceText.replace("Total Price: Php ", "").replace(",", ""));
            
                var downpayment = totalPrice * 0.3;
                document.getElementById("priceContainer").innerHTML = "Downpayment: Php " + downpayment.toFixed(2);
                document.getElementById("priceContainer").style.visibility = 'visible';
                document.getElementById("priceContainer").style.display = 'block';
            
                document.getElementById("DG").style.display = 'block';
                   // Get the element by its ID
                var amountToPay = document.getElementById("amount-to-pay");
            
                // Set the text content of the element
                amountToPay.textContent = "Php " + downpayment.toFixed(2);
            }
            
            function fullpayment(){
            
                document.getElementById("fullgcash").style.display = 'block';
                document.getElementById("halfgcash").style.display = 'none';
            
                var downpaymentButton = document.getElementById("downpaymentButton");
                var fullpaymentButton = document.getElementById("fullpaymentButton");
            
                downpaymentButton.style.backgroundColor = '#007bff';
                downpaymentButton.style.color = 'white';
            
                fullpaymentButton.style.backgroundColor = 'lightgreen';
                fullpaymentButton.style.color = 'black';
            
                 // Get the element by its ID
                 var totalPriceElement = document.getElementById("total-price");
            
                // Extract the text content from the element
                var totalPriceText = totalPriceElement.textContent;
            
                // Extract the numeric value from the text
                var totalPrice = parseFloat(totalPriceText.replace("Total Price: Php ", "").replace(",", ""));
            
                var fullpayment = totalPrice;
                document.getElementById("priceContainer").innerHTML = "Downpayment: Php " + fullpayment.toFixed(2);
                document.getElementById("priceContainer").style.visibility = 'hidden';
                document.getElementById("priceContainer").style.display = 'none';
            
                document.getElementById("DG").style.display = 'none';
            
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
