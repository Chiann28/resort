<?php
// get_room_price.php

require 'config.php';

$roomId = $_GET['roomId'];

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT price FROM rooms WHERE room_id = '$roomId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['price'];
} else {
    echo "0"; // Default price if the room is not found
}

$conn->close();
?>
