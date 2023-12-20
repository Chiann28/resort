<?php
  // Start the session
  session_start();
  
  // Check if admin is logged in, otherwise redirect to login page
  if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
      header("Location: admin_login.html");
      exit();
  }
  
  
  // Replace with your database connection details
  // $servername = "localhost";
  // $dbusername = "root";
  // $dbpassword = "";
  // $dbname = "hotel_management";
  
  require_once 'config.php';
  
  // Create a database connection
  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  
  $user_fetched_id = $_REQUEST['user_id'];
  
  $sql = "SELECT reservations.*,rooms.price as room_price, rooms.room_id, rooms.room_number, rooms.description, users.name, users.email
          FROM reservations
          JOIN rooms ON reservations.room_id = rooms.room_id
          JOIN users ON reservations.user_id = users.user_id";
  
  
      $sql .= " WHERE reservations.user_id = '$user_fetched_id'";


  $sql .= " ORDER BY reservations.reservation_id DESC";
  
  $result = $conn->query($sql);
  
  $servicesSQL = "SELECT reservations.*, services_number, services_description, services_price, reservation_id, status, reference_number, users.name, users.email
                FROM reservations
                JOIN users ON reservations.user_id = users.user_id
                WHERE services_number IS NOT NULL
                  AND services_description IS NOT NULL
                  AND services_price IS NOT NULL";

  
$servicesSQL .= " AND reservations.user_id = '$user_fetched_id'";

$servicesSQL .= " ORDER BY reservations.services_number DESC";
  
  $servicesResult = $conn->query($servicesSQL);
  

  

  
  $termsandconditions = "
  <hr>
    <center><h4>Terms and Conditions</h4></center>
    <br>
    Room Reservations
    <br>
    1. Booking Confirmation:<br>
    Your room reservation is confirmed upon receipt of payment and subject to availability.<br>
    
    2. Payment:<br>
    Full payment is required to secure your reservation. Payments can be made online or at the hotel.<br>
    
    3. Cancellation:<br>
    For cancellations made 48 hours or more before the check-in date, a full refund will be provided. Cancellations within 48 hours are non-refundable.<br>
    
    4. Check-in and Check-out:<br>
    Check-in time is 3:00 PM, and check-out time is 12:00 PM. Early check-in and late check-out are subject to availability and may incur additional charges.<br>
    
    5. Damages:<br>
    Guests are responsible for any damages caused to the room or hotel property during their stay.<br>
    
    6. No Smoking Policy:<br>
    Smoking is not allowed in any indoor areas of the hotel. A cleaning fee will be charged for violations.<br>
    
    7. Pets:<br>
    Sorry, pets are not allowed in the hotel rooms.<br>
    
    8. Governing Law:<br>
    These terms and conditions are governed by the laws of the jurisdiction where the hotel is located.<br>
";
  ?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Kamantigue Beach and Diving Resort</title>
	<link rel="shortcut icon" type="image/x-icon" href="admin.jpg">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/css/feathericon.min.css">
	<link rel="stylehseet" href="https://cdn.oesmith.co.uk/morris-0.5.1.css">
	<link rel="stylesheet" href="assets/plugins/morris/morris.css">
	<link rel="stylesheet" href="assets/css/style.css"> 
	<style>
	
	</style>
</head>

