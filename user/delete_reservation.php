<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_reservation'])) {
    $reservation_id = $_POST['reservation_id'];

    // Assuming you have established a database connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check for a valid database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the reservation based on reservation_id
    $delete_sql = "DELETE FROM reservations WHERE reservation_id = '$reservation_id'";
    
    if ($conn->query($delete_sql) === TRUE) {
        // Reservation deleted successfully, you can redirect to a success page or display a success message

        $_SESSION['updatedPrice'] = '';

                $audit_userid = $_SESSION['user_id'];
                $audit_name = $_SESSION['user_nameaudit'];
                $audit_action = "User delete its reservation with reservation ID: ".$reservation_id." from reservations cart.";
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}

        header('Location: user_reservations.php');
        exit();
    } else {
        // Handle the error
        echo "Error deleting reservation: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect or handle the case where 'delete_reservation' is not set or not using POST method
    header('Location: error.php');
    exit();
}
?>
