<?php
// Start the session
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit();
}



require_once 'config.php';

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$sql = "SELECT reservations.*, rooms.room_id, rooms.room_number, rooms.description, users.name, users.email
        FROM reservations
        JOIN rooms ON reservations.room_id = rooms.room_id
        JOIN users ON reservations.user_id = users.user_id
        WHERE reservations.status = 'Rejected'";

if(isset($_POST['search_username']) && !empty($_POST['search_username'])){
    $search_username = $_POST['search_username'];
    $sql .= " WHERE users.username LIKE '%$search_username%'";
}

$sql .= " ORDER BY reservations.reservation_id DESC";

$result = $conn->query($sql);

$servicesSQL = "SELECT reservations.*, services_number, services_description, services_price, reservation_id, status, reference_number, users.name, users.email
                FROM reservations
                JOIN users ON reservations.user_id = users.user_id
                WHERE
                 services_number IS NOT NULL
                AND services_description IS NOT NULL
                AND services_price IS NOT NULL
                AND reservations.status = 'Rejected'";

if(isset($_POST['search_username']) && !empty($_POST['search_username'])){
    $search_username = $_POST['search_username'];
    $servicesSQL .= " AND users.username LIKE '%$search_username%'";
}

$servicesSQL .= " ORDER BY reservations.services_number DESC";