<body>
	<div class="main-wrapper">
    <div class="header">
			<div class="header-left">
				<a href="admin_dashboard.php" class="logo"> <img src="admin.jpg" width="50" height="70" alt="logo"> <span class="logoclass">Kamantigue</span> </a>
				<a href="admin_dashboard.php" class="logo logo-small"> <img src="admin.jpg" alt="Logo" width="30" height="30"> </a>
			</div>
			<a href="javascript:void(0);" id="toggle_btn"> <i class="fe fe-text-align-left"></i> </a>
			<a class="mobile_btn" id="mobile_btn"> <i class="fas fa-bars"></i> </a>
			
			
	</div>
  <div class="sidebar" id="sidebar">
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li class="submen"> <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a> </li>
						<li class="list-divider"></li>
						<li class="submenu"> <a href="#"><i class="fas fa-suitcase"></i> <span> Booking </span> <span class="menu-arrow"></span></a>
							<ul class="submenu_class" style="display: none;">
								<li><a href="reservation_list.php" > All Reservations </a></li>
								<li><a href="reschedule.php"> Rescheduled Reservations </a></li>
								<li><a href="cancelled_list.php"> Cancelled Reservations </a></li>
								<li><a href="add_new_reservations.php"> Add Reservations </a></li>
								<li><a href="checkout_list.php"> Check out </a></li>
							</ul>
						</li>
						<li class="submenu"> <a href="#"><i class="fas fa-user"></i> <span> Customers </span> <span class="menu-arrow"></span></a>
							<ul class="submenu_class" style="display: none;">
								<li><a href="admin_users.php"> All customers </a></li>
							</ul>
						</li>
						<li class="submenu"> <a href="#"><i class="fas fa-key"></i> <span> Rooms </span> <span class="menu-arrow"></span></a>
							<ul class="submenu_class" style="display: none;">
								<li><a href="room_list.php">All Rooms </a></li>
								<li><a href="services_list.php"> Services </a></li>
								<li><a href="manage_promocode.php"> Promo Codes </a></li>
							</ul>
						</li>
		
						<li class="submenu"> <a href="#"><i class="fe fe-table"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
							<ul class="submenu_class" style="display: none;">
								<li><a href="reports.php">Sales Report </a></li>
								<li><a href="guest_report.php">Guest Report </a></li>
                                <li><a href="room_report.php">Room Report </a></li>
                                <li><a href="transaction_report.php" class="active">Transactions Report </a></li>
                                <li><a href="audit_report.php">Audit Report </a></li>
							</ul>
						</li>
                        <li> <a href="calendar.html"><i class="fas fa-calendar-alt"></i> <span>Calendar</span></a> </li>
						<li> <a href="https://premium121.web-hosting.com:2096/cpsess6146287962/3rdparty/roundcube/index.php?_task=mail&_mbox=INBOX"><i class="fe fe-table"></i> <span>Inquiries</span></a> </li>
						
					</ul>
				</div>
			</div>
		</div>
		<div class="page-wrapper">
			<div class="content container-fluid">
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<div class="mt-5">
								<h4 class="card-title float-left mt-2">Transaction Report of Guest ID# : <?php echo  $user_fetched_id ; ?></h4>
                                <button onclick="printTable()" style="margin-left:20px; margin-top:7px; background-color:gray; color:white;">Print Report</button>
                            </div>
						</div>
					</div>
				</div>
        <style>

      td {
          text-align: left;
    vertical-align: top; 
          padding: 8px; /* Adjust padding as needed */
          border: 1px solid #ddd; /* Add borders if desired */
      }
        </style>
				<div class="row">
					<div class="col-sm-12">
						<div class="card card-table">
							<div class="card-body booking_card">
								<div class="table-responsive">
									<table style="width:100%;">
                  <tr>
            <!-- <th>Reservation ID</th> -->
            <th>Transaction Details</th>
            <th>Dates Details</th>
            <th>Price Details</th>
            <th>Payment Details</th>
            <th>Status</th>
            <th>Type</th>
            <th>Print Receipt</th>
            <!-- Add more columns as needed -->
          </tr>
          <?php
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
            
            if ($result != '' && $result->num_rows == 0 && $servicesResult != '' && $servicesResult->num_rows == 0) {
                echo "<tr><td colspan='12'>No reservations found.</td></tr>";
            }
            // Loop through the query result and display the reservation details in each row
            if ($result != '' && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $statusClass = getStatusClass($row['status']);
            
                  $Amenities_IDS = $row['Amenities'];
                $totalAmenitiesPrice = $row['Amenities_totalprice'];
                    $totalbalance = '0';
                    $gcashdetails = 'Waiting';
                    if($row['reference_number'] != ''){
                      $totalbalance = $row['payable_amount'] - $row['paid_amount'];
                      $gcashdetails = "Gcash Ref#: " . $row['reference_number'] . "<br>
                      Payable Amount: ".$row['payable_amount']."<br>
                      Paid Amount: ".$row['paid_amount']."<br>
                      Balance: ".$totalbalance;
                    }
                    
                    echo "<tr class='$statusClass'>";
                    // echo "<td>" . $row['reservation_id'] . "</td>";
                    echo "<td style='color:black;'>Room ID: " . $row['room_id'] . "<br>";
                    echo "Room #: " . $row['room_number'] . "<br>";
                    echo "Room Info: " . $row['description'] . "<br>";
                    echo "# of Adults: " . $row['adults'] . "<br>";
                    if($row['childrenfree'] != '0' && $row['childrenfree'] != ''){

                    echo "# of Childrens ( 8yrs old above ): " . $row['children'] . "<br>";
                    echo "# of Childrens ( 8yrs old & below ): " . $row['childrenfree'] . "<br><br>Amenities Lists:<br>";
                    }else{

                    echo "# of Childrens ( 8yrs old above ): " . $row['children'] . "<br><br>Amenities Lists:<br>";
                    }

                    ?>
          <?php
            $sqlAMENITY = "SELECT description, price, services_number FROM services WHERE type='Amenities'";
             $resultamenity = $conn->query($sqlAMENITY);
            
             if ($resultamenity->num_rows > 0) {
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
                                 echo "{$amenity_name}";
                                 echo " " . number_format($rowamenity['price'], 2) . " Php";
                                 echo " (x" . $quantity . ")<br>";
            
                                 // Mark the amenity as displayed
                                 $displayedAmenities[] = $amenity_name;
                             }
                         }
                     }
                 }
            
            
             } else {
                 echo "No amenities found.";
             }
             ?>
          <?php

            echo "<td>Check-in Date: " . $row['check_in_date'] . "<br>";
            echo "Check-out Date: " . $row['check_out_date'] . "</td>";
            
            echo "<td style='color:black; '>
            Total Amount: " . number_format($row['payable_amount'],2) . " Php<br>
            Paid Amount: ".number_format($row['paid_amount'],2)." Php<br>
            Remaining Bal: ".number_format(($row['payable_amount'] - $row['paid_amount']),2)." Php
            </td>";
            
            if($row['user_id'] != '99999' && $row['name'] != 'Admin Cashier'){
            if($row['down_payment'] != '0'){
            
            echo "<td style='color:black;'>Gcash Ref#: ".$row['reference_number']."<br>Downpayment: ".number_format($row['down_payment'],2)." Php
            <br><br>Onsite Payment<br>Paid Amount: ".number_format(($row['paid_amount'] - $row['down_payment']),2)."</td>";
            }else{
            
            echo "<td style='color:black;'>Gcash Ref#: ".$row['reference_number']."<br>Paid Amount: ".number_format($row['paid_amount'],2)." Php</td>";
            }
            }else{

            echo "<td style='color:black;'>Payment Ref#: ".$row['reference_number']."<br>Downpayment: ".number_format($row['down_payment'],2)." Php
            <br><br>Onsite Payment<br>Paid Amount: ".number_format(($row['paid_amount']),2)."</td>";
            }
            echo "<td>" . $row['status'] . "</td>";

            if($row['user_id'] != '99999' && $row['name'] != 'Admin Cashier'){
              echo '<td>Online Reservation</td>';
            }else{

              echo '<td>Onsite Reservation</td>';
            }

            echo "<td><a class='btn btn-primary' href='#' data-toggle='modal' data-target='#printReceiptModal{$row['reservation_id']}'>View Details</a></td>";


            echo "<div class='modal fade ' id='printReceiptModal{$row['reservation_id']}' tabindex='-1' role='dialog' aria-labelledby='printReceiptModalLabel' aria-hidden='true'>";
            echo "<div class='modal-dialog' role='document'  style='width:100vh !important; max-width:100% !important;'>";
            echo "<div class='modal-content' style='width:100vh !important; max-width:100% !important;'>";
            echo "<div class='modal-header' style='width:100vh !important; max-width:100% !important;'>";
            echo "</div>";
            echo "<div class='modal-body' style='width:100vh !important; max-width:100% !important;'>";

            echo "<center><h2>Kamantigue Official Receipt</h2></center><br><br>";


            echo "<div style='display: flex; justify-content: space-between;'>";
            echo "<div style='flex: 1;'>";
            echo "<p><strong>Guest Name:</strong> {$row['name']}</p>";
            echo "<p><strong>Guest Email:</strong> {$row['email']}</p>";
            echo "</div>";
            echo "<div style='flex: 1; text-align: right;'>";
            echo "<p><strong>Check-in Date:</strong> {$row['check_in_date']}</p>";
            echo "<p><strong>Check-out Date:</strong> {$row['check_out_date']}</p>";
            echo "</div>";
            echo "</div><hr>";


            echo "<div style='display: flex; justify-content: space-between;'>";
            echo "<div style='flex: 1;'>";
            echo "<p><strong>Reservation ID: {$row['reservation_id']} </strong>";
            echo "<br><strong>Room ID: {$row['room_id']} </strong> ";
            echo "<br><strong>Room: {$row['room_number']} </strong>";
            echo "<br><strong> {$row['description']} </strong></p>";
            echo "</div>";
            echo "<div style='flex: 1; text-align: right;'>";
            echo "<p><strong>Adults: {$row['adults']} </strong> <br><strong> Children (8yrs old above): {$row['children']}  <br><strong> Children (8yrs old & below): {$row['childrenfree']}</strong></p>";
            echo "<p><strong>Reservation Status: {$row['status']}</strong></p>";

            echo "</div>";
            echo "</div><hr>";

            echo "<div style='display: flex; justify-content: space-between;'>";
            echo "<div style='flex: 1;'>";
            echo "<div style='text-align: left;'><strong>List of Amenities</strong><br>";
            $sqlAMENITY = "SELECT description, price, services_number FROM services WHERE type='Amenities'";
            $resultamenity = $conn->query($sqlAMENITY);
            if ($resultamenity->num_rows > 0) {
                $displayedAmenities = [];
                while ($rowamenity = $resultamenity->fetch_assoc()) {
                    $amenitiesArray = explode(' | ', $Amenities_IDS);
                    $amenities_dict = [];
                    foreach ($amenitiesArray as $amenity) {
                        preg_match('/(\w+) \[(\d+)\]/', $amenity, $matches);
                        if (count($matches) == 3) {
                            $amenity_name = $matches[1];
                            $quantity = (int)$matches[2];
                            $amenities_dict[$amenity_name] = $quantity;
                        }
                    }
                    foreach ($amenities_dict as $amenity_name => $quantity) {
                        if (!in_array($amenity_name, $displayedAmenities)) {
                            echo "<span>{$amenity_name} - " . number_format($rowamenity['price'], 2) . " Php (x{$quantity})</span><br>";
                            $displayedAmenities[] = $amenity_name;
                        }
                    }
                }
            } else {
                echo "<p>No Amenities Included.</p>";
            }
            echo "</div>";
            echo "</div>";
            echo "<div style='flex: 1; text-align: right;'>";
            echo "<p><strong>Room Price:</strong> " . number_format($row['room_price'], 2) . " Php / Night</p>";
            echo "<p><strong>Total Amount:</strong> " . number_format($row['payable_amount'], 2) . " Php</p>";
            echo "<p><strong>Paid Amount:</strong> " . number_format($row['paid_amount'], 2) . " Php </p>";
            echo "<p><strong>Balance:</strong> " . number_format($row['payable_amount'] - $row['paid_amount'], 2) . " Php</p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<div style='display: flex; justify-content: space-between;'>";
            echo "<div style='flex: 1;'>";
            echo "</div>";
            echo "</div>";
            echo "<div style='margin:10px;padding:10px;color:gray; margin-top:5vh;font-weight:normal;'>".$termsandconditions."</div>";
            echo "<div style='padding:10px; margin-top:2vh; color:gray;'>";
            echo "<center><small style='font-weight:normal;'>Please remit payment by the check-out date to avoid any inconvenience.";
            echo "<br>Thank you for choosing Kamantigue. If you have any questions or concerns, please contact our front desk at sales@kamantiguebeachresort.com";
            echo "<br>Sitio Malao, Brgy. Pagkilatan";
            echo "<br>Batangas City, Batangas 4200";
            echo "<br>sales@kamantiguebeachresort.com";
            echo "0977 102 4509</small></center>";
            echo "</div>";
            echo "<div class='modal-footer'>";
            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'  style='margin-right:1vh;'>Close</button>";
            echo "<button type='button' class='btn btn-primary' onclick='printModalContent2()'>Print</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";


            // JavaScript to print the modal content

