<?php
session_start();

// Check if the user is logged in as an admin (You may implement your own authentication logic)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html"); // Redirect to the login page if not logged in as admin
    exit();
}

require_once 'config.php';

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Initialize variables
$promoCode = "";
$promoDiscount = "";
$editMode = false;
$promoId = 0;

// Handle Add Promo Code
if (isset($_POST['add_promo'])) {
    $promoCode = $_POST['promo_code'];
    $promoDiscount = $_POST['promo_discount'];

    // Validate input (You can add more validation as needed)
    if (!empty($promoCode) && is_numeric($promoDiscount)) {
        // Insert the new promo code into the database
        $insertQuery = "INSERT INTO promocode (promo_code, promo_discount) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("si", $promoCode, $promoDiscount);
        if ($stmt->execute()) {
            // Redirect or display a success message
            header("Location: manage_promocode.php");
            exit();
        } else {
            // Handle the case where the insertion fails
            $error = "Error adding promo code.";
        }
    } else {
        // Handle invalid input
        $error = "Invalid input. Please check the promo code and discount.";
    }
}

// Handle Edit Promo Code
if (isset($_POST['edit_promo'])) {
    $promoId = $_POST['promo_id'];
    $promoCode = $_POST['promo_code'];
    $promoDiscount = $_POST['promo_discount'];

    // Validate input (You can add more validation as needed)
    if (!empty($promoCode) && is_numeric($promoDiscount)) {
        // Update the promo code in the database
        $updateQuery = "UPDATE promocode SET promo_code = ?, promo_discount = ? WHERE promo_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sii", $promoCode, $promoDiscount, $promoId);
        if ($stmt->execute()) {
            // Redirect or display a success message
            header("Location: manage_promocode.php");
            exit();
        } else {
            // Handle the case where the update fails
            $error = "Error updating promo code.";
        }
    } else {
        // Handle invalid input
        $error = "Invalid input. Please check the promo code and discount.";
    }
}

// Handle Delete Promo Code
if (isset($_GET['delete_id'])) {
    $promoId = $_GET['delete_id'];

    // Delete the promo code from the database
    $deleteQuery = "DELETE FROM promocode WHERE promo_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $promoId);
    if ($stmt->execute()) {
        // Redirect or display a success message
        header("Location: manage_promocode.php");
        exit();
    } else {
        // Handle the case where the deletion fails
        $error = "Error deleting promo code.";
    }
}

// Fetch all promo codes from the database
$promoCodesQuery = "SELECT * FROM promocode";
$promoCodesResult = $conn->query($promoCodesQuery);

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
								<li><a href="reservation_list.php"> All Reservations </a></li>
								<li><a href="reschedule.php"> Rescheduled Reservations </a></li>
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
								<li><a href="manage_promocode.php" class="active"> Promo Codes </a></li>
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
								<h4 class="card-title float-left mt-2">Promo Codes</h4>
                                <a onclick='openAddPopup()' class="btn btn-primary float-right veiwbutton ">Add Promo Code</a>
                            </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="card card-table">
							<div class="card-body booking_card">
                            <?php if (isset($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <!-- Form for adding/editing promo codes -->
    <form method="post">
        <input type="hidden" name="promo_id" value="<?php echo $promoId; ?>">
        <label for="promo_code">Promo Code:</label>
        <input type="text" name="promo_code" value="<?php echo $promoCode; ?>" required>
        <label for="promo_discount">Discount (%):</label>
        <input type="number" name="promo_discount" value="<?php echo $promoDiscount; ?>" required>
        <?php if ($editMode) { ?>
            <button type="submit" name="edit_promo">Edit Promo Code</button>
        <?php } else { ?>
            <button type="submit" name="add_promo" style="margin-top: 10px;">Add Promo Code</button>
        <?php } ?>
    </form>

    <!-- List of existing promo codes with edit and delete links -->
    <table>
        <thead>
            <tr>
                <th>Promo Code</th>
                <th>Discount (%)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $promoCodesResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['promo_code']; ?></td>
                    <td><?php echo $row['promo_discount']; ?></td>
                    <td>
                        <a class="btn btn-success" href="manage_promocode.php?edit_id=<?php echo $row['promo_id']; ?>">Edit</a>
                        <a href="manage_promocode.php?delete_id=<?php echo $row['promo_id']; ?>" onclick="return confirm('Are you sure you want to delete this promo code?')"><i class="bi bi-trash3-fill"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div> 

<!-- JavaScript to handle the edit popup -->

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