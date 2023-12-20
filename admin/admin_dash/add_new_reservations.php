<?php 
session_start(); 
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit();}
require_once 'config.php';
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error);}

$sql = "SELECT reservations.*, rooms.room_id, rooms.room_number, rooms.description, users.name, users.email
        FROM reservations
        JOIN rooms ON reservations.room_id = rooms.room_id
        JOIN users ON reservations.user_id = users.user_id WHERE reservations.check_out_status = 'waiting' AND reservations.status = 'Approved'";
if(isset($_POST['search_username']) && !empty($_POST['search_username'])){
    $search_username = $_POST['search_username'];
    $sql .= " WHERE users.username LIKE '%$search_username%'";}
$sql .= " ORDER BY reservations.reservation_id DESC";
$result = $conn->query($sql);
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
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>

</head>

<?php
	$messageerror = "";
	//unset($_SESSION['Selected_amenities_names']);
	//unset($_SESSION['Selected_amenities_price']);
	//unset($_SESSION['Selected_amenities_totalprice']);
	//unset($_SESSION['Selected_services_id']);
    if(isset($_POST['save_selected_services']))
    {
        $Selected_amenities_names = '';
        $amenities_price = '';
        $totalprice_amenities = 0;
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
            	$_SESSION['Selected_amenities_names'] = $Selected_amenities_names;
            	$_SESSION['Selected_amenities_price'] = $amenities_price .= $price.' | ';
            	$_SESSION['Selected_amenities_totalprice'] = $totalprice_amenities;
            }

        } else {
            echo "No amenities selected.";
        }
    }

	if (isset($_POST['selected_services_submit'])) {
	    $selectedofadminservices = array();

	    if (isset($_POST['selected_services']) && is_array($_POST['selected_services'])) {
	        foreach ($_POST['selected_services'] as $selectedService) {
	            $selectedofadminservices[] = $selectedService;
	        }
	    }

	    if (!empty($selectedofadminservices)) {
	        $_SESSION['Selected_services_id'] = $selectedofadminservices;
	    }
	}

	if(isset($_POST['submitbooking']) && isset($_POST['name']) && $_POST['name'] != "")
	{
		$validationgo_checker = 0;

		$reference_number = $_POST['refnum'];

		$amenities_totalprice = $_SESSION['Selected_amenities_totalprice'];
		$room_amount = 0;
		$room_name = "";
		$room_id = $_POST['room_id'];
		$sql = "SELECT * FROM rooms WHERE room_id='$room_id' ";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) 
		{
			while ($row = $result->fetch_assoc()) 
			{
				$room_name = $row['description'];
				$room_amount = $row['price'];
			}
		}

		$total_numberofpeople_allowed = 0;
		// Use a regular expression to extract the number inside parentheses
		preg_match('/\((\d+) pax\)/', $room_name, $matchespaxcount);

		// Check if the match was successful
		if (isset($matchespaxcount[1])) {
		    $total_numberofpeople_allowed = $matchespaxcount[1];
		} else {
			$validationgo_checker++;
		}

		$payable_amount = $room_amount + $amenities_totalprice;
		$paid_amount = $payable_amount;
		$down_payment = $payable_amount;

		$number_of_adults = $_POST['num_adults'];

		$number_of_children = 0;
		$number_of_childrenfree = 0;
		$age_of_children = 0;
		$displaychildrens = "";
	    if (isset($_POST['child_ages']) && is_array($_POST['child_ages'])) {
	        $childAges = $_POST['child_ages'];
	        foreach ($childAges as $index => $age) {

	        	if($age > 8){
	            	$number_of_children++; // Adjust the child number if needed
	        	}else{
	        		$number_of_childrenfree++;
	        	}
	            $age_of_children .= $age.' | ';
	            $displaychildrens .= '1 - '.$age.'yrs old<br>';
	        }
	    }

		$from_date = $_POST['arrival_date'];
		$to_date = $_POST['departureDate'];

		$guest_name = $_POST['name'];
		$email_address = $_POST['email'];
		$contact_number = $_POST['contactnumber'];
		$address = $_POST['address'];

		$guest_complete_info = 'Name: '.$guest_name.'<br>Email: '.$email_address.'<br>Contact #: '.$contact_number.'<br>Address: '.$address;

		if(!isset($_SESSION['Selected_amenities_names'])){
			$_SESSION['Selected_amenities_names'] = "";
		}

		if(!isset($_SESSION['Selected_amenities_price'])){
			$_SESSION['Selected_amenities_price'] = "";
		}
		$amenities_names = $_SESSION['Selected_amenities_names'];
		$amenities_prices = $_SESSION['Selected_amenities_price'];

		$services_ids = ''; //meron na to nasa for loop ng selected_services
		$service_description_price = '';
		if (isset($_SESSION['Selected_services_id']) && is_array($_SESSION['Selected_services_id'])) {
		    // Initialize variables
		    $services_ids = implode(',', $_SESSION['Selected_services_id']); // Change the delimiter to comma
		    $service_description_price = '';

		    $sql2 = "SELECT * FROM services WHERE services_number IN ($services_ids)";
		    $result2 = $conn->query($sql2);

		    if ($result2->num_rows > 0) {
		        while ($row2 = $result2->fetch_assoc()) {
		            $service_description_price .= $row2['description'] . ' : <b>' . $row2['price'] . ' Php</b><br>';

		            $services_insertnumber = $row2['services_number'];
		            $services_insertdescription = $row2['description'];
		            $services_insertprice = $row2['price'];

		            $sqls = "INSERT INTO reservations (user_id, services_number, services_description, services_price, status, check_in_date, check_out_date, reference_number, payable_amount, paid_amount, down_payment,guest_information	)
		                    VALUES ('99999','$services_insertnumber', '$services_insertdescription', '$services_insertprice','Approved','$from_date','$to_date','0001','$services_insertprice','$services_insertprice','$services_insertprice','$guest_complete_info')";

		            if ($conn->query($sqls) === TRUE) {
		                // Your insertion logic here
		            }
		        }
		    }
		}

		if($amenities_totalprice == ''){
			$amenities_totalprice = 0;
		}

		$totalnumberof_adultandchild = $number_of_adults + $number_of_children;
		if($totalnumberof_adultandchild > $total_numberofpeople_allowed){
			$validationgo_checker++;
		}

		if($validationgo_checker == 0)
		{
		$totalpayableamount = $room_amount + $amenities_totalprice;
		$sqlsgg = "INSERT INTO reservations (user_id, room_id, Amenities, Amenities_prices, status, check_in_date, check_out_date, reference_number, payable_amount, paid_amount, down_payment, adults, children, Amenities_totalprice, childrenfree,guest_information)
		VALUES ('99999','$room_id','$amenities_names','$amenities_prices','Approved','$from_date','$to_date','0001','$totalpayableamount','$totalpayableamount','$totalpayableamount','$number_of_adults','$number_of_children','$amenities_totalprice','$number_of_childrenfree','$guest_complete_info')";

		if ($conn->query($sqlsgg) === TRUE) 
		{
					// Display the modal with the information
			echo '<div class="modal fade" id="bookingDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">';
			echo '  <div class="modal-dialog modal-lg" role="document">';
			echo '    <div class="modal-content">';
			echo '      <div class="modal-header">';
			echo '        <h5 class="modal-title" id="exampleModalLabel">Booking Receipt</h5>';
			echo '      </div>';
			echo '      <div class="modal-body">';
			echo '        <div class="row">';
			echo '          <div class="col-md-12">';
			echo '          <center><h4><b>Kamantigue Beach Resort</b></h4></center>';
			echo '          <center><p><small><b>Official Receipt</b></small></p></center><hr>';
			echo '          </div>';
			echo '          <div class="col-md-6">';
			echo '            <p><strong>Resort Name</strong></p>';
			echo '            <p>123 Resort Street, Paradise City, Resortland</p>';
			echo '            <p>+123 456 789, info@resort.com</p>';
			echo '          </div>';
			echo '          <div class="col-md-6 text-right">';
			echo '            <p><strong>Date:</strong> ' . date("F j, Y, g:i a") . '</p>';
			echo '            <p><strong>Booking ID:</strong> #123456</p>';
			echo '            <p><strong>Arrival: </strong> '.htmlspecialchars($from_date).'</p>';
			echo '            <p><strong>Departure: </strong> '.htmlspecialchars($to_date).'</p>';
			echo '          </div>';
			echo '        </div>';
			echo '        <hr>';
			echo '        <div class="row">';
			echo '        <div class="col-md-6">';
			echo '              <b><span>Guest Information</span></b><hr>';
			echo '        		<p><strong>Guest Name:</strong> ' . htmlspecialchars($guest_name) . '</p>';
			echo '        		<p><strong>Email:</strong> ' . htmlspecialchars($email_address) . '</p>';
			echo '        		<p><strong>Contact Number:</strong> ' . htmlspecialchars($contact_number) . '</p>';
			echo '        		<p><strong>Address:</strong> ' . htmlspecialchars($address) . '</p>';
			echo '        </div>';

			echo '          <div class="col-md-6 text-right">';
			echo '              <b><span>Head Counts</span></b><hr>';
			echo '        		<p><strong>Adult/s:</strong> ' . htmlspecialchars($number_of_adults) . '</p>';
			echo '        		<p><strong>Child/Children:<br></strong> ' . nl2br($displaychildrens) . '</p>';
			echo '          </div>';
			echo '          </div>';

			echo '        <hr>';
			echo '		  <div class="col-md-12">';
			echo '        	<div class="row">';
			echo '				<div class="col-md-2">';
			echo '                  <b><span>Amenities</span></b><hr>';
									$amenitiescounter = 0;
									$display_amenities_namess = '';
									$selectedAmenitiesNames = $_SESSION['Selected_amenities_names'];

									// Extract names using a different pattern
									if (preg_match_all('/([^\[\]]+)(?:\s*\[\d+\])?(?:\s*\|\s*)?/', $selectedAmenitiesNames, $matches)) {
									    $amenitiesNames = $matches[1];

									    foreach ($amenitiesNames as $name) {
									    	$amenitiescounter++;
									        $display_amenities_namess .= '<p>'.$name . '</p>';
									    }

									    echo nl2br($display_amenities_namess);
									}
			echo '        		</div>';
			echo '  			<div class="col-md-2">';
			echo '                  <b><span>Price</span></b><hr>';
									$amenitiescounter2 = 0;
									$display_amenities_pricess = '';
									$selectedAmenitiesPrices = $_SESSION['Selected_amenities_price'];

									// Extract numbers using a different pattern
									if (preg_match_all('/\b(\d+)\b/', $selectedAmenitiesPrices, $matches)) {
									    $amenitiesPrices = $matches[1];

									    foreach ($amenitiesPrices as $price) {
									    	$amenitiescounter2++;

									    	if($amenitiescounter2 <= $amenitiescounter){
									        	$display_amenities_pricess .= '<p><b>' . $price . ' Php</b></p>';
									    	}
									    }

									    echo nl2br($display_amenities_pricess);
									    
									}
			echo '  			</div>';
			echo '  			<div class="col-md-4">';
			echo '                  <b><span>Services</span></b><hr>';
			echo '                  <span>'.nl2br($service_description_price).'</span>';
			echo '  			</div>';
			echo '  			<div class="col-md-4">';
			echo '                  <b><span>Room Information</span></b><hr>';
			echo '                <span>Room: '.htmlspecialchars($room_name).'</span><br>';
			echo '                <span>Room Price: <b>'.htmlspecialchars($room_amount).' Php</b></span>';
			echo '  			</div>';
			echo '        	</div>';
			echo '        </div>';
			echo '        <hr>';
			echo '        <div class="text-right">';
			echo '          <p>Total Amount: <strong>' . htmlspecialchars($amenities_totalprice) . ' Php</strong> </p>';
			echo '          <p>Paid Amount: <strong>' . htmlspecialchars($paid_amount) . ' Php</strong> </p>';
			echo '          <p>Balance Amount: <strong>' . htmlspecialchars($payable_amount - $paid_amount) . ' Php</strong> </p>';
			echo '        </div>';
			echo '        <button type="button" class="btn btn-primary" id="printButton">PRINT RECEIPT</button>';
			echo '        <a href="add_new_reservations.php" id="donebutton" class="btn btn-success">DONE</a>';
			echo '      </div>';
			echo '    </div>';
			echo '  </div>';
			echo '</div>';
			echo '<script>';
			echo '  $(document).ready(function() {';
			echo '    $("#bookingDetailsModal").modal("show");';
			echo '  });';
			echo '</script>';
		}

		unset($_SESSION['Selected_amenities_names']);
		unset($_SESSION['Selected_amenities_price']);
		unset($_SESSION['Selected_amenities_totalprice']);
		unset($_SESSION['Selected_services_id']);
		$_POST['name'] = "";
		}else{
			$messageerror = "Please check the number of people allowed only in the selected room.";
		}
	}