echo "<script>";
echo "function printModalContent2() {";
echo "var printContents = document.getElementById('printReceiptModal{$row['reservation_id']}').innerHTML;";
echo "var originalContents = document.body.innerHTML;";
echo "document.body.innerHTML = printContents;";
echo "document.querySelector('.modal-footer').style.display = 'none';";  // Hide modal footer
echo "window.print();";
echo "setTimeout(function() {";
echo "  document.body.innerHTML = originalContents;";
echo "  document.querySelector('.modal-footer').style.display = 'block';";  // Restore modal footer after printing
echo "  window.location.reload();";  // Reload the page after printing
echo "}, 1000);";  // Adjust the delay time as needed
echo "}";
echo "</script>";


            // Add more columns as needed
            echo "</tr>";
            }
            } else {
            
            }
            
            if ($servicesResult != '' && $servicesResult->num_rows > 0) {
            while ($servicesRow = $servicesResult->fetch_assoc()) {
            
            $statusClass = getStatusClass($servicesRow['status']);
            
            $totalbalance = '0';
            $gcashdetails = 'Waiting';
            if($servicesRow['reference_number'] != ''){
              $totalbalance = $servicesRow['payable_amount'] - $servicesRow['paid_amount'];
              $gcashdetails = "Gcash Ref#: " . $servicesRow['reference_number'] . "<br>
              Payable Amount: ".$servicesRow['payable_amount']."<br>
              Paid Amount: ".$servicesRow['paid_amount']."<br>
              Balance: ".$totalbalance;
            }
            
            echo "<tr class='$statusClass'>";
            // echo "<td>" . $servicesRow['reservation_id'] . "</td>";
            echo "<td style='color:black;'>Service #: " . $servicesRow['services_number'] . "<br>";
            echo "Service Info: " . $servicesRow['services_description'] . "</td>";
            
            
            echo "<td style='color:black; '>
            Total Amount: " . number_format($servicesRow['payable_amount'],2) . " Php<br>
            Paid Amount: ".number_format($servicesRow['paid_amount'],2)." Php<br>
            Balance: ".number_format(($servicesRow['payable_amount'] - $servicesRow['paid_amount']),2)." Php
            </td>";
            
            
            if($servicesRow['user_id'] != '99999' && $servicesRow['name'] != 'Admin Cashier'){
            if($servicesRow['down_payment'] != '0'){
            
            echo "<td style='color:black;'>Gcash Ref#: ".$servicesRow['reference_number']."<br>Downpayment: ".number_format($servicesRow['down_payment'],2)." Php
            <br><br>Onsite Payment<br>Paid Amount: ".number_format(($servicesRow['paid_amount'] - $servicesRow['down_payment']),2)."</td>";
            }else{
            
            echo "<td style='color:black;'>Gcash Ref#: ".$servicesRow['reference_number']."<br>Paid Amount: ".number_format($servicesRow['paid_amount'],2)." Php</td>";
            }
            }else{

            echo "<td style='color:black;'>Payment Ref#: ".$servicesRow['reference_number']."<br>Downpayment: ".number_format($servicesRow['down_payment'],2)." Php
            <br><br>Onsite Payment<br>Paid Amount: ".number_format(($servicesRow['paid_amount']),2)."</td>";
            }
            
            echo "<td>" . $servicesRow['status'] . "</td>";

            if($servicesRow['user_id'] != '99999' && $servicesRow['name'] != 'Admin Cashier'){
              echo '<td>Online Reservation</td>';
            }else{

              echo '<td>Onsite Reservation</td>';
            }
            echo "<td><a class='btn btn-primary' href='#' data-toggle='modal' data-target='#printReceiptModal{$servicesRow['reservation_id']}'>View Details</a></td>";


            echo "<div class='modal fade' id='printReceiptModal{$servicesRow['reservation_id']}' tabindex='-1' role='dialog' aria-labelledby='printReceiptModalLabel' aria-hidden='true'>";
            echo "<div class='modal-dialog custom-modal-width' role='document' style='width:100vh !important; max-width:100% !important;'>";
            echo "<div class='modal-content' style='width:100vh !important; max-width:100% !important;'>";
            echo "<div class='modal-header' style='width:100vh !important; max-width:100% !important;'>";
            // You can add a header if needed
            // echo "<h5 class='modal-title' id='printReceiptModalLabel'>Print Receipt</h5>";
            echo "</div>";
            echo "<div class='modal-body' style='width:100vh !important; max-width:100% !important;'>";

            echo "<center><h2>Kamantigue Official Receipt</h2></center><br><br>";

            echo "<div style='display: flex; justify-content: space-between;'>";
            echo "<div style='flex: 1;'>";
            echo "<p><strong>Guest Name:</strong> {$servicesRow['name']}</p>";
            echo "<p><strong>Guest Email:</strong> {$servicesRow['email']}</p>";
            echo "</div>";
            echo "<div style='flex: 1; text-align: right;'>";
            echo "<p><strong>Service #:</strong> {$servicesRow['services_number']}</p>";
            echo "<p><strong>Service Description:<br></strong> {$servicesRow['services_description']}</p>";
            echo "</div>";
            echo "</div><hr><br>";

            echo "<div style='display: flex; justify-content: space-between;'>";
            echo "<div style='flex: 1;'>";
            echo "<p><strong>Service Price:</strong> " . number_format($servicesRow['services_price'], 2) . " Php / Night</p>";
            echo "<p><strong>Paid Amount:</strong> " . number_format($servicesRow['paid_amount'], 2) . " Php </p>";
            echo "</div>";
            echo "<div style='text-align: right;'>";
            echo "<p><strong>Reservation Status: {$servicesRow['status']}</strong></p>";
            echo "<p><strong>Total Amount:</strong> " . number_format($servicesRow['payable_amount'], 2) . " Php</p>";
            echo "<p><strong>Remaining Balance:</strong> " . number_format($servicesRow['payable_amount'] - $servicesRow['paid_amount'], 2) . " Php</p>";
            echo "</div>";
            echo "</div>";

            echo "</div>";
                echo "<div style='display: flex; justify-content: space-between;'>";
            echo "<div style='flex: 1;'>";
            echo "</div>";
            echo "</div>";
            echo "<div style='margin:10px;padding:10px;color:gray; margin-top:5vh;font-weight:normal;'>".$termsandconditions."</div>";
            echo "<div style='padding:10px; margin-top:2vh;'>";
            echo "<center><small style='font-weight:normal;'>Please remit payment by the check-out date to avoid any inconvenience.";
            echo "<br>Thank you for choosing Kamantigue. If you have any questions or concerns, please contact our front desk at sales@kamantiguebeachresort.com";
            echo "<br>Sitio Malao, Brgy. Pagkilatan";
            echo "<br>Batangas City, Batangas 4200";
            echo "<br>sales@kamantiguebeachresort.com";
            echo "0977 102 4509</small></center>";
            echo "</div>";
            echo "<div class='modal-footer'>";
            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal' style='margin-right:1vh;'>Close</button>";
            echo "<button type='button' class='btn btn-primary' onclick='printModalContent()'>Print</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

            // JavaScript to print the modal content
echo "<script>";
echo "function printModalContent() {";
echo "var printContents = document.getElementById('printReceiptModal{$servicesRow['reservation_id']}').innerHTML;";
echo "var originalContents = document.body.innerHTML;";
echo "document.body.innerHTML = printContents;";
echo "document.querySelector('.modal-footer').style.display = 'none';";  // Hide modal footer
echo "window.print();";
echo "setTimeout(function() {";
echo "  document.body.innerHTML = originalContents;";
echo "  document.querySelector('.modal-footer').style.display = 'block';";  // Restore modal footer after printing
echo "  window.location.reload();";  // Reload the page after printing
echo "}, 1000);";  // Adjust the delay time as needed
echo "}";
echo "</script>";


            // Add more columns as needed
            echo "</tr>";
            }
            } else {
            // echo "<tr><td colspan='12'>No reservations found.</td></tr>";
            }
            // Close the database connection
            $conn->close();
            ?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
  <!-- The Edit Popup -->
  <div id="editPopup" class="modal">
          <div class="modal-content">
            <span class="close" onclick="closeEditPopup()">&times;</span>
            <div id="editPopupContent">
              <!-- The content of the edit form will be loaded here using AJAX -->
            </div>
          </div>
        </div>
        <!-- The Add Popup -->
        <div id="addPopup" class="modal">
          <div class="modal-content">
            <span class="close" onclick="closeAddPopup()">&times;</span>
            <div id="addPopupContent">
              <!-- The content of the edit form will be loaded here using AJAX -->
            </div>
          </div>
        </div>
        <script>
          function printTable() {
              // Create a new window to print only the table
              var printWindow = window.open('', '_blank');
              printWindow.document.write('<html><head><title>Print Table</title></head><body>');
          
              // Clone the table, set font size and center text on cloned elements
              var clonedTable = document.querySelector('table').cloneNode(true);
              setStyles(clonedTable.querySelectorAll('th, td'), '1vh', 'left');
          
              // Write the modified table to the new window
              printWindow.document.write(clonedTable.outerHTML);
              printWindow.document.write('</body></html>');
              printWindow.document.close();
          
              // Call the print function after the document is closed
              printWindow.print();
          }
          
          function setStyles(elements, fontSize, textAlign) {
              for (var i = 0; i < elements.length; i++) {
                  elements[i].style.fontSize = fontSize;
                  elements[i].style.textAlign = textAlign;
              }
          }
        </script>
        <!-- JavaScript to handle the edit popup -->
        <script>
          function openEditPopup(room_id) {
              // Get the editPopup element
              var editPopup = document.getElementById("editPopup");
          
              // Show the editPopup
              editPopup.style.display = "block";
          
              // Load the edit form content using AJAX
              var editPopupContent = document.getElementById("editPopupContent");
              var xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                      editPopupContent.innerHTML = this.responseText;
                  }
              };
              xhttp.open("GET", "edit_room.php?room_id=" + room_id, true);
              xhttp.send();
          }
  
          
          
          function openAddPopup() {
              // Get the editPopup element
              var addPopup = document.getElementById("addPopup");
          
              // Show the editPopup
              addPopup.style.display = "block";
          
              // Load the edit form content using an iframe
              var addPopupContent = document.getElementById("addPopupContent");
              addPopupContent.innerHTML = '<iframe src="add_room.php" frameborder="0" width="100%" height="500px"></iframe>';
              }
          
          
          
          function closeEditPopup() {
              // Get the editPopup element
              var editPopup = document.getElementById("editPopup");
          
              // Hide the editPopup
              editPopup.style.display = "none";
          }
          
          function closeAddPopup() {
              // Get the editPopup element
              var addPopup = document.getElementById("addPopup");
          
              // Hide the editPopup
              addPopup.style.display = "none";
          }
        </script>
	<script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="assets/js/jquery-3.5.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatables/datatables.min.js"></script>
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/raphael/raphael.min.js"></script>
	<script src="assets/js/script.js"></script>
</body>

</html>