$servicesResult = $conn->query($servicesSQL);

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
		td{
			color: black; 
			border: 1px solid #dddddd; 
			text-align: left; 
			padding: 8px
		}
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
			<ul class="nav user-menu">
				<li class="nav-item dropdown noti-dropdown">
					<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <i class="fe fe-bell"></i> <span class="badge badge-pill">3</span> </a>
					<div class="dropdown-menu notifications">
						<div class="topnav-dropdown-header"> <span class="notification-title">Notifications</span> <a href="javascript:void(0)" class="clear-noti"> Clear All </a> </div>
						<div class="noti-content">
							<ul class="notification-list">
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="admin.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Sample</span> Sample <span class="noti-title">sample</span></p>
												<p class="noti-time"><span class="notification-time">4 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="admin.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">International Software
													Inc</span> has sent you a invoice in the amount of <span class="noti-title">$218</span></p>
												<p class="noti-time"><span class="notification-time">6 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-17.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Chein Ian</span> sent a cancellation request <span class="noti-title">Barkada Room 1</span></p>
												<p class="noti-time"><span class="notification-time">8 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-13.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Guest 1
												</span> has checked out <span class="noti-title">
												</span></p>
												<p class="noti-time"><span class="notification-time">12 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>
						<div class="topnav-dropdown-footer"> <a href="#">View all Notifications</a> </div>
					</div>
				</li>
				<li class="nav-item dropdown has-arrow">
					<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <span class="user-img"><img class="rounded-circle" src="admin.jpg" width="31" alt="kamantigue"></span> </a>
					<div class="dropdown-menu">
						<div class="user-header">
							<div class="avatar avatar-sm"> <img src="admin.jpg" alt="User Image" class="avatar-img rounded-circle"> </div>
							<div class="user-text">
								<h6>Admin</h6>
								<p class="text-muted mb-0">Administrator</p>
							</div>
							</div>  <a class="dropdown-item" href="logout.php">Logout</a> </div>
				</li>
			</ul>
			
		</div>
		<div class="sidebar" id="sidebar">
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li class="submen"> <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a> </li>
						<li class="list-divider"></li>
						<li class="submenu"> <a href="#"><i class="fas fa-suitcase"></i> <span> Booking </span> <span class="menu-arrow"></span></a>
							<ul class="submenu_class" style="display: none;">
								<li><a href="reservation_list.php" class="active"> All Reservations </a></li>
								<li><a href="reschedule.php"> Rescheduled Reservations </a></li>
								<li><a href="cancelled_list.php"> Cancelled Reservations </a></li>
								<li><a href="add_new_reservations.php"> Add Reservations </a></li>
								<li><a href="checkout_list.php"> Check out </a></li>
							</ul>
						</li>
						<li class="submenu"> <a href="#"><i class="fas fa-user"></i> <span> Customers </span> <span class="menu-arrow"></span></a>
							<ul class="submenu_class" style="display: none;">
								<li><a href="admin_users.php"> All customers </a></li>
								<li><a href="add_customer.php"> Add Customer </a></li>
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
							<div class="mt-5">
								<h4 class="card-title float-left mt-2">Cancelled reservations</h4>
								
                                <a href="add-booking.html" class="btn btn-primary float-right veiwbutton ">Add Booking</a>
                            </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="card card-table">
							<div class="card-body booking_card">
								<div class="table-responsive">
									<table>
										<tr>
											<th>Room/Service Details</th>
											<th>Amenities Details</th>
											<th>Guest Details</th>
											<th>Date Details</th>
											<th>Amount Details</th>
											<th>Payment Details</th>
											<th style='text-align:center;'>Action</th>
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
								
										if ($result->num_rows == 0 && $servicesResult->num_rows == 0) {
											echo "<tr><td colspan='12'>No reservations found.</td></tr>";
										}
										// Loop through the query result and display the reservation details in each row
										if ($result->num_rows > 0) {
											while ($row = $result->fetch_assoc()) {
											  $Amenities_IDS = $row['Amenities'];
											$totalAmenitiesPrice = $row['Amenities_totalprice'];
												$statusClass = getStatusClass($row['status']);
								
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
												
												echo "<td>Room ID: " . $row['room_id'] . "<br>";
												echo "Room #: " . $row['room_number'] . "<br>";
												echo "Description: <br>" . $row['description'] . "<br>";
												echo "Adult Count: " . $row['adults'] . "<br>";
												echo "Child Count: " . $row['children'] . "</td>";

								
												echo "<td>"; 

                                                ?>

                                                <div class="modal fade" id="rescheduleModal<?php echo $row['reservation_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="rescheduleModalLabel">Reschedule Reservation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="reschedule_reservation.php" method="post">
                                                                <input type="hidden" name="reservation_id" value="<?php echo $row['reservation_id']; ?>" />
                                                                <div class="form-group">
                                                                    <label for="new_check_in_date">New Check-in Date:</label>
                                                                    <input type="date" class="form-control" id="new_check_in_date" name="new_check_in_date" required />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="new_check_out_date">New Check-out Date:</label>
                                                                    <input type="date" class="form-control" id="new_check_out_date" name="new_check_out_date" required />
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Reschedule</button>
                                                            </form>
                                                        </div>
                                                
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                
                                                <?php
								
											if($totalAmenitiesPrice != '' && $totalAmenitiesPrice != '0')
											{
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
											  }else{
								
																				echo "No amenities found.";
											  }
												echo "</td>";
								
												echo "<td style='color:black'>Guest ID: " . $row['user_id'] . "";
												echo "<br>Guest Name: " . $row['name'] . "";
												echo "<br>Guest Email: " . $row['email'] . "</td>";
								
												echo "<td>Reservation Date: " . $row['submitted_date'] . "";
												echo "<br>Date IN: " . $row['check_in_date'] . "";
												echo "<br>Date OUT: " . $row['check_out_date'] . "</td>";
								
												
												echo "<td style='color:black; '>
												Total Amount: " . number_format($row['payable_amount'],2) . " Php<br>
												Paid Amount: ".number_format($row['paid_amount'],2)." Php<br>
												Remaining Bal: ".number_format(($row['payable_amount'] - $row['paid_amount']),2)." Php
												"; 
								
												if($row['down_payment'] != '0'){
								
												echo "<td style='color:black;'>Gcash Ref#: ".$row['reference_number']."<br>Downpayment: ".number_format($row['down_payment'],2)." Php
												<br><br>Onsite Payment<br>Paid Amount: ".number_format(($row['paid_amount'] - $row['down_payment']),2)."</td>";
												}else{
								
												echo "<td style='color:black;'>Gcash Ref#: ".$row['reference_number']."<br>Paid Amount: ".number_format($row['paid_amount'],2)." Php</td>";
												}
								
								
												echo "<td>
												<center>".$row['status']."<br><br>";
								
												if($row['status'] != 'Approved' && $row['status'] != 'Rejected'){
								
												  echo "<a class='btn btn-success' style='width:100px;' href='edit_reservation_status.php?reservation_id=" . $row['reservation_id'] . "&status=Approved&email=".$row['email']."&name=".$row['name']."'>Confirm</a>";
												  echo "<br><br><a class='btn btn-warning' style='width:100px;' href='edit_reservation_status.php?reservation_id=" . $row['reservation_id'] . "&status=Rejected'>Cancel</a>";
												  
												}

                                                if($row['status'] == 'Rejected'){
								
                                                    // echo "<a class='btn btn-success' style='width:120px;' href='edit_reservation_status.php?reservation_id=" . $row['reservation_id'] . "&status=Approved&email=".$row['email']."&name=".$row['name']."'>Reschedule</a>";

                                                    echo "<button type='button' class='btn btn-info' data-toggle='modal' data-target='#rescheduleModal" . $row['reservation_id'] . "'>Reschedule</button><br>";

                                                    
                                                  }
								
												echo "</td>";
												// Add more columns as needed
												echo "</tr>";
											}

                                           
										} else {
											
										}
								
										if ($servicesResult->num_rows > 0) {
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
												echo "<td style='color:black;'>Service ID: " . $servicesRow['services_number'] . "";
												echo "<br>Description: <br>" . $servicesRow['services_description'] . "</td>";
												echo "<td>Not Applicable</td>";
								
												echo "<td style='color:black'>Guest ID: " . $servicesRow['user_id'] . "";
												echo "<br>Guest Name: " . $servicesRow['name'] . "";
												echo "<br>Guest Email: " . $servicesRow['email'] . "</td>";
								
												echo "<td>Reservation Date: " . $servicesRow['submitted_date'] ."</td>";
								
												echo "<td style='color:black; '>
												Total Amount: " . number_format($servicesRow['payable_amount'],2) . " Php<br>
												Paid Amount: ".number_format($servicesRow['paid_amount'],2)." Php<br>
												Remaining Bal: ".number_format(($servicesRow['payable_amount'] - $servicesRow['paid_amount']),2)." Php
												"; 
								
												if($servicesRow['down_payment'] != '0'){
								
												echo "<td style='color:black;'>Gcash Ref#: ".$servicesRow['reference_number']."<br>Downpayment: ".number_format($servicesRow['down_payment'],2)." Php
												<br><br>Onsite Payment<br>Paid Amount: ".number_format(($servicesRow['paid_amount'] - $servicesRow['down_payment']),2)."</td>";
												}else{
								
												echo "<td style='color:black;'>Gcash Ref#: ".$servicesRow['reference_number']."<br>Paid Amount: ".number_format($servicesRow['paid_amount'],2)." Php</td>";
												}
								
								
												echo "<td>
												<center>".$servicesRow['status']."<br><br>";
								
												if($servicesRow['status'] != 'Approved' && $servicesRow['status'] != 'Rejected'){
								
												  echo "<a class='btn btn-success' style='width:100px;' href='edit_reservation_status.php?reservation_id=" . $servicesRow['reservation_id'] . "&status=Approved&email=".$servicesRow['email']."&name=".$servicesRow['name']."'>Confirm</a>";
												  echo "<br><br><a class='btn btn-warning' style='width:100px;' href='edit_reservation_status.php?reservation_id=" . $servicesRow['reservation_id'] . "&status=Rejected'>Cancel</a>";
												  echo "<br><br><a class='btn btn-delete' style='background-color:red; color:white; width:100px;' href='delete_reservation.php?reservation_id=" . $servicesRow['reservation_id']."'>Delete</a></center>";
												}
								
												echo "</td>";
												echo "</tr>";
											}
										} else {
											// echo "<tr><td colspan='12'>No reservations found.</td></tr>";
										}
										// Close the database connection
										// $conn->close();
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

    // function openEditPopup(room_id) {
    //     // Get the editPopup element (the iframe)
    //     var editPopupIframe = document.getElementById("editPopupIframe");

    //     // Show the editPopup (you may need to adjust the CSS accordingly)
    //     editPopupIframe.style.display = "block";

    //     // Load the edit form content using AJAX
    //     var xhttp = new XMLHttpRequest();
    //     xhttp.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //             // Set the content of the iframe to the AJAX response
    //             editPopupIframe.contentDocument.documentElement.innerHTML = this.responseText;
    //         }
    //     };
    //     xhttp.open("GET", "edit_room.php?room_id=" + room_id, true);
    //     xhttp.send();
    // }


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