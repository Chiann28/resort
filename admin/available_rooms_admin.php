<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php
session_start();
require_once 'config.php';

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    //$room_id = $_POST['room_id'];
    //$adults = $_POST['adults'];
    //$children = $_POST['children'];

    // Your existing code for displaying available rooms
    $sql = "SELECT rooms.*
            FROM rooms
            WHERE NOT EXISTS (
                SELECT 1
                FROM reservations
                WHERE rooms.room_id = reservations.room_id
                AND (reservations.check_in_date BETWEEN '$check_in_date' AND '$check_out_date' AND check_out_status = 'waiting'
                OR reservations.check_out_date BETWEEN '$check_in_date' AND '$check_out_date' AND check_out_status = 'waiting')
            )";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='container mt-4'>";
        echo "<h3>Available Rooms:</h3>";
        echo "<div class='row'>";

        while ($row = $result->fetch_assoc()) {
            echo "<div class='col-md-4 mb-4'>";
            echo "<div class='card'>";
            echo "<img src='../assets/img/rooms/{$row['picture_link']}' class='card-img-top' alt='Room Image'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>Room Number: {$row['room_number']}</h5>";
            echo "<p class='card-text'>Room Type: {$row['description']}</p>";
            echo "<p class='card-text' style='font-weight:bold; color:#007bff; background-color:white; padding:10px; border-radius:1vh; text-align:center; border: 1px solid black;'>Php {$row['price']} / Night</p>";


            echo "<form id='reservationForm' action='make_reservation_admin.php' method='post'>";
            echo "<label for='adults'>Number of Adults:</label>";
            echo "<input type='number' name='adults' id='adults' oninput='checkTotalGuests()' value='0' required>";
            echo "<label for='children'>Number of Children:</label>";
            echo "<input type='number' name='children' id='children' oninput='checkTotalGuests()' value='0' required>";

            // Add a hidden input field for room number
            echo "<input type='hidden' name='room_id' id='roomID' value='{$row['room_id']}'>";

            echo "<input type='hidden' name='check_in_date' value='{$check_in_date}'>";
            echo "<input type='hidden' name='check_out_date' value='{$check_out_date}'>";
            echo "<br/>";
            echo "<button type='submit' class='btn btn-primary mt-3'>Make Reservation</button>";
            echo "</form>";

            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

        echo "</div>"; // Close row
        echo "</div>"; // Close container
    } else {
        echo "<p>No available rooms for the selected date range.</p>";
    }
}

function print_script(){
    echo '<script>
        function checkTotalGuests() {
            var adults = parseInt(document.getElementById("adults").value) || 0;
            var children = parseInt(document.getElementById("children").value) || 0;
            var totalGuests = adults + children;
            var roomNumber = document.getElementById("roomNumber").value;

            if (roomNumber === "Barkada Room 1" && totalGuests > 16) {
                document.getElementById("error-message").style.display = "block";
            } else {
                document.getElementById("error-message").style.display = "none";
            }
        }
    </script>';
}

print_script();
?>
<div class="container mt-4" id="error-message" style="display: none;">
    <div class="alert alert-danger" role="alert">
        Error: The total number of adults and children cannot exceed 16 for this room.
    </div>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
