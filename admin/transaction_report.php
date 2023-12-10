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
  
  // Query the database to fetch data
  // $sql = "SELECT reservations.*, rooms.room_id, rooms.room_number, rooms.description, users.name, users.email
  //         FROM reservations
  //         JOIN rooms ON reservations.room_id = rooms.room_id
  //         JOIN users ON reservations.user_id = users.user_id";
  
  // $sql = "SELECT rooms.room_id, rooms.room_number, rooms.description, 
  //                COALESCE(reservations.status, 'Available') AS status,
  //                users.name, users.email
  //         FROM rooms
  //         LEFT JOIN reservations ON rooms.room_id = reservations.room_id
  //         LEFT JOIN users ON reservations.user_id = users.user_id";
  
  $sql = "SELECT reservations.*,rooms.price as room_price, rooms.room_id, rooms.room_number, rooms.description, users.name, users.email
          FROM reservations
          JOIN rooms ON reservations.room_id = rooms.room_id
          JOIN users ON reservations.user_id = users.user_id";
  
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
                  AND services_price IS NOT NULL";
  
  if(isset($_POST['search_username']) && !empty($_POST['search_username'])){
      $search_username = $_POST['search_username'];
      $servicesSQL .= " AND users.username LIKE '%$search_username%'";
  }
  
  $servicesSQL .= " ORDER BY reservations.services_number DESC";
  
  $servicesResult = $conn->query($servicesSQL);
  
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Hotel Management and Reservation System</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- local css -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet"> 

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
    /* Custom CSS */
.custom-modal-width {
    max-width: 800px; /* Set your desired width */
    width: 100%;
    margin: auto;
}

/* Apply the custom style to the modal */
.modal-dialog {
    width: 100%;
    max-width: 800px; /* Set the same width as max-width above */
    margin: 1.75rem auto;
}

/* Prevent modal content from overflowing the modal */
.modal-content {
    width: 100%;
    max-width: 100%;
}

/* Responsive styles for smaller screens */
@media (min-width: 576px) {
    .modal-dialog {
        max-width: 800px; /* Adjust as needed for larger screens */
    }
}

