<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/php/PHPMailer.php';
require '../assets/php/Exception.php';
require '../assets/php/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Assuming you have obtained the user's submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    

    // Combine the password with the salt and hash it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    require_once 'config.php';

    // Create a database connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

     // Check connection
     if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

     // Generate a verification token
     $verificationToken = bin2hex(random_bytes(16)); // Generates a 32-character token

    // Save the username, hashed password, and salt to the database
    $sql = "INSERT INTO users (username, password, name, email, verification_token, verified) VALUES ('$username', '$hashedPassword', '$name', '$email', '$verificationToken', 0)";

   // Execute the SQL query and perform error handling
   if ($conn->query($sql) === TRUE) {



    // Registration successful, send a thank-you email to the user
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
        $mail->addAddress($email, $name); // User's email address and name

        $verificationLink = "https://kamantiguebeachresort.com/user/verify.php?token=$verificationToken";
        $mail->isHTML(true);
        $mail->Subject = 'Thank You for Registering';
        $mail->Body = "Dear $name,<br><br>Thank you for registering on our website. Your username is: $username. Please verify your email by clicking the following link:<br><br><a href='$verificationLink'>$verificationLink</a><br><br>Best regards,<br>Kamantigue Beach Resort";

        $mail->send();
    } catch (Exception $e) {
        // Email sending failed, log the error or handle it as needed
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

    // Redirect the user to a success page or login page
    header("Location: user_login.php?registration=success");
    
    exit();
    } else {
        // Registration failed, handle the error
        // You can show an error message to the user or log the error for debugging purposes
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

// Close the database connection
$conn->close();
}
?>