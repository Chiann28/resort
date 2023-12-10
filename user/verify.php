<?php
// verify.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/php/PHPMailer.php';
require '../assets/php/Exception.php';
require '../assets/php/SMTP.php';
require_once 'config.php';

// Retrieve the verification token from the URL parameter
$verificationToken = $_GET['token'];

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the token exists in the database
$select_sql = "SELECT * FROM users WHERE verification_token = '$verificationToken' LIMIT 1";
$result = $conn->query($select_sql);

if ($result->num_rows === 1) {
    // Update the 'verified' column to 1
    $update_sql = "UPDATE users SET verified = 1 WHERE verification_token = '$verificationToken'";
    if ($conn->query($update_sql)) {
        // Display a success message
        echo "Email verification successful. You can now login.";
        header("Location: user_login.html");
    } else {
        // Display an error message
        echo "Error updating verification status: " . $conn->error;
    }
} else {
    // Display an error message
    echo "Invalid verification token.";
}

// Close the database connection
$conn->close();
?>
