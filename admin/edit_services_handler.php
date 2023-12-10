<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Replace with your database connection details
    // $servername = "localhost";
    // $dbusername = "root";
    // $dbpassword = "";
    // $dbname = "hotel_management";

session_start();
    require_once 'config.php';

    // Create a database connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and retrieve the updated data from the POST request
    $services_number = $_POST['services_number'];
    $description = $_POST['description'];
    $price = $_POST['price'];


    // Prepare and execute the SQL query to update the data
    $sql = "UPDATE services SET description = '$description', price = '$price' WHERE services_number = '$services_number'";

    if ($conn->query($sql) === TRUE) {


                $audit_userid = $_SESSION['admin_id'];
                $audit_name = $_SESSION['admin_nameaudit'];
                $audit_action = "Edit service description and price of service with service number: ".$services_number;
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}
        // Data update successful
        header("Location: services_list.php");
        exit();
    } else {
        // Data update failed
        echo "Error updating data: " . $conn->error;
    }

    $conn->close();
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>