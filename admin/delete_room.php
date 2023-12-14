<?php
// Assuming you have established a database connection
require_once 'config.php';

session_start();
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];

    // Perform the delete query to delete the room from the database
    $delete_sql = "UPDATE rooms SET status = 0 WHERE room_id = '$room_id'";
    if ($conn->query($delete_sql) === TRUE) {

                $audit_userid = $_SESSION['admin_id'];
                $audit_name = $_SESSION['admin_nameaudit'];
                $audit_action = "Delete room with room ID: ".$room_id;
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}
        // Room deleted successfully, redirect back to admin dashboard
        header("Location: room_list.php");
        exit();
    } else {
        // Error handling for the query
        // You can log the error for debugging purposes or display an error message to the admin
        echo "Error deleting room: " . $conn->error;
        // Alternatively, you can redirect the admin to an error page
        // header("Location: error_page.php?message=" . urlencode("Error deleting room"));
        $conn->close();
        exit();
    }
} else {
    // Room ID not provided in the URL, handle the error (e.g., redirect to an error page)
    echo "Invalid request.";
    $conn->close();
    exit();
}
?>