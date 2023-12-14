<?php

// Start the session

session_start();



// Check if the form is submitted

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];

    $password = $_POST['password'];



    // Replace with your database connection details

    // $servername = "localhost";

    // $dbusername = "root";

    // $dbpassword = "";

    // $dbname = "hotel_management";



    require_once 'config.php';



    // Create a database connection

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);



    // Check connection

    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    }



    // Query the database to validate admin credentials

    $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password' LIMIT 1";

    $result = $conn->query($sql);



    if ($result->num_rows == 1) {

         $row = $result->fetch_assoc();
        // Admin login successful

        $_SESSION['admin_logged_in'] = true;

        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['admin_nameaudit'] = $row['name'];

                $audit_userid = $_SESSION['admin_id'];
                $audit_name = $_SESSION['admin_nameaudit'];
                $audit_action = "Logged on";
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}

        header("Location: admin_dashboard.php");

        exit();

    } else {

        // Admin login failed

        header("Location: login_error.php");

        exit();

    }



    $conn->close();

}

?>