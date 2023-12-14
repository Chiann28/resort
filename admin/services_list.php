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

 $sql = "SELECT * from services";
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

   <style>
   .modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
}

.modal-content {
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    width: 100%;
    max-width: 400px; /* Adjust the max-width as needed */
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
                     <a href="services_list.php" class="active">
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
        <div class="page-header">
            <h1>Services</h1>
            <small>Home / Services</small>
        </div>

    <table class="room-table" style="margin: 20px;">
        <tr>
            <!-- <th>Services</th> -->
            <th>Services</th>
            <th>Price</th>
            <th>Type</th>
            <th>Edit</th>
            <th>Delete</th>
          
            <!-- Add more table headers based on your database columns -->
        </tr>

        <?php
         // Loop through the query result and display the room details in each row
        while ($list_services_row = $result->fetch_assoc()) {
            echo "<tr>";
            // echo "<td>" . $list_rooms_row['room_number'] . "</td>";
            echo "<td>" . $list_services_row['description'] . "</td>";
            echo "<td>" . $list_services_row['price'] . "</td>";
            echo "<td>" . $list_services_row['type'] . "</td>";
            echo "<td><button class='edit-btn' onclick='openEditPopup(" . $list_services_row['services_number'] . ")'>Edit</button></td>";
            echo "<td><a href='delete_services.php?services_number=" . $list_services_row['services_number'] . "' onclick='return confirm(\"Are you sure you want to delete this service?\")'>Delete</a></td>";
            echo "</tr>";
            
        }

        echo "<td><button class='edit-btn' onclick='openAddPopup()'>Add Service</button></td>";
        echo "</tr>";
        ?>

    </table>

  <!-- The Edit Popup -->
  <center>
    <div id="editPopup" class="modal" style="width:50%;">
        <div class="modal-content">
            
            <div id="editPopupContent">
                <!-- The content of the edit form will be loaded here using AJAX -->
            </div>
            <span class="close" onclick="closeEditPopup()">Close</span>
        </div>
    </div>

      <!-- The Add Popup -->
      <div id="addPopup" class="modal" style="width:50%;">
        <div class="modal-content">
  
            <div id="addPopupContent">
                <!-- The content of the edit form will be loaded here using AJAX -->
            </div>
            <span class="close" onclick="closeAddPopup()">Close</span>
        </div>
    </div>
  </center>   

<!-- JavaScript to handle the edit popup -->
<script>

    
    function openEditPopup(services_number) {
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
        xhttp.open("GET", "edit_services.php?services_number=" + services_number, true);
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
        addPopupContent.innerHTML = '<iframe src="add_services.php" frameborder="0" width="100%" height="500px"></iframe>';
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