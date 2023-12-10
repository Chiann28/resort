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
    $room_id = $_POST['room_id_reserve'];
    $check_in_date = $_POST['check_in_date_reserve'];
    $check_out_date = $_POST['check_out_date_reserve'];
    $user_id = $_SESSION['user_id']; // Assuming you have a logged-in user with an ID
    $reference_number = $_POST['reference_number'];

    // Update the reservation with the reference number
    $update_sql = "UPDATE reservations
                   SET reference_number = '$reference_number'
                   WHERE user_id = '$user_id'
                   AND room_id = '$room_id'
                    AND check_in_date = '$check_in_date'
                    AND check_out_date = '$check_out_date'";

    // Execute the SQL query and perform error handling
    if ($conn->query($update_sql) === TRUE) {
        // Reference number updated successfully, you can redirect the user to a success page
        header("Location: user_dashboard.php?reserved=true");
        exit();
    } else {
        // Error handling for the query
        $error_message = "Error: " . $conn->error;
        // You can log the error for debugging purposes or display an error message to the user
        echo $error_message;
        // Alternatively, you can redirect the user to an error page
        // header("Location: error_page.php?message=" . urlencode($error_message));
        exit();
    }
}
?>
