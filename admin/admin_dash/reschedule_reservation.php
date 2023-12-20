<?php

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'assets/php/PHPMailer.php';
// require 'assets/php/Exception.php';
// require 'assets/php/SMTP.php';
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

        // $mail = new PHPMailer(true);

        // try {
        //     $mail->isSMTP();
        //     $mail->Host = 'premium121.web-hosting.com'; // Your SMTP host
        //     $mail->SMTPAuth = true;
        //     $mail->Username = 'sales@kamantiguebeachresort.com'; // Your SMTP username
        //     $mail->Password = '~dY4[%pCzA!0'; // Your SMTP password
        //     $mail->SMTPSecure = 'ssl';
        //     $mail->Port = 465;
    
        //     $mail->setFrom('sales@kamantiguebeachresort.com', 'Kamantigue Beach Resort');
        //     $mail->addAddress($email); // User's email address and name
    
        //     $mail->isHTML(true);
        //     $mail->Subject = 'Rescheduled Reservation';
        //     $mail->Body = "You have successfully rescheduled your reservation.";
    
        //     $mail->send();



        // Success
        echo 'Reservation successfully rescheduled.';
        // Redirect or show success message
        header("Location: cancelled_list.php");
        exit();

        // } catch (Exception $e) {
            
        // }
    } else {
        // Error handling
        // $error_message = "Error updating reservation: " . $conn->error;
        // Handle the error as needed, for example, display an error message to the user
    }
}
?>