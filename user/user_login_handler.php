<?php

// Start the session

session_start();







// Check if the form is submitted

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];

    $password = $_POST['password'];



    require_once 'config.php';



    // Create a database connection

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);



    // Check connection

    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    }



     // Create a database connection

     $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);



     // Check connection

     if ($conn->connect_error) {

         die("Connection failed: " . $conn->connect_error);

     }

 

     // Query the database to retrieve user data

     $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";

     $result = $conn->query($sql);

 

     if ($result->num_rows == 1) {

         $row = $result->fetch_assoc();

         $storedPassword = $row['password'];

         $isVerified = $row['verified'];

 

         if ($isVerified == 1) {

             // Verify the submitted password against the stored hashed password using password_verify()

             if (password_verify($password, $storedPassword)) {

                 // User login successful

                 $_SESSION['user_logged_in'] = true;

                 $_SESSION['user_id'] = $row['user_id'];
                 $_SESSION['user_nameaudit'] = $row['name'];

                $audit_userid = $_SESSION['user_id'];
                $audit_name = $_SESSION['user_nameaudit'];
                $audit_action = "Logged on";
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}


                 header("Location: user_dashboard.php");

                 exit();

             } else {

                 // User login failed

                 header("Location: login_error.php");

                 exit();

             }

         } else {

             // User is not verified, redirect with an error message

             header("Location: login_error.php");

             exit();

         }

     } else {

         // User not found

         header("Location: login_error.php");

         exit();

     }

 

     $conn->close();

 }

 ?>