<?php
// Include necessary files and perform session validation

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
if (isset($_GET['id'])) {
    $inquiryId = $_GET['id'];

    // Fetch all inquiries from the database
    $query = "SELECT subject, message, name, email FROM inquiries WHERE id = $inquiryId";
    $result = $conn->query($query);



    // Fetch inquiry details from the database using the inquiry ID
    // You can use the $inquiryId in your SQL query to retrieve the details

    // Return the inquiry details as JSON response
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Return the inquiry details as JSON response
        $inquiryDetails = array(
            'subject' => $row['subject'],
            'message' => $row['message'],
            'name' => $row['name'],
            'email' => $row['email']
            // ... other details ...
        );
    
    echo json_encode($inquiryDetails);
    } else {
        echo json_encode(array('error' => 'Invalid inquiry ID'));
    }  
}
?>