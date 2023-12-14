<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/php/PHPMailer.php';
require '../assets/php/Exception.php';
require '../assets/php/SMTP.php';

session_start();

// Check if the user is logged in and has a valid session
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or any other appropriate page
    header("Location: user_login.html");
    exit();
}

require_once 'config.php';

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Assuming you have established a database connection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $user_id = $_SESSION['user_id']; // Assuming you have a logged-in user with an ID
    $children = $_POST['children'];
    $adults = $_POST['adults'];

    // Calculate the total number of guests
    $total_guests = $adults + $children;

    // Check if the total number of guests exceeds the limit for specific room IDs
    $room_ids_with_limit = [12, 13, 18, 19];
    $guests_limit = 16; // Limit for room IDs 12, 13, 18, 19
    $room_ids_with_individual_limit = [14, 16, 17];
    $individual_limit = 4; // Limit for room IDs 14, 16, 17
    

    if (in_array($room_id, $room_ids_with_limit) && $total_guests > $guests_limit) {
        echo "<script>alert('Error: The total number of adults and children cannot exceed $guests_limit for the selected room.'); window.location.href = 'add_new_reservations.php';</script>";
        exit();
    }

    if (in_array($room_id, $room_ids_with_individual_limit) && $total_guests > $individual_limit) {
        echo "<script>alert('Error: Room $room_id has a maximum limit of $individual_limit guests.'); window.location.href = 'add_new_reservations.php';</script>";
        exit();
    }

    if ($room_id == 15 && $total_guests > 2) {
        echo "<script>alert('Error: The total number of adults and children cannot exceed 2 for this room.'); window.location.href = 'add_new_reservations.php';</script>";
        // You can redirect the user back to the reservation page or take other actions as needed.
        exit();
    }

    if ($room_id == 20 && $total_guests > 12) {
        echo "<script>alert('Error: The total number of adults and children cannot exceed 12 for this room.'); window.location.href = 'add_new_reservations.php';</script>";
        // You can redirect the user back to the reservation page or take other actions as needed.
        exit();
    }

    if ($room_id == 21 && $total_guests > 18) {
        echo "<script>alert('Error: The total number of adults and children cannot exceed 18 for this room.'); window.location.href = 'add_new_reservations.php';</script>";
        // You can redirect the user back to the reservation page or take other actions as needed.
        exit();
    }


    // Insert the reservation into the database
    $sql = "INSERT INTO reservations (user_id, room_id, check_in_date, check_out_date, status, adults, children)
            VALUES ('$user_id', '$room_id', '$check_in_date', '$check_out_date', 'Pending', '$adults', '$children')";

    // Execute the SQL query and perform error handling
    if ($conn->query($sql) === TRUE) {

        $audit_userid = $_SESSION['user_id'];
        $audit_name = $_SESSION['user_nameaudit'];
        $audit_action = "Add to cart room reservation with room ID: " . $room_id;
        $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
        if ($conn->query($auditloginsert) === TRUE) {
        }

        // Reservation inserted successfully, redirect the user to a success page or reservation details page
        $url = "add_new_reservations.php?showQRCode=true&room_id=$room_id&check_in_date=$check_in_date&check_out_date=$check_out_date";

        // Registration successful, send a thank-you email to the user
        $mail = new PHPMailer(true);
        try {
            // (your mail configuration code here)
        } catch (Exception $e) {
            // Email sending failed, log the error or handle it as needed
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

        header("Location: admin_reservations.php");
        exit();
    } else {
        // Error handling for the query
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
        echo "<script>alert('$error_message'); window.location.href = 'add_new_reservations.php';</script>";
        exit();
    }
}
?>