?>
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
								<li><a href="add_new_reservations.php" class="active"> Add Reservations </a></li>
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
                                <li><a href="transaction_report.php">Transactions Report </a></li>
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
							<h3 class="page-title mt-5">Add Booking</h3> </div>
					</div>
				</div>
				<hr>
				<br>
				<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                <div class='modal-dialog' role='document' style="max-width:100%; width:50%;">
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <label>List of Available Amenities</label>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
  											<?php
                                           $sqlamenity = "SELECT description, price, services_number FROM services WHERE type='Amenities'";
                                            $resultamenity = $conn->query($sqlamenity);

                                            if ($resultamenity->num_rows > 0) 
                                            {
                                                echo "<form action='' method='post'>";
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

                                                    if (isset($_SESSION['Selected_amenities_totalprice']) && $_SESSION['Selected_amenities_totalprice'] != '') 
                                                    {
                                                        $amenitiesArray = explode(' | ', $_SESSION['Selected_amenities_names']);
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
                                                        echo "<td><input type='checkbox' name='selected_services[]' value='{$amenityRow['services_number']}'></td>";
                                                        echo "<td>{$amenityRow['description']}</td>";
                                                        echo "<td>" . number_format($amenityRow['price'], 2) . " Php</td>";
                                                        echo "<td><button style='margin-top:-0.4vh;' type='button' class='btn btn-sm btn-outline-success' onclick='incrementQuantity(this, {$amenityRow['services_number']})'>+</button>&nbsp;";
                                                        echo "<input style='border-radius:1vh; width: 40px; text-align: center;' type='number' name='quantity[{$amenityRow['services_number']}]' value='0' min='0' class='quantity-input'>";
                                                        echo "<button style='margin-top:-0.4vh;' type='button' class='btn btn-sm btn-outline-danger' onclick='decrementQuantity(this, {$amenityRow['services_number']})'>-</button></td>";
                                                    }

                                                    echo "</tr>";
                                                }

                                                echo "</tbody>";
                                                echo "</table>";

                                               	echo "<center><button style='width:40%;' type='submit' name='save_selected_services' class='btn btn-primary'>Save Selected Amenities</button></center>";

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
				<div class='modal fade' id='myModal2' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel2' aria-hidden='true'>
                    <div class='modal-dialog' role='document' style="max-width:100%; width:50%;">
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <label>List of Available Services</label>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                	<span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                            	<form action="" method="post">
							          <table class="table table-striped">
							            <thead>
							              <tr>
							                <th>Select</th>
							                <th>Service</th>
							                <th>Price</th>
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
											        echo '<td><input type="checkbox" name="selected_services[]" value="' . $row['services_number'] . '"';

											        // Check if the services_number is in the session array
											        if (isset($_SESSION['Selected_services_id']) && in_array($row['services_number'], $_SESSION['Selected_services_id'])) {
											            echo ' checked'; // Add the 'checked' attribute if it's selected
											        }

											        echo '></td>';
											        echo '<td>' . $row['description'] . '</td>';
											        echo '<td>' . $row['price'] . '</td>';
											        echo '</tr>';
											    }
							                } 
							                else 
							                {
							                  echo '<tr><td colspan="3">No services available.</td></tr>';
							                }

							                // Close the database connection
							                $conn->close();
							              ?>
							            </tbody>
							          </table>
							          <center>
							          <input type="submit" class="btn btn-primary" value="Save Selected Services" name="selected_services_submit" id="selected_services_submit" style="margin-top:1vh;">
							      </center>
							    </form>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </div>
                </div>

						<form action="" method="post">
								<div class="col-md-12">
                						<div class="row">

                							<div class="col-md-12">
                								<center><h3>Fill Up The Information Needed</h3></center>
                								<center><p style="color:red"><?php if($messageerror != ""){ echo $messageerror; } ?></p></center>
                								<br><br>
                							</div>

                							<div class="col-md-2"></div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Guest Name</label>
													<input class="form-control" type="text" name="name" id="name" placeholder="Complete Name" value="<?php if(isset($_POST['name']) && $_POST['name'] != ''){ echo $_POST['name']; } ?>" required> 
												</div>
												<div class="form-group">
													<label>Email</label>
													<input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="<?php if(isset($_POST['email']) && $_POST['email'] != ''){ echo $_POST['email']; } ?>" required> 
												</div>
												<div class="form-group">
													<label>Contact Number</label>
													<input type="number" class="form-control" name="contactnumber" id="contactnumber" maxlength='11' minlength='11' placeholder="Contact #" value="<?php if(isset($_POST['contactnumber']) && $_POST['contactnumber'] != ''){ echo $_POST['contactnumber']; } ?>" required> 
												</div>
												<div class="form-group">
													<label>Address</label>
													<textarea class="form-control" rows="5" id="address" name="address" placeholder="Complete Address" required><?php if(isset($_POST['address']) && $_POST['address'] != ''){ echo $_POST['address']; } ?></textarea>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Payment Ref # / Sales Invoice #</label>
													<input type="text" class="form-control" name="refnum" id="refnum" placeholder="Payment Reference # / Sales Invoice" value="<?php if(isset($_POST['refnum']) && $_POST['refnum'] != ''){ echo $_POST['refnum']; } ?>" required> 
												</div>

												<div class="form-group">
													<label>Select Room</label>
													<?php
														require 'config.php';

														$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

														if ($conn->connect_error) {
															die("Connection failed: " . $conn->connect_error);
														}

														// Fetch room types from the database
														$sql = "SELECT * FROM rooms WHERE status='1' ";
														$result = $conn->query($sql);

														$roomOptions = "";
														if ($result->num_rows > 0) {
															while ($row = $result->fetch_assoc()) {
																if(isset($_POST['room_id']) && $_POST['room_id'] != ''){

																	if($_POST['room_id'] == $row["room_id"]){

																	$roomOptions .= "<option selected value='" . $row["room_id"] . "'>" . $row["description"] . " [ ". $row['price'] ." Php ]</option>";
																	}else{

																	$roomOptions .= "<option value='" . $row["room_id"] . "'>" . $row["description"] . " [ ". $row['price'] ." Php ]</option>";
																	}
																}else{
																	$roomOptions .= "<option value='" . $row["room_id"] . "'>" . $row["description"] . " [ ". $row['price'] ." Php ]</option>";
																}
															}
														}
														$conn->close();
														?>
													<select class="form-control" id="room_id" name="room_id" required>
														<?php echo $roomOptions; ?>
													</select>
												</div>

												<div class="form-group">
													<label>Number of adults</label>
													<input class="form-control" type="number" name="num_adults" id="num_adults" placeholder="Input Adults Count" value="<?php if(isset($_POST['num_adults']) && $_POST['num_adults'] != ''){ echo $_POST['num_adults']; } ?>" required>
												</div>
												
											    <div class="form-group">
											        <label>Number of Children</label>
											        <div id="childrenContainer"></div>
											        <center>
											        	<br>
											        <button type="button" class="btn btn-secondary" id="addChild" style="width:100%;">Add Child</button>
											    	</center>
											    </div>
											</div>
											<div class="col-md-2">
													<div class="form-group">
														<label>Arrival Date</label>
														<input type="date" class="form-control" name="arrival_date" id="arrivalDate" value="<?php if(isset($_POST['arrival_date']) && $_POST['arrival_date'] != ''){ echo $_POST['arrival_date']; } ?>" required>
													</div>
													<div class="form-group">
														<label>Depature Date</label>
															<input type="date" class="form-control" id="departureDate" name="departureDate" value="<?php if(isset($_POST['departureDate']) && $_POST['departureDate'] != ''){ echo $_POST['departureDate']; } ?>" required> 
													</div>
													<div class="form-group">
														<center><label><b>Additionals ( Optional )</b></label></center>
														<center>
															<div class="form-group">
															<?php 
						                                    if (isset($_SESSION['Selected_amenities_totalprice']) && $_SESSION['Selected_amenities_totalprice'] != '') 
						                                    { 
						                                    ?>
																<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="width:100%;">Update & View Amenities</button>
															<?php }else{ ?>
																<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="width:100%;">Add Amenities</button>
															<?php } ?>
															</div>
														</center>
													</div>
													<div class="form-group">
														<center>
														<div class="form-group">
															<?php 
															if (isset($_SESSION['Selected_services_id']) && is_array($_SESSION['Selected_services_id'])) { ?>
															<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2" style="width:100%;">Update & View Services</button>
															<?php }else{ ?>

															<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2" style="width:100%;">Add Other Services</button>
															<?php } ?>
															</div>
														</center>
													</div>
											</div>
											<div class="col-md-2"></div>
										</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<center>
											<hr>
											<button type="submit" class="btn btn-primary" id="submitbooking" name="submitbooking">Create Booking</button>
										</center>
									</div>
								</div>
						</form>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script>
	  $(document).ready(function() {
	    $("#printButton").on("click", function() {
	      $("#printButton, .btn-success").hide();
	      $("#donebutton, .btn-success").hide();
	      
	      html2canvas($("#bookingDetailsModal .modal-body")[0]).then(function(canvas) {
	        var imageData = canvas.toDataURL();
	        var printWindow = window.open("", "_blank");
	        
	        printWindow.document.write("<html><head><title>Booking Receipt</title></head><body>",
	          "<img src=\"" + imageData + "\">", "</body></html>");
	        
	        printWindow.document.close();
	        
	        setTimeout(function() {
	          printWindow.print();
	          $("#printButton, .btn-success").show();
	          $("#donebutton, .btn-success").show();
	        }, 1000); // Adjust the delay in milliseconds (e.g., 1000 for 1 second)
	      });
	    });
	  });
	</script>

	<script>
	    $(document).ready(function () {
	        // Counter to track the number of added child fields
	        var childCounter = 0;

	        // Event handler for the "Add Child" button
	        $('#addChild').on('click', function () {
	            childCounter++;

	            // Create a new set of input fields for child number and age
	            var childHtml = '<div class="childFields">' +
	                                '<label style="margin-top:0.5vh;">Child ' + childCounter + ' - Age</label>' +
	                                '<input type="number" class="form-control" name="child_ages[]" placeholder="Input Child Age" required>' +
	                            '</div>';

	            // Append the new fields to the container
	            $('#childrenContainer').append(childHtml);
	        });
	    });
	</script>
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