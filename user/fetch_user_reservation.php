<?php
session_start();

require_once 'config.php';


// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID (you need to implement user authentication)
$user_id = $_SESSION['user_id']; // Modify this to fetch the logged-in user's ID

// Query to count reservations for the user
$sql = "SELECT COUNT(*) AS reservation_count FROM reservations WHERE user_id = $user_id AND reference_number IS NULL";


$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $reservation_count = $row['reservation_count'];
    echo $reservation_count;
} else {
    $reservation_count = 0;
}

$conn->close();
?>