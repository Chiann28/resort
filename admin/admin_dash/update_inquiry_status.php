<?php

// Assuming you have established a database connection


session_start();



require_once 'config.php';





session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {

    header("Location: admin_login.html");

    exit();

}



$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);



  // Check connection

  if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}





if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {

    $inquiryId = $_GET['id'];

    $status = $_POST['status']; // "viewed"



    $updateStatusQuery = "UPDATE inquiries SET status = ? WHERE id = ?";

    





    // Prepare the statement

    $stmt = $conn->prepare($updateStatusQuery);

    if ($stmt === false) {

        echo json_encode(array('error' => 'Statement preparation error'));

        exit();

    }

    

    // Bind parameters

    $stmt->bind_param("ii", $status, $inquiryId);

    

    // Execute the statement

    if ($stmt->execute()) {

        // Return a success response

        echo json_encode(array('success' => true));

    } else {

        // Return an error response

        echo json_encode(array('error' => 'Update failed'));

    }

    

    // Close the statement

    $stmt->close();

} else {

    echo json_encode(array('error' => 'Invalid request'));

}



// Close the connection

$conn->close();

?>

