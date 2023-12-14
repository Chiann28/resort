<?php
require_once 'config.php';

session_start();
// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['room_id']) && isset($_GET['status'])) {
    $room_id = $_GET['room_id'];
    $status = $_GET['status'];

    // Perform the update query to change the room's status
    $update_sql = "UPDATE rooms SET status = '$status' WHERE room_id = '$room_id'";
    
    // Execute the update query
    if ($conn->query($update_sql) === TRUE) {
        // Redirect back to the page where you displayed the rooms

                $audit_userid = $_SESSION['admin_id'];
                $audit_name = $_SESSION['admin_nameaudit'];
                $audit_action = "Update room with ID: ".$room_id." status to ".$status;
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}

        header("Location: room_list.php");
        exit();
    } else {
        echo "Error updating room status: " . $conn->error;
        $conn->close();
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
