<?php



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



if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['reservation_id']) && isset($_GET['status'])) {

    $reservation_id = $_GET['reservation_id'];

    $new_status = $_GET['status'];

    $email = $_GET['email'];

    $name = $_GET['name'];



    // Check if the new status is a valid enum value (Pending, Approved, Rejected)

    $valid_statuses = array("Pending", "Approved", "Rejected", "Rescheduled", "Rescheduled-Approved");

    if (!in_array($new_status, $valid_statuses)) {

        echo "Invalid status value.";

        exit();

    }



    // Update the reservation status in the database

    $update_sql = "UPDATE reservations 

                   SET status = '$new_status' 

                   WHERE reservation_id = '$reservation_id'";



    if ($conn->query($update_sql) === TRUE) {


                $audit_userid = $_SESSION['admin_id'];
                $audit_name = $_SESSION['admin_nameaudit'];
                $audit_action = "Update the status of reservation ID: ".$reservation_id." to ".$new_status;
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}
        // Reservation status updated successfully, redirect back to admin dashboard

      

        



        header("Location: reservation_list.php");

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

    header("Location: reservation_list.php");

    exit();

}

?>

