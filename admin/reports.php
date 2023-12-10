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

$sql = "SELECT reservations.*, rooms.room_id, rooms.room_number, rooms.description, users.name, users.email
        FROM reservations
        JOIN rooms ON reservations.room_id = rooms.room_id
        JOIN users ON reservations.user_id = users.user_id  AND reservations.reference_number IS NOT NULL AND reservations.status = 'Approved'";

if(isset($_POST['search_username']) && !empty($_POST['search_username'])){
    $search_username = $_POST['search_username'];
    $sql .= " WHERE users.username LIKE '%$search_username%'";
}

$sql .= " ORDER BY reservations.reservation_id DESC";

$result = $conn->query($sql);

$servicesSQL = "SELECT reservations.*, services_number, services_description, services_price, reservation_id, status, reference_number, users.name, users.email
                FROM reservations
                JOIN users ON reservations.user_id = users.user_id
                WHERE services_number IS NOT NULL
                AND services_description IS NOT NULL
                AND services_price IS NOT NULL AND reservations.reference_number IS NOT NULL AND reservations.status = 'Approved'";

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

</head>

<body>

    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>K<span>amantigue</span></h3>
        </div>
        
        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(admin.jpg)"></div>
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
                     <a href="reservation_list.php">
                          <span class="las la-clipboard-list"></span>
                          <small>Reservations</small>
                      </a>
                  </li>
                  <li>
                     <a href="add_new_reservations.php">
                          <span class="las la-clipboard-list"></span>
                          <small>New Reservation</small>
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
                    <a href="reports.php" class="active">
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
                    <span></span>
                </label>
                
                <div class="notify-icon">
                    <span></span>
                    <span class="notify"></span>
                </div>
                
                <div class="notify-icon">
                    <span></span>
                    <span class="notify"></span>
                </div>
                
                <div class="user">
                    <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                    
                    <span class="las la-power-off"></span>
                    <a class="nav-link" href="logout.php"><span>Logout</span></a>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="page-header" style="display: flex; align-items: center; margin-top: -50;">
            <h1 style="margin-right: 10px;">Sales Report</h1>
                <small>Home / Sales Report</small>   <button onclick="printTable()" style="margin-left:0.5vh; background-color:gray; color:white;">Print Report</button>


                        <div class="input-group-append" style="margin-left:5vh;">
                            <a href="reports.php" class="btn btn-primary">Sales Report</a>
                            <a href="guest_report.php" class="btn btn-primary">Guest Report</a>
                            <a href="room_report.php" class="btn btn-primary">Room Report</a>
                            <a href="transaction_report.php" class="btn btn-primary">Transactions Report</a>
                            <a href="audit_report.php" class="btn btn-primary">Audit Report</a>
                        </div>
            </div>

<form method="POST" action="" id="filterForm" style="margin-left:20px;">
  <label for="selectedMonth">Select:</label>
  <select name="selectedMonth" id="selectedMonth" onchange="document.getElementById('filterForm').submit();" style="width:250px;">
  <option value="01">All</option>
    <option value="02">January</option>
    <option value="03">February</option>
    <option value="04">March</option>
    <option value="05">April</option>
    <option value="06">May</option>
    <option value="07">June</option>
    <option value="08">July</option>
    <option value="09">August</option>
    <option value="10">September</option>
    <option value="11">October</option>
    <option value="12">November</option>
    <option value="13">December</option>
    
  </select>
 
    </form>
   
    <table style="margin: 20px; width:98%;">
      <thead>
        <tr>
            <!-- <th>Reservation ID</th> -->
            <th>#</th>
            <th>Reservation Date</th>
            <th>GCash Ref #</th>
            <th>Client Details</th>
            <th>Room/Service</th>
            <th>Total Price</th>
            <th>Paid Price</th>
            <th>Balance</th>
            <th>Status</th>
          
            <!-- Add more columns as needed -->
        </tr>
      </thead>
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
        $counter = 0;
        // Loop through the query result and display the reservation details in each row
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $counter++;
                $statusClass = getStatusClass($row['status']);
                $totalbalance = '0';
                $gcashdetails = 'Waiting';
                if($row['reference_number'] != ''){
                  $totalbalance = $row['payable_amount'] - $row['paid_amount'];
                  $gcashdetails = "Gcash Ref#: " . $row['reference_number'] . "<br>";
                }

                $submittedDateTime = new DateTime($row['submitted_date']);
                $formattedDateTime = $submittedDateTime->format('Y-m-d g:i A');

                echo "<tr class='$statusClass'>";
                // echo "<td>" . $row['reservation_id'] . "</td>";
                echo "<td style='color:black;'>" . $counter . "</td>";
                echo "<td>" . $formattedDateTime  . "</td>";
                echo "<td> 
                  $gcashdetails
                </td>";
                echo "<td>Guest Name: " . $row['name'] . "<br>Guest Email: " . $row['email'] . "</td>";
                echo "<td>" . $row['room_number'] . "</td>";
                echo "<td>" . number_format($row['payable_amount'],2) . " Php</td>";
                echo "<td>" . number_format($row['paid_amount'],2) . " Php</td>";
                echo "<td>" . number_format($totalbalance,2) . " Php</td>";
                echo "<td>" . $row['status'] . "</td>";
                // Add more columns as needed
                echo "</tr>";
            }
        } else {
            
        }

        if ($servicesResult->num_rows > 0) {
            while ($servicesRow = $servicesResult->fetch_assoc()) {
                $counter++;
                $statusClass = getStatusClass($servicesRow['status']);

                $totalbalance = '0';
                $gcashdetails = 'Waiting';
                if($servicesRow['reference_number'] != ''){
                  $totalbalance = $servicesRow['payable_amount'] - $servicesRow['paid_amount'];
                  $gcashdetails = "Gcash Ref#: " . $servicesRow['reference_number'] . "<br>";
                }
                $submittedDateTime = new DateTime($servicesRow['submitted_date']);
                $formattedDateTime = $submittedDateTime->format('Y-m-d g:i A');


                echo "<tr class='$statusClass'>";
                // echo "<td>" . $servicesRow['reservation_id'] . "</td>";
                echo "<td style='color:black;'>" . $counter . "</td>";
                echo "<td>" . $formattedDateTime . "</td>";
                echo "<td> 
                  $gcashdetails
                </td>";
                echo "<td>Guest Name: " . $servicesRow['name'] . "<br>Guest Email: " . $servicesRow['email'] . "</td>";
                echo "<td>" . $servicesRow['services_description'] . "</td>";
                echo "<td>" . number_format($servicesRow['payable_amount'],2) . " Php</td>";
                echo "<td>" . number_format($servicesRow['paid_amount'],2) . " Php</td>";
                echo "<td>" . number_format($totalbalance,2) . " Php</td>";
                echo "<td>" . $servicesRow['status'] . "</td>";
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