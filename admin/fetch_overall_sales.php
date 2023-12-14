<?php
// Connect to your database
require_once 'config.php';

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch overall sales data
$sql = "SELECT SUM(price) AS overall_sales
        FROM rooms
        INNER JOIN reservations ON rooms.room_id = reservations.room_id
        WHERE reservations.status = 'Approved'";

$result = $conn->query($sql);
$data = $result->fetch_assoc();

// Return the sales data as JSON
echo json_encode($data);

$conn->close();
?>
