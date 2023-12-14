<?php
// reschedule_reservation.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
$error_message = "";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
session_start();
// Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $new_check_in_date = $_POST['new_check_in_date'];
    $new_check_out_date = $_POST['new_check_out_date'];
    $status = 'Rescheduled';

    // Validate the new dates as needed

    // Update the reservations table with new dates
    $updateSql = "UPDATE reservations SET check_in_date = '$new_check_in_date', check_out_date = '$new_check_out_date', status = '$status' WHERE reservation_id = $reservation_id";

 
    
    if ($conn->query($updateSql) === TRUE) {
        // Success
        echo 'Reservation successfully rescheduled.';
        // Redirect or show success message
        header("Location: available_rooms.php");
        exit();
    } else {
        // Error handling
        $error_message = "Error updating reservation: " . $conn->error;
        // Handle the error as needed, for example, display an error message to the user
        header("Location: available_rooms.php");.
    }
}
?>