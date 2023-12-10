<?php



use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;



require '../assets/php/PHPMailer.php';

require '../assets/php/Exception.php';

require '../assets/php/SMTP.php';

// Start the session

session_start();



// Check if admin is logged in, otherwise redirect to login page

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {

    header("Location: admin_login.html");

    exit();

}



require_once 'config.php';



$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);



// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}



if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['reservation_id'])) {

    $reservation_id = $_GET['reservation_id'];

    $email = $_GET['email'];

    $name = $_GET['name'];


    // Update the reservation status in the database

    $update_sql = "UPDATE reservations 

                   SET check_out_status = 'checkedout' 

                   WHERE reservation_id = '$reservation_id'";



    if ($conn->query($update_sql) === TRUE) {


                $audit_userid = $_SESSION['admin_id'];
                $audit_name = $_SESSION['admin_nameaudit'];
                $audit_action = "Checked out reservation ID: ".$reservation_id;
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}
        // Reservation status updated successfully, redirect back to admin dashboard

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();

            $mail->Host = 'smtp.hostinger.com'; // Your SMTP host

            $mail->SMTPAuth = true;

            $mail->Username = 'info@kamantiguebeachresort.johnpaulheje.tech'; // Your SMTP username

            $mail->Password = 'Kamantigue1123!'; // Your SMTP password

            $mail->SMTPSecure = 'ssl';

            $mail->Port = 465;

    

            $mail->setFrom('info@kamantiguebeachresort.johnpaulheje.tech', 'Kamantigue Beach Resort');

            $mail->addAddress($email, $name); // User's email address and name

    

            $mail->isHTML(true);

            $mail->Subject = 'Thank You For Staying';

            $mail->Body = "Dear $name,<br><br>Thank you for staying to our resort. We hope you`ll come back and we will ensure that our services is improved.<br><br>Best regards,<br>Kamantigue Beach Resort";

    

            $mail->send();

        } catch (Exception $e) {

            // Email sending failed, log the error or handle it as needed

            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;

        }





        header("Location: checkout_list.php");

        exit();

    } else {

        // Error handling for the query

        // You can log the error for debugging purposes or display an error message to the admin

        echo "Error updating reservation status: " . $conn->error;

        // Alternatively, you can redirect the admin to an error page

        // header("Location: error_page.php?message=" . urlencode("Error updating reservation status"));

        exit();

    }

} else {

    // Invalid request, redirect back to admin dashboard or show an error message

    header("Location: checkout_list.php");

    exit();

}

?>

