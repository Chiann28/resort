<?php

// Start the session

session_start();

require_once 'config.php';
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $newPassword = $_POST['new_password'];

    // Check if the entered OTP is correct
    $sql = "SELECT * FROM users WHERE email = '$email' AND reset_otp = '$otp' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Update the user's password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateSql = "UPDATE users SET password = '$hashedPassword', reset_otp = NULL WHERE email = '$email'";
        $conn->query($updateSql);

        // Redirect to the login page
        header("Location: user_login.php");
        exit();
    } else {
        // Incorrect OTP
        header("Location: reset_password_error.php");
        exit();
    }
}


$conn->close();
?>