.filter-transaction{
  margin-top:10px;
  text-align: center;
  margin-left: 1400px;
}

    </style>
  </head>
  <body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
      <div class="side-header">
        <h3>K<span>amantigue</span></h3>
      </div>
      <div class="side-content">
        <div class="profile">
          <div class="profile-img bg-img" style="background-image: url(img/3.jpeg)"></div>
          <h4>Admin</h4>
          <small>admin</small>
        </div>
        <div class="side-menu">
          <ul>
            <li>
              <a href="admin_dashboard.php" >
              <span class="las la-home"></span>
              <small>Dashboard</small>
              </a>
            </li>
            <li>
              <a href="room_list.php" >
              <span class="las la-boxes"></span>
              <small>Room List</small>
              </a>
            </li>
            <li>
              <a href="services_list.php" >
              <span class="lab la-servicestack"></span>
              <small>Services</small>
              </a>
            </li>
            <li>
              <a href="cashier_module.php">
              <span class="las la-clipboard-list"></span>
              <small>Cashier Module</small>
              </a>
            </li>
            <li>
              <a href="checkout_list.php">
              <span class="las la-clipboard-list"></span>
              <small>Check Out</small>
              </a>
            </li>
            <li>
              <a href="reservation_list.php" class="active">
              <span class="las la-clipboard-list"></span>
              <small>Reservations</small>
              </a>
            </li>
            <li>
              <a href="admin_users.php">
              <span class="las la-user-friends"></span>
              <small>User List</small>
              </a>
            </li>
            <li>
              <a href="manage_promocode.php">
              <span class="las la-tasks"></span>
              <small>Promo Code</small>
              </a>
            </li>
            <li>
              <a href="reports.php">
              <span class="las la-tasks"></span>
              <small>Reports</small>
              </a>
            </li>
            <li>
              <a href="https://premium121.web-hosting.com:2096/cpsess6146287962/3rdparty/roundcube/index.php?_task=mail&_mbox=INBOX">
              <span class="las la-envelope"></span>
              <small>Inquiries</small>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="main-content">
      <header>
        <div class="header-content">
          <label for="menu-toggle">
          <span class="las la-bars"></span>
          </label>
          <div class="header-menu">
            <label for="">
            <span class="las la-search"></span>
            </label>
            <div class="notify-icon">
              <span class="las la-envelope"></span>
              <span class="notify">4</span>
            </div>
            <div class="notify-icon">
              <span class="las la-bell"></span>
              <span class="notify">3</span>
            </div>
            <div class="user">
              <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
              <span class="las la-power-off"></span>
              <span>Logout</span>
            </div>
          </div>
        </div>
      </header>
      <main>
        <div class="page-header" style="display: flex; align-items: center; margin-top: -50;">
          <h1 style="margin-right: 10px;">Transaction Report</h1>
          <small>Home / Transaction Report</small> <button onclick="printTable()" style="margin-left:0.5vh; background-color:gray; color:white;">Print Report</button>
          <div class="input-group-append" style="margin-left:5vh;">
            <a href="reports.php" class="btn btn-primary">Sales Report</a>
            <a href="guest_report.php" class="btn btn-primary">Guest Report</a>
            <a href="room_report.php" class="btn btn-primary">Room Report</a>
            <a href="transaction_report.php" class="btn btn-primary">Transactions Report</a>
            <a href="audit_report.php" class="btn btn-primary">Audit Report</a>
            
          </div>
          
        </div>
        <div class = "filter-transaction">
                <label for="paymentFilter">Filter by Payment:</label>
                <select id="paymentFilter" onchange="applyPaymentFilter()">
                    <option value="all">All Transactions</option>
                    <option value="fullyPaid">Fully Paid</option>
                    <option value="downpayment">Downpayment</option>
                </select>
            </div>
        <table style="margin: 20px; width:98%;">
          <tr>
            <!-- <th>Reservation ID</th> -->
            <th>Transaction Details</th>
            <th>Guest Details</th>
            <th>Dates Details</th>
            <th>Price Details</th>
            <th>Payment Details</th>
            <th>Transaction Status</th>
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
            
            if ($result->num_rows == 0 && $servicesResult->num_rows == 0) {
                echo "<tr><td colspan='12'>No reservations found.</td></tr>";
            }
            // Loop through the query result and display the reservation details in each row
            if ($result->num_rows > 0) {
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
                    echo "# of Childrens: " . $row['children'] . "<br><br>Amenities Lists:<br>";?>
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
            echo "</td>";
            echo "<td>Account ID: " . $row['user_id'] . "<br>";
            echo "Guest Name: " . $row['name'] . "<br>";
            echo "Guest Email: " . $row['email'] . "</td>";
            echo "<td>Check-in Date: " . $row['check_in_date'] . "<br>";
            echo "Check-out Date: " . $row['check_out_date'] . "</td>";
            
            echo "<td style='color:black; '>
            Total Amount: " . number_format($row['payable_amount'],2) . " Php<br>
            Paid Amount: ".number_format($row['paid_amount'],2)." Php<br>
            Remaining Bal: ".number_format(($row['payable_amount'] - $row['paid_amount']),2)." Php
            </td>";
            
            if($row['down_payment'] != '0'){
            
            echo "<td style='color:black;'>Gcash Ref#: ".$row['reference_number']."<br>Downpayment: ".number_format($row['down_payment'],2)." Php
            <br><br>Onsite Payment<br>Paid Amount: ".number_format(($row['paid_amount'] - $row['down_payment']),2)."</td>";
            }else{
            
            echo "<td style='color:black;'>Gcash Ref#: ".$row['reference_number']."<br>Paid Amount: ".number_format($row['paid_amount'],2)." Php</td>";
            }
            echo "<td>" . $row['status'] . "</td>";
            echo "<td><a class='btn btn-primary' href='#' data-toggle='modal' data-target='#printReceiptModal{$row['reservation_id']}'>Print Receipt</a></td>";


            echo "<div class='modal fade ' id='printReceiptModal{$row['reservation_id']}' tabindex='-1' role='dialog' aria-labelledby='printReceiptModalLabel' aria-hidden='true'>";
            echo "<div class='modal-dialog' role='document' >";
            echo "<div class='modal-content' custom-modal-width>";
            echo "<div class='modal-header'>";
            echo "</div>";
            echo "<div class='modal-body'>";

            echo "<center><h2>Kamantigue Official Receipt</h2></center><br><br><br><br><br>";


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
            echo "<p><strong>Reservation ID:</strong> {$row['reservation_id']}</p>";
            echo "<p><strong>Room ID:</strong> {$row['room_id']}</p>";
            echo "</div>";
            echo "<div style='flex: 1; text-align: right;'>";
            echo "<p><strong>Room: </strong> {$row['room_number']}</p>";
            echo "<p><strong></strong> {$row['description']}</p>";
            echo "<p><strong>Adults:</strong> {$row['adults']} </strong> | <strong> Children: {$row['children']} </strong></p>";

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
            echo "<div class='modal-footer'>";
            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
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
            echo "<td style='color:black;'>Service #: " . $servicesRow['services_number'] . "<br>";
            echo "Service Info: " . $servicesRow['services_description'] . "</td>";
            echo "<td>Account ID: " . $servicesRow['user_id'] . "<br>";
            echo "Guest Name: " . $servicesRow['name'] . "<br>";
            echo "Guest Email: " . $servicesRow['email'] . "</td>";
            echo "<td> - </td>";
            
            echo "<td style='color:black; '>
            Total Amount: " . number_format($servicesRow['payable_amount'],2) . " Php<br>
            Paid Amount: ".number_format($servicesRow['paid_amount'],2)." Php<br>
            Balance: ".number_format(($servicesRow['payable_amount'] - $servicesRow['paid_amount']),2)." Php
            </td>";
            
            
            if($servicesRow['down_payment'] != '0'){
            
            echo "<td style='color:black;'>Gcash Ref#: ".$servicesRow['reference_number']."<br>Downpayment: ".number_format($servicesRow['down_payment'],2)." Php
            <br><br>Onsite Payment<br>Paid Amount: ".number_format(($servicesRow['paid_amount'] - $servicesRow['down_payment']),2)."</td>";
            }else{
            
            echo "<td style='color:black;'>Gcash Ref#: ".$servicesRow['reference_number']."<br>Paid Amount: ".number_format($servicesRow['paid_amount'],2)." Php</td>";
            }
            echo "<td>" . $servicesRow['status'] . "</td>";

            echo "<td><a class='btn btn-primary' href='#' data-toggle='modal' data-target='#printReceiptModal{$servicesRow['reservation_id']}'>Print Receipt</a></td>";


            echo "<div class='modal fade' id='printReceiptModal{$servicesRow['reservation_id']}' tabindex='-1' role='dialog' aria-labelledby='printReceiptModalLabel' aria-hidden='true'>";
            echo "<div class='modal-dialog custom-modal-width' role='document'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
            // You can add a header if needed
            // echo "<h5 class='modal-title' id='printReceiptModalLabel'>Print Receipt</h5>";
            echo "</div>";
            echo "<div class='modal-body'>";

            echo "<center><h2>Kamantigue Official Receipt</h2></center><br><br><br><br><br>";

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
            echo "<p><strong>Total Amount:</strong> " . number_format($servicesRow['payable_amount'], 2) . " Php</p>";
            echo "<p><strong>Remaining Balance:</strong> " . number_format($servicesRow['payable_amount'] - $servicesRow['paid_amount'], 2) . " Php</p>";
            echo "</div>";
            echo "</div>";

            echo "</div>";
            echo "<div class='modal-footer'>";
            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
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

          function applyPaymentFilter() {
        var filterValue = document.getElementById("paymentFilter").value;
        var rows = document.querySelectorAll("table tr");

        for (var i = 1; i < rows.length; i++) {
            var paymentCell = rows[i].getElementsByTagName("td")[4]; // Assuming the payment status is in the 5th column (adjust if needed)

            if (filterValue === "all" || paymentCell.innerHTML.includes(filterValue)) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
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
        <!-- <a href="logout.php">Logout</a> -->
        <!-- Vendor JS Files -->
        <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="../assets/vendor/php-email-form/validate.js"></script>
        <!-- Template Main JS File -->
        <script src="../assets/js/main.js"></script>
      </main>
    </div>
  </body>
</html>