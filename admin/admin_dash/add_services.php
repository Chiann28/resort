<?php


session_start();
require_once 'config.php';

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check if the room ID is provided in the URL
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $room_number = $_POST['room_number'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $type = $_POST['type'];

    // Perform form validation (you can add more validation as needed)
    if (empty($description) || empty($price)) {
        $error_message = "All fields are required.";
    } else {
        $picture_link = ''; // Initialize the picture link to an empty string
        
        
        $insert_sql = "INSERT INTO services (description, price, type)
                       VALUES ('$description', '$price', '$type')";
        if ($conn->query($insert_sql) === TRUE) {


                $audit_userid = $_SESSION['admin_id'];
                $audit_name = $_SESSION['admin_nameaudit'];
                $audit_action = "Added service with description".$description;
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}

            // Room added successfully, redirect back to admin dashboard or room list page
            echo '<script>window.parent.location.reload(); window.parent.closeAddPopup();</script>';
            exit();
        } else {
            // Error handling for the query
            $error_message = "Error adding service: " . $conn->error;
            echo '<script>console.error("' . $error_message . '");</script>';
        }
    }
}


?>

<style>
 
  body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 20px;
  }

  h2 {
    color: #333;
    margin-bottom: 20px;
  }

  label {
    display: block;
    margin-bottom: 10px;
  }

  input[type="text"],
  textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 16px;
  }
  input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 16px;
  }

  button[type="submit"],
  button[type="button"] {
    background-color: #00cc00;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
  }

  button[type="submit"] {
    margin-right: 10px;
  }

  button[type="button"] {
    background-color: #ccc;
  }

  .error-message {
    color: red;
    margin-bottom: 10px;
  }
</style>

<h2>Add Services</h2>

<!-- Form fields for editing data -->
<form action="" method="post" enctype="multipart/form-data">
    <!-- <label for="name">Room Number:</label>
    <input type="text" id="room_number" name="room_number" required><br> -->

    <label for="description">Services Description:</label>
    <input type="text" id="description" name="description" class="form-control" required><br>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" class="form-control"  required><br>

    <label for="type">Select Type</label>
    <select style='
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 16px;' id="type" name="type" id="type" class="form-control"  required>
      <option value="Service">Service</option>
      <option value="Amenities">Amenities</option>
    </select>

    <button type="submit" style="margin-top: 20px">Add Services</button>
</form>



