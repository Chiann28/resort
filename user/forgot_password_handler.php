<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/php/PHPMailer.php';
require '../assets/php/Exception.php';
require '../assets/php/SMTP.php';
// Start the session

session_start();

require_once 'config.php';
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $otp = mt_rand(100000, 999999); // You can use a more secure method to generate OTP


        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'premium121.web-hosting.com'; // Your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'sales@kamantiguebeachresort.com'; // Your SMTP username
            $mail->Password = '~dY4[%pCzA!0'; // Your SMTP password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
    
            $mail->setFrom('sales@kamantiguebeachresort.com', 'Kamantigue Beach Resort');
            $mail->addAddress($email); // User's email address and name
    
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP is: $otp";
    
            $mail->send();

            $updateSql = "UPDATE users SET reset_otp = '$otp' WHERE email = '$email'";
            $conn->query($updateSql);

            header("Location: enter_otp.php?email=$email");
            exit();
        } catch (Exception $e) {
            // Email sending failed, log the error or handle it as needed
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    
    }else{
        header("Location: forgot_password_error.php");
        exit();
    }
}

$conn->close();
?>