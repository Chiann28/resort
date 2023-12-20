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
	
		
		td{
			color: black; 
			border: 1px solid #dddddd; 
			text-align: left; 
			padding: 8px
		}

		table{
			width:90%;

		}
		th{
			background-color:#009688;
			padding:10px;
		}

		/* The Edit and Add Popup Modals */
.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
	width:50%;
	margin-top: 120px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
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
								<li><a href="checkout_list.php" class="active"> Check out </a></li>
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
							<div class="mt-5">
								<h4 class="card-title float-left mt-2">All reservations</h4>

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
            <!-- <th>Reservation ID</th> -->
            <th>Room Details</th>
            <th>Guest Details</th>
            <th>Check-in Date</th>
            <th>Check-out Date</th>
            <th>Departure</th>
          
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

        if (!isset($result->num_rows) || $result->num_rows == 0) {
            echo "<tr><td colspan='12'>No ongoing reservations found.</td></tr>";
        }
        // Loop through the query result and display the reservation details in each row
        if (isset($result->num_rows) && $result->num_rows > 0) {
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
                
                echo "<tr class='approved'>";
                // echo "<td>" . $row['reservation_id'] . "</td>";
                echo "<td style='color:black; font-weight:bold;'>Room ID: " . $row['room_id'] . "";
                echo "<br>Room #: " . $row['room_number'] . "";
                echo "<br>Room Details: " . $row['description'] . "<br><br>"; ?>

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
                 <?php  "</td>";

                echo "<td style='color:black; font-weight:bold;'>Guest #:" . $row['user_id'] . "";
                echo "<br>Guest Name: " . $row['name'] . "";
                echo "<br>Guest Email: " . $row['email'] . "</td>";

                echo "<td>" . $row['check_in_date'] . "</td>";
                echo "<td style='color:black; font-weight:bold;'>" . $row['check_out_date'] . "</td>";echo "<td><a class='btn btn-primary' href='check_out_reservations.php?reservation_id=" . $row['reservation_id'] . "&email=".$row['email']."&name=".$row['name']."' onclick='return confirmCheckOut()'>Check Out</a></td>";

                // Add more columns as needed
                echo "</tr>";
            }
        } else {
            
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
    <script>
function confirmCheckOut() {
    return confirm("Are you sure you want to check out this guest?");
}
</script>

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