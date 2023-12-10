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
                     <a href="reservation_list.php">
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
            <h1 style="margin-right: 10px;">Room Report</h1>
                <small>Home / Room Report</small> <button onclick="printTable()" style="margin-left:0.5vh; background-color:gray; color:white;">Print Report</button>

                        <div class="input-group-append" style="margin-left:5vh;">
                            <a href="reports.php" class="btn btn-primary">Sales Report</a>
                            <a href="guest_report.php" class="btn btn-primary">Guest Report</a>
                            <a href="room_report.php" class="btn btn-primary">Room Report</a>
                            <a href="transaction_report.php" class="btn btn-primary">Transactions Report</a>
                            <a href="audit_report.php" class="btn btn-primary">Audit Report</a>
                        </div>
            </div>

   
        <table style="margin: 20px; width:98%;">
            <thead class="thead-dark">
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