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

        $reference_number = $_POST['reference_num'];

        $validationchecker = 0;
        $sqlg = "SELECT * FROM reservations WHERE reference_number = '$reference_number'";
        $resultg = $conn->query($sqlg);
        if ($resultg->num_rows > 0) 
        {
            while ($rowg = $resultg->fetch_assoc()) 
            {
              $validationchecker++;
            }
        }

        if($validationchecker == 0)
        {
          $sql = "SELECT * FROM reservations WHERE user_id = '$user_id' AND status IN('Pending', 'Rescheduled') AND reference_number IS NULL";
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
                    $audit_action = "Guest paid its reservation with reservation ID: ".$reservation_id." thru Gcash, payment reference #: ".$reference_number ;
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
            body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #495057;
            }
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

        <!-- Add these lines to include Bootstrap CSS and JS files -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    </head>
    <body>
        <?php include('user_navbar.php'); ?>
        <?php 
            // Assuming you have the user ID stored in the session
            $user_id = $_SESSION['user_id'];
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
            
            // Query to fetch user reservations
            $sql = "SELECT reservations.*, rooms.room_number, rooms.price
                    FROM reservations
                    INNER JOIN rooms ON reservations.room_id = rooms.room_id
                    WHERE user_id = '{$_SESSION['user_id']}' AND reservations.status IN ('Pending', 'Rescheduled')  AND reservations.reference_number IS NULL";         
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
                    case 'Rescheduled':
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
                            echo "<p style='color:red; font-size:12px;'>*Cancellation must be made 1 day before the reservation. If you choose to reschedule you can view your transactions
                            under 'My transactions' tab on your profile.";
                    
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

                            // echo "<button type='button' class='btn btn-info' data-toggle='modal' data-target='#rescheduleModal" . $row['reservation_id'] . "'>Reschedule</button><br>";

                            echo "<button type='submit' name='delete_reservation' class='btn btn-danger'>Delete</button>";
                            echo "</form>";
                            echo "</div>";  

                            
                            // Reschedule modal
                            echo "<div class='modal fade' id='rescheduleModal{$row['reservation_id']}' tabindex='-1' role='dialog' aria-labelledby='rescheduleModalLabel' aria-hidden='true'>";
                            echo "<div class='modal-dialog' role='document'>";
                            echo "<div class='modal-content'>";
                            echo "<div class='modal-header'>";
                            echo "<h5 class='modal-title' id='rescheduleModalLabel'>Reschedule Reservation</h5>";
                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                            echo "<span aria-hidden='true'>&times;</span>";
                            echo "</button>";
                            echo "</div>";
                            echo "<div class='modal-body'>";
                            echo "<form action='reschedule_reservation.php' method='post'>";
                            echo "<input type='hidden' name='reservation_id' value='{$row['reservation_id']}' />";
                            echo "<div class='form-group'>";
                            echo "<label for='new_check_in_date'>New Check-in Date:</label>";
                            echo "<input type='date' class='form-control' id='new_check_in_date' name='new_check_in_date' required />";
                            echo "</div>";
                            echo "<div class='form-group'>";
                            echo "<label for='new_check_out_date'>New Check-out Date:</label>";
                            echo "<input type='date' class='form-control' id='new_check_out_date' name='new_check_out_date' required />";
                            echo "</div>";
                            echo "<button type='submit' class='btn btn-primary'>Reschedule</button>";
                            echo "</form>";
                            echo "</div>";
                            echo "<div class='modal-footer'>";
                            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";

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
        <div class="row justify-content-center">
            <div class="col-lg-3 ">
                <div style="width: fit-content; text-align: center; left: 50%; background-color: #f9f9f9; padding: 10px; border: 1px solid #ccc; font-weight: bold; margin: 20px auto 0; margin-top: 20px;">
                    <?php // Display the total price at the bottom ?>
                    <div id='total-price' style='
                        background-color: #f9f9f9;
                        padding: 10px;
                        border: 1px solid #ccc;
                        font-weight: bold;
                        width:25vh;
                        '>Total Price: Php <?php echo number_format($totalPrice, 2); ?></div>
                    <?php $_SESSION['initialPrice'] = $totalPrice; ?>
                    <?php
                        // Display the total price at the bottom
                        // Display the updated price only if a promo code has been applied
                        if (isset($_SESSION['updatedPrice']) && $_SESSION['updatedPrice'] > 0) { ?>
                    <div style='
                        background-color: #f9f9f9;
                        padding: 10px;
                        border: 1px solid #ccc;
                        font-weight: bold;
                        color: green;
                        width:25vh;
                        '>Updated Price: Php <?php echo number_format($_SESSION['updatedPrice'], 2); ?></div>
                    <?php } ?>
                    <div id="DG" class="container d-flex justify-content-center align-items-center" style='
                        margin: 0 auto; /* Center horizontally */
                        width: fit-content; /* Adjust the width based on content */
                        text-align: center; /* Center text horizontally */
                        left: 50%; /* Center horizontally */
                        background-color: #f9f9f9;
                        padding: 10px;
                        border: 1px solid #ccc;
                        font-weight: bold;
                        visibility: hidden;
                        display:none;
                        '>
                        <div class="price-container" id="priceContainer">Payable Amt: Php <?php echo  number_format($totalPrice, 2); ?></div>
                    </div>
                </div>
                <br>
                <center><label>Select Payment Option</label></center>
                <div class="container d-flex justify-content-center align-items-center">
                    <button class="btn btn-primary downpayment" id = "downpaymentButton" onclick="downpayment()" style="margin-right:1vh; background-color:#007bff; color:white;">Downpayment</button>
                    <button class="btn btn-primary downpayment" id = "fullpaymentButton" onclick="fullpayment()" style="margin-left:1vh; background-color:lightgreen; color:black;">Fullpayment</button>
                </div>
                    <br><br><br>
            </div>
            <div class="col-lg-3">
                <style>
                    .modal2 {
                        display: none;
                        position: fixed;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        width: 80%;
                        max-width: 600px;
                        background-color: #fff;
                        padding: 20px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
                    }

                    .modal2 img {
                        max-width: 100%;
                        height: auto;
                        display: block;
                        margin-bottom: 20px;
                    }

                    .upload-section {
                        display: flex;
                        flex-direction: column;
                    }

                    .upload-btn-wrapper {
                        position: relative;
                        overflow: hidden;
                        margin-top: 20px;
                        cursor: pointer !important; /* Set cursor here */
                    }

                    .btn2 {
                        border: 2px solid gray;
                        color: gray;
                        background-color: white;
                        padding: 8px 20px;
                        border-radius: 8px;
                        font-size: 16px;
                        font-weight: bold;
                        cursor: pointer !important; /* Set cursor here */
                    }

                    .upload-btn-wrapper input[type=file] {
                        font-size: 100px;
                        position: absolute;
                        left: 0;
                        top: 0;
                        opacity: 0;
                        width: 100%;
                        height: 100%;
                        cursor: pointer !important; /* Set cursor here */
                    }
                </style>
                <form action='apply_promo.php' method='post' style='width: fit-content; text-align: center; left: 50%; background-color: #f9f9f9; padding: 10px; border: 1px solid #ccc; font-weight: bold; margin: 20px auto 0; margin-top: 20px;'>
                    <label for='promo_code'>Promo Code:</label>
                    <input type='text' id='promo_code' name='promo_code' required>
                    <button type='submit' name='apply_promo'>Apply Promo Code</button>
                </form>
                <br>
                <?php if($error_message != ''){  ?>
                <center><label style="background-color:red; border-radius:2vh; padding:5px; color:white; width:30vh;"><?php if($error_message != ''){ echo $error_message; $error_message = ''; } ?></label></center>
                <?php } ?>
                <div class="container d-flex justify-content-center align-items-center">
                    <button class="btn btn-primary" onclick="openQrPopup()">Proceed to Payment</button>
                </div>
            </div>
        </div>

        <div id="qrSection" class="modal2" style="z-index:9999; border-radius:1vh;">
            <center>
                <img src="../assets/img/qrcode/qrcode.jpg" alt="QR Code" style="height:600px; border-radius:2vh;">
                <small style="color:red;">Scan this QR Code to proceed with your payment, then after paying input the payment reference # below for us to easily track your payments.</small>
            </center>
            <div class="upload-section">
                <form action=""  id="fullgcash" method="post" style="display:block;">
                    <center>
                    <input type="hidden" id="payment_method" name="payment_method" value="full"/>
                    <label for="file-upload" class="upload-btn-wrapper">
                        <button class="btn2" disabled>GCash Ref#</button>
                        <input type="text" id="reference_num" name="reference_num" placeholder="Enter Payment Ref #" required>
                    </label>
                    </center>
                    <center> 
                        <input type="submit" class="btn btn-primary" id="paymentsubmit" name="paymentsubmit" value="Submit Full Payment"> 
                    </center>
                    <hr>
            
                </form>
                <form action=""  id="halfgcash"  method="post" style="display:none;">
                    <center>
                    <input type="hidden" id="payment_method" name="payment_method" value="half"/>
                    <label for="file-upload" class="upload-btn-wrapper">
                        <button class="btn2" disabled>GCash Ref#</button>
                        <input type="text" id="reference_num" name="reference_num" placeholder="Enter Payment Ref #" required>
                    </label>
                    </center>
                    <center>
                    <input type="submit" class="btn btn-primary" id="paymentsubmit" name="paymentsubmit"  value="Submit Partial Payment"> 
                    </center>
                    <hr>
                </form>
                <center>
                     <button class="close-btn" onclick="closeQrPopup()" style="float:right; background-color:white; color:black; width:200px;">Close</button>
                </center>
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