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

// Fetch all user data from the database

$sql = "SELECT * from rooms";
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
                                <li><a href="room_report.php" class="active">Room Report </a></li>
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
								<h4 class="card-title float-left mt-2">Room Report</h4>
                                <button onclick="printTable()" style="margin-left:20px; margin-top:7px; background-color:gray; color:white;">Print Report</button>
                            </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="card card-table">
							<div class="card-body booking_card">
								<div class="table-responsive">
									<table style="width:100%;">
                                    <tr>
            <th>Room ID</th>
            <th>Room Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Status</th> 
            <th>Room Logs ( IN & OUT )</th>

          
            <!-- Add more table headers based on your database columns -->
        </tr>
      </thead>
        <?php
         // Loop through the query result and display the room details in each row
         while ($list_rooms_row = $result->fetch_assoc()) {
            echo "<tr class='" . ($list_rooms_row['status'] == 1 ? 'visible-room' : 'hidden-room') . "'>";
            echo "<td style='color:black;'>" . $list_rooms_row['room_id'] . "</td>";
            echo "<td>" . $list_rooms_row['room_number'] . "</td>";
            echo "<td>" . $list_rooms_row['description'] . "</td>";
            echo "<td>" . number_format($list_rooms_row['price'],2) . " Php</td>";
            echo "<td>" . ($list_rooms_row['status'] == 1 ? 'Available' : 'Not Available')  . "</td>";
                        echo "<td>";
            
            $roomersid=$list_rooms_row['room_id'];
              $sql33 = "SELECT reservations.*, rooms.room_id, rooms.room_number, rooms.description, users.name, users.email
                      FROM reservations
                      JOIN rooms ON reservations.room_id = rooms.room_id
                      JOIN users ON reservations.user_id = users.user_id WHERE reservations.status = 'Approved' AND reservations.check_out_status <> 'waiting' AND reservations.room_id = '$roomersid'";


              $sql33 .= " ORDER BY reservations.reservation_id DESC";

              $result33 = $conn->query($sql33);
        if (isset($result33->num_rows) && $result33->num_rows > 0) {
            while ($row33 = $result33->fetch_assoc()) {
            ?>
                <p><?php echo $row33['check_in_date']; ?> To <?php echo $row33['check_out_date']; ?><br></p>
            <?php
          }
        }
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</tr>";
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