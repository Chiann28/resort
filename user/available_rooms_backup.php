<?php
// Start the session
session_start();

// // Check if admin is logged in, otherwise redirect to login page
// if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
//     header("Location: user_login.html");
//     exit();
// }

require_once 'config.php';

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $check_in_date = $_POST['check_in_date'];
  $check_out_date = $_POST['check_out_date'];

  // Query available rooms for the specified date range
  $sql = "SELECT rooms.*
          FROM rooms
          WHERE NOT EXISTS (
              SELECT 1
              FROM reservations
              WHERE rooms.room_id = reservations.room_id
              AND (reservations.check_in_date BETWEEN '$check_in_date' AND '$check_out_date'
              OR reservations.check_out_date BETWEEN '$check_in_date' AND '$check_out_date')
          )";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // Display the list of available rooms
      echo "<h3>Available Rooms:</h3>";
      echo "<ul>";
      while ($row = $result->fetch_assoc()) {
          echo "<li>Room Number: " . $row['room_number'] . " (Room Type: " . $row['description'] . ")";
          // Add a button for each room to make a reservation
          echo "<form action='make_reservation.php' method='post' onsubmit='confirmReservation()'>";
          echo "<input type='hidden' name='room_id' value='" . $row['room_id'] . "'>";
          echo "<input type='hidden' name='check_in_date' value='" . $check_in_date . "'>";
          echo "<input type='hidden' name='check_out_date' value='" . $check_out_date . "'>";
          echo "<button type='submit'>Make Reservation</button>";
          echo "</form>";
          echo "</li>";
      }
      echo "</ul>";

  } else {
      echo "No available rooms for the selected date range.";
  }

    
  
}

?>