<?php
// Assuming you have established a database connection
require_once 'config.php';

session_start();
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $delete_user_id = $_POST['delete_user_id'];

    // Perform the delete query to delete the room from the database
    $delete_sql = "DELETE FROM users WHERE user_id = $delete_user_id";
    if ($conn->query($delete_sql) === TRUE) {


                $audit_userid = $_SESSION['admin_id'];
                $audit_name = $_SESSION['admin_nameaudit'];
                $audit_action = "Deleted user with ID: ".$delete_user_id;
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}
        // Room deleted successfully, redirect back to admin dashboard
        header("Location: admin_users.php");
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

   
    echo "Invalid request." . $conn->error;
    $conn->close();
    exit();
}
?>