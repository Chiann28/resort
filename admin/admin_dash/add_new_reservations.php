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
        JOIN users ON reservations.user_id = users.user_id WHERE reservations.check_out_status = 'waiting' AND reservations.status = 'Approved'";

if(isset($_POST['search_username']) && !empty($_POST['search_username'])){
    $search_username = $_POST['search_username'];
    $sql .= " WHERE users.username LIKE '%$search_username%'";
}

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
						<li class="active"> <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a> </li>
						<li class="list-divider"></li>
						<li class="submenu"> <a href="#"><i class="fas fa-suitcase"></i> <span> Booking </span> <span class="menu-arrow"></span></a>
							<ul class="submenu_class" style="display: none;">
								<li><a href="reservation_list.php"> All Reservations </a></li>
								<li><a href="edit-booking.html"> Rescheduled Reservations </a></li>
								<li><a href="add-booking.html"> Add Reservations </a></li>
								<li><a href="checkout_list.php"> Check out </a></li>
							</ul>
						</li>
						<li class="submenu"> <a href="#"><i class="fas fa-user"></i> <span> Customers </span> <span class="menu-arrow"></span></a>
							<ul class="submenu_class" style="display: none;">
								<li><a href="admin_users.php"> All customers </a></li>
								<li><a href="edit-customer.html"> Edit Customer </a></li>
								<li><a href="add-customer.html"> Add Customer </a></li>
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
								<li><a href="expense-reports.html">Expense Report </a></li>
								<li><a href="invoice-reports.html">Invoice Report </a></li>
							</ul>
						</li>
                        <li> <a href="calendar.html"><i class="fas fa-calendar-alt"></i> <span>Calendar</span></a> </li>
						<li> <a href="settings.html"><i class="fas fa-cog"></i> <span>Settings</span></a> </li>
						
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
				<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                <div class='modal-dialog' role='document' style="max-width:100%; width:50%;">
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                           
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            
                                            <hr>
                                            <label>List of Available Amenities</label>
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
													$totalAmenitiesPrice = 0;
													$Amenities_IDS = '';

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
				<div class="row">
					<div class="col-lg-12">
						<form>
							<div class="row formtype">
								<div class="col-md-4">
									<div class="form-group">
										<label>Name</label>
										<input class="form-control" type="text"> </div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Room type</label>
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
													$roomOptions .= "<option value='" . $row["room_id"] . "'>" . $row["description"] . "</option>";
												}
											}

											// Close the database connection
											$conn->close();
											?>
										<select class="form-control" id="sel1" name="room_id">
										
											<?php echo $roomOptions; ?>
										</select>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Arrival Date</label>
										
											<input type="date" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Number of adults</label>
										<input class="form-control" type="number">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Number of child</label>
											<input type="number" class="form-control"> 
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Depature Date</label>
										
											<input type="date" class="form-control"> 
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Child Age</label>
										<input type="number" class="form-control" > </div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Email</label>
										<input type="email" class="form-control" > </div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Address</label>
										<textarea class="form-control" rows="5" id="comment" name="text"></textarea>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Amenities</button>
									</div>
								</div>
								
							</div>
						</form>
					</div>
					
				</div>
				<button type="button" class="btn btn-primary buttonedit1">Create Booking</button>
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