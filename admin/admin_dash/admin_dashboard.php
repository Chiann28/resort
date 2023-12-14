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
	<link rel="stylesheet" href="assets/css/style.css"> </head>

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
					<div class="row">
						<div class="col-sm-12 mt-5">
							<h3 class="page-title mt-3">Good Morning Admin!</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item active">Dashboard</li>
							</ul>
						</div>
					</div>
				</div>
                
				<div class="row">
				<div class="col-xl-3 col-sm-6 col-12">
    <div class="card board1 fill">
        <div class="card-body">
            <div class="dash-widget-header">
                <div>
                    <?php
                    // Replace with your actual database credentials
                    require_once 'config.php';

                    // Create connection
                    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch total reservations from the database
                    $query = "SELECT COUNT(*) AS total_reservations FROM reservations";
                    $result = $conn->query($query);

                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalReservations = $row['total_reservations'];

                        // Output the total reservations as part of the HTML
                        echo '<h3 class="card_widget_header">' . $totalReservations . '</h3>';

                        // Close the database connection
                        $conn->close();
                    } else {
                        // Handle the query error
                        echo '<h3 class="card_widget_header">Error fetching total reservations</h3>';
                    }
                    ?>
                    <h6 class="text-muted">Total Reservations</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-sm-6 col-12">
    <div class="card board1 fill">
        <div class="card-body">
            <div class="dash-widget-header">
                <div>
                    <?php
                    // Replace with your actual database credentials
                    require_once 'config.php';

                    // Create connection
                    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch available rooms from the database where status is 1
                    $query = "SELECT COUNT(*) AS total_available_rooms FROM rooms WHERE status = 1";
                    $result = $conn->query($query);

                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalAvailableRooms = $row['total_available_rooms'];

                        // Output the total available rooms as part of the HTML
                        echo '<h3 class="card_widget_header">' . $totalAvailableRooms . '</h3>';

                        // Close the database connection
                        $conn->close();
                    } else {
                        // Handle the query error
                        echo '<h3 class="card_widget_header">Error fetching available rooms</h3>';
                    }
                    ?>
                    <h6 class="text-muted">Available Rooms</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-sm-6 col-12">
    <div class="card board1 fill">
        <div class="card-body">
            <div class="dash-widget-header">
                <div>
                    <?php
                    // Replace with your actual database credentials
                    require_once 'config.php';

                    // Create connection
                    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch total inquiries from the database
                    $query = "SELECT COUNT(*) AS total_inquiries FROM inquiries";
                    $result = $conn->query($query);

                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalInquiries = $row['total_inquiries'];

                        // Output the total inquiries as part of the HTML
                        echo '<h3 class="card_widget_header">' . $totalInquiries . '</h3>';

                        // Close the database connection
                        $conn->close();
                    } else {
                        // Handle the query error
                        echo '<h3 class="card_widget_header">Error fetching total inquiries</h3>';
                    }
                    ?>
                    <h6 class="text-muted">Inquiry</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="12" y1="18" x2="12" y2="12"></line>
                            <line x1="9" y1="15" x2="15" y2="15"></line>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-sm-6 col-12">
    <div class="card board1 fill">
        <div class="card-body">
            <div class="dash-widget-header">
                <div>
                    <?php
                    // Replace with your actual database credentials
                    require_once 'config.php';

                    // Create connection
                    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch total amount_paid from the reservations table
                    $query = "SELECT SUM(paid_amount) AS total_sales FROM reservations";
                    $result = $conn->query($query);

                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalSales = $row['total_sales'];

                        // Output the total sales as part of the HTML
                        echo '<h3 class="card_widget_header">₱ ' . $totalSales . '</h3>';

                        // Close the database connection
                        $conn->close();
                    } else {
                        // Handle the query error
                        echo '<h3 class="card_widget_header">Error fetching total sales</h3>';
                    }
                    ?>
                    <h6 class="text-muted">Total Sales</h6>
                </div>
                <div class="ml-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
				

	<div class="row">
    <div class="col-md-12 d-flex">
        <div class="card card-table flex-fill">
            <div class="card-header">
                <h4 class="card-title float-left mt-2">Reservations</h4>
                <button type="button" class="btn btn-primary float-right veiwbutton">View All</button>
            </div>
            <div class="card-body">
                <?php
                // Create connection
                $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch all reservations from the reservations table
                $query = "SELECT r.reservation_id, u.name, u.email, r.check_in_date, r.check_out_date, r.paid_amount, r.status
                            FROM reservations r
                            INNER JOIN users u ON r.user_id = u.user_id";
                $result = $conn->query($query);

                if ($result) {
                    echo '<div class="table-responsive">
                            <table class="table table-hover table-center">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Name</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        
                                        <th class="text-right">Amount Paid</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>
                                <td class="text-nowrap">' . $row['reservation_id'] . '</td>
                                <td>
                                    <div class="client">
                                        <div class="client-info">
                                            <h4>' . $row['name'] . '</h4>
                                            <small>' . $row['email'] . '</small>
                                        </div>
                                    </div>
                                </td>
                                <td>' . $row['check_in_date'] . '</td>
                                <td>' . $row['check_out_date'] . '</td>
                                
                                <td class="text-right">
                                    <div>' . $row['paid_amount'] . '</div>
                                </td>
                                <td class="text-center"> <span class="badge badge-pill bg-success inv-badge">' . $row['status'] . '</span> </td>
                            </tr>';
                    }

                    echo '</tbody>
                        </table>
                    </div>';

                    // Close the database connection
                    $conn->close();
                } else {
                    // Handle the query error
                    echo '<p>Error fetching reservations</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

			</div>
		</div>
	</div>
	<script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="assets/js/jquery-3.5.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/raphael/raphael.min.js"></script>
	<script src="assets/plugins/morris/morris.min.js"></script>
	<script src="assets/js/chart.morris.js"></script>
	<script src="assets/js/script.js"></script>
</body>

</html>