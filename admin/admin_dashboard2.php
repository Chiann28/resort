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

$sql = "SELECT rooms.room_id, rooms.room_number, rooms.description, 
               COALESCE(reservations.status, 'Available') AS status,
               users.name, users.email
        FROM rooms
        LEFT JOIN reservations ON rooms.room_id = reservations.room_id
        LEFT JOIN users ON reservations.user_id = users.user_id";
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

<?php
    require 'admin_navbar.php';
?>

    <h2>List of Rooms</h2>
    <table class="room-table">
        <tr>
            <th>Room Number</th>
            <th>Description</th>
            <th>Status</th>
            <th>Reservation Details</th>
            <th>Edit</th>
            <th>Delete</th>
          
            <!-- Add more table headers based on your database columns -->
        </tr>

        <?php
         // Loop through the query result and display the room details in each row
        while ($list_rooms_row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $list_rooms_row['room_number'] . "</td>";
            echo "<td>" . $list_rooms_row['description'] . "</td>";
            echo "<td>" . $list_rooms_row['status'] . "</td>";
            echo "<td>";
            if ($list_rooms_row['user_id']) {
            echo "Reserved by: " . $list_rooms_row['name'] . " (Email: " . $list_rooms_row['email'] . ")";
            } else {
            echo "Not Reserved";
            }
            echo "</td>";
            echo "<td><button class='edit-btn' onclick='openEditPopup(" . $list_rooms_row['room_id'] . ")'>Edit</button></td>";
            echo "<td><a href='delete_room.php?room_id=" . $list_rooms_row['room_id'] . "' onclick='return confirm(\"Are you sure you want to delete this room?\")'>Delete</a></td>";
            echo "</tr>";
        }
        ?>

    </table>

        
    <h2>All Reservations</h2>
    <table>
        <tr>
            <th>Reservation ID</th>
            <th>Room ID</th>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>User ID</th>
            <th>User Name</th>
            <th>User Email</th>
            <th>Check-in Date</th>
            <th>Check-out Date</th>
            <th>Status</th>
            <!-- Add more columns as needed -->
        </tr>

        <?php

        $result = $conn->query($sql);

        // Loop through the query result and display the reservation details in each row
        while ($row2 = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row2['reservation_id'] . "</td>";
            echo "<td>" . $row2['room_id'] . "</td>";
            echo "<td>" . $row2['room_number'] . "</td>";
            echo "<td>" . $row2['description'] . "</td>";
            echo "<td>" . $row2['user_id'] . "</td>";
            echo "<td>" . $row2['name'] . "</td>";
            echo "<td>" . $row2['email'] . "</td>";
            echo "<td>" . $row2['check_in_date'] . "</td>";
            echo "<td>" . $row2['check_out_date'] . "</td>";
            echo "<td>" . $row2['status'] . "</td>";
            echo "<td><a href='edit_reservation_status.php?reservation_id=" . $row2['reservation_id'] . "&status=Confirmed'>Confirm</a></td>";
            echo "<td><a href='edit_reservation_status.php?reservation_id=" . $row2['reservation_id'] . "&status=Confirmed'>Reject</a></td>";
            // Add more columns as needed
            echo "</tr>";
        }
        // Close the database connection
        $conn->close();
        ?>
    </table>



    <!-- The Edit Popup -->
<div id="editPopup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditPopup()">&times;</span>
        <h2>Edit Data</h2>
        <div id="editPopupContent">
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
        xhttp.open("GET", "edit_data.php?room_id=" + room_id, true);
        xhttp.send();
    }

    function closeEditPopup() {
        // Get the editPopup element
        var editPopup = document.getElementById("editPopup");

        // Hide the editPopup
        editPopup.style.display = "none";
    }
</script>
 
    <a href="logout.php">Logout</a>
</body>
</html>