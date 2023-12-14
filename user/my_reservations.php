
<?php
        session_start();
        require_once 'config.php';
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
            margin-right:20px;
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
        <br><br>
        <?php 
        // Assuming you have the user ID stored in the session
        $user_id = $_SESSION['user_id'];
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

        // Query to fetch user reservations
        $sql = "SELECT reservations.*, rooms.room_number, rooms.price
                FROM reservations
                INNER JOIN rooms ON reservations.room_id = rooms.room_id
                WHERE user_id = '{$_SESSION['user_id']}' AND reservations.reference_number IS NOT NULL";

        $result = $conn->query($sql);

        $servicesQuery = "SELECT user_id, services_number, services_description, services_price, reservation_id, status, reference_number
                            FROM reservations
                            WHERE user_id = '{$_SESSION['user_id']}'
                            AND services_number IS NOT NULL
                            AND services_description IS NOT NULL
                            AND services_price IS NOT NULL  AND reference_number IS NOT NULL";

        $servicesResult = $conn->query($servicesQuery);

        // Initialize total price
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
            while ($row = $result->fetch_assoc()) {

            $totalAmenitiesPrice = $row['Amenities_totalprice'];
            $Amenities_IDS = $row['Amenities'];
            $Amenities_PRICES = $row['Amenities_prices'];

            // $roomPrice = 0; // Initialize the room's price
            $roomQuery = "SELECT price FROM rooms WHERE room_id = '{$row['room_id']}'";
            $roomResult = $conn->query($roomQuery);

            if ($roomResult->num_rows > 0) {
                $roomData = $roomResult->fetch_assoc();
                $roomPrice = $roomData['price'];
            }

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
            if($totalAmenitiesPrice != '' && $totalAmenitiesPrice != '0')
            {
                echo "<div class='cart-item'>Amenities Price:  " . number_format($totalAmenitiesPrice,2) . "</div>";
            }
            echo "<div class='cart-item'><b>Total Price:  ".number_format($row['price'] + $totalAmenitiesPrice,2). " Php</b></div>";

            $reservationPrice = $roomPrice;
            $totalPrice += $reservationPrice + $totalAmenitiesPrice;
            
             echo "<div class='cart-item'>Gcash Reference Number: " . $row['reference_number'] . "</div><br>";
           
            if($totalAmenitiesPrice != '' && $totalAmenitiesPrice != '0')
            {
                echo "<button type='button' style='background-color:white; color:black; border: 1px solid black;' class='btn btn-primary' data-toggle='modal' data-target='#myModal" . $row['reservation_id'] . "'>View Availed Amenities</button><br>";
            }
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
                                            <label>List of Selected Amenities</label>
                                            <?php
                                           $sqlAMENITY = "SELECT description, price, services_number FROM services WHERE type='Amenities'";
                                            $resultamenity = $conn->query($sqlAMENITY);

                                            if ($resultamenity->num_rows > 0) {
                                                echo "<form action='' method='post'><input type='hidden' id='reservation_id_amenities' name='reservation_id_amenities' value='{$row['reservation_id']}' />";
                                                echo "<table class='table'>";
                                                echo "<thead>";
                                                echo "<tr>";
                                                echo "<th>Description</th>";
                                                echo "<th>Price</th>";
                                                echo "<th style='width:25%;'>Quantity</th>";
                                                echo "</tr>";
                                                echo "</thead>";
                                                echo "<tbody>";

                                                $displayedAmenities = [];  // Track displayed amenities

                                                while ($rowamenity = $resultamenity->fetch_assoc()) {
                                                    if ($totalAmenitiesPrice != '' && $totalAmenitiesPrice != '0') {
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

                                                        foreach ($amenities_dict as $amenity_name => $quantity) {
                                                            // Check if the amenity has already been displayed
                                                            if (!in_array($amenity_name, $displayedAmenities)) {
                                                                echo "<tr>";
                                                                echo "<td>{$amenity_name}</td>";
                                                                echo "<td>" . number_format($rowamenity['price'], 2) . " Php</td>";
                                                                echo "<td>" . $quantity . "</td>";
                                                                echo "</tr>";

                                                                // Mark the amenity as displayed
                                                                $displayedAmenities[] = $amenity_name;
                                                            }
                                                        }
                                                    }
                                                }


                                                echo "</tbody>";
                                                echo "</table>";

                                            } else {
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
                

                echo "<button type='button' class='btn btn-info' data-toggle='modal' data-target='#rescheduleModal" . $row['reservation_id'] . "'>Reschedule</button><br>";
                echo "</div>"; // Close the cart div

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
                
                
                    echo "<div class='cart-item'>Gcash Reference Number: " . $servicesRow['reference_number'] . "</div>";
               


                echo "</div>"; // Close the cart div
            }
            
            echo "</div>";
        }
        ?>

        <!-- Vendor JS Files -->
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