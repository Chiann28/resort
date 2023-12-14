<?php

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
    $services_number = $_POST['services_number'];
    $services_description = $_POST['services_description'];
    $services_price = $_POST['services_price'];
    $service_room = $_POST['services_room'];
    $user_id = $_SESSION['user_id']; // Assuming you have a logged-in user with an ID

    // Insert the reservation into the database
    $sql = "INSERT INTO reservations (user_id, services_number, services_description, services_price, status)
            VALUES ('$user_id','$services_number', '$services_description', '$services_price','Pending')";

     // Execute the SQL query and perform error handling
     if ($conn->query($sql) === TRUE) {
        // Reservation inserted successfully, redirect the user to a success page or reservation details page
        // $url = "user_dashboard.php?showQRCode=true&room_id=$room_id&check_in_date=$check_in_date&check_out_date=$check_out_date";


                $audit_userid = $_SESSION['user_id'];
                $audit_name = $_SESSION['user_nameaudit'];
                $audit_action = "Add to cart service with service ID: ".$services_number;
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}

        header("Location: user_reservations.php");
        exit();
    } else {
        // Error handling for the query
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
        // You can log the error for debugging purposes or display an error message to the user
        echo $error_message;
        // Alternatively, you can redirect the user to an error page
        // header("Location: error_page.php?message=" . urlencode($error_message));
        exit();
    }
}
?>
