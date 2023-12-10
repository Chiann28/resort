<?php
session_start();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/php/PHPMailer.php';
require '../assets/php/Exception.php';
require '../assets/php/SMTP.php';

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Create a database connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and retrieve the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Prepare and execute the SQL query to insert the data into the inquiries table
    $sql = "INSERT INTO inquiries (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully

        // Send email to the user
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'premium121.web-hosting.com'; // Update with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'sales@kamantiguebeachresort.com'; // Update with your SMTP username
        $mail->Password = '~dY4[%pCzA!0'; // Update with your SMTP password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('sales@kamantiguebeachresort.com', 'Kamantigue Beach Resort');
        $mail->addAddress($email, $name); // Use the user's email and name
        $mail->isHTML(true);
        $mail->Subject = 'Thank you for your inquiry';
        $mail->Body = 'Thank you for your inquiry. We will get back to you soon.';

        if ($mail->send()) {
        } else {
            echo "Email could not be sent.";
        }


         // Send email to yourself
        $adminEmail = 'sales@kamantiguebeachresort.com'; // Update with your email address

        $adminMail = new PHPMailer();
        $adminMail->isSMTP();
        $adminMail->Host = 'premium121.web-hosting.com'; // Update with your SMTP host
        $adminMail->SMTPAuth = true;
        $adminMail->Username = 'sales@kamantiguebeachresort.com'; // Update with your SMTP username
        $adminMail->Password = '~dY4[%pCzA!0'; // Update with your SMTP password
        $adminMail->SMTPSecure = 'ssl';
        $adminMail->Port = 465;

        $adminMail->setFrom('sales@kamantiguebeachresort.com', 'Kamantigue Beach Resort');
        $adminMail->addAddress($adminEmail); // Send to administrator email
        $adminMail->Subject = $subject;
        
            // Include sender's details in the email body
        $adminMail->Body = "A new inquiry has been submitted on your website.\n\n";
        $adminMail->Body .= "Sender's Name: $name\n";
        $adminMail->Body .= "Sender's Email: $email\n";
        $adminMail->Body .= "Message: $message\n";


        if ($adminMail->send()) {
            header("Location: contact1.php"); // Redirect to a success page
            exit();
        } else {
            echo "Email could not be sent.";
        }
    } else {
        // Data insertion failed
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    } else {
    // Invalid request method
    echo "Invalid request method.";
    }






?>