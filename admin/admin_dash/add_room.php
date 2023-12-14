<?php


session_start();
require_once 'config.php';

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check if the room ID is provided in the URL
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = $_POST['room_number'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Perform form validation (you can add more validation as needed)
    if (empty($room_number) || empty($description) || empty($price)) {
        $error_message = "All fields are required.";
    } else {
        $picture_link = ''; // Initialize the picture link to an empty string
        
        // Handle file upload
        if (!empty($_FILES['room_picture']['name'])) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $uploadPath = '../assets/img/rooms/'; // Path to your upload directory

            $uploadedFile = $_FILES['room_picture']['tmp_name'];
            $uploadedFileName = $_FILES['room_picture']['name'];
            $uploadedFileExtension = strtolower(pathinfo($uploadedFileName, PATHINFO_EXTENSION));

            // Check if the uploaded file extension is allowed
            if (in_array($uploadedFileExtension, $allowedExtensions)) {
                // Generate a unique filename
                $newFileName = uniqid() . '.' . $uploadedFileExtension;
                $filenameWithoutExtension = uniqid() . '.php';


                // Move the uploaded file to the desired location
                $destination = $uploadPath . $newFileName;
                move_uploaded_file($uploadedFile, $destination);
                
                // Set the picture link to the new file name
                $picture_link = $newFileName;


                // Source file path
                $sourceFile = '../rooms/template.php';

                // Destination file path
                $destinationFile = '../rooms/new_file.php';

                // Copy the source file to the destination
                if (copy($sourceFile, $destinationFile)) {
                  // Rename the destination file
                  $newName = '../rooms/'.$filenameWithoutExtension;
                  if (rename($destinationFile, $newName)) {
                      echo 'File copied and renamed successfully.';
                  } else {
                      echo 'Failed to rename the file.';
                  }
                } else {
                  echo 'Failed to copy the file.';
}




            }
        }
        
        // Insert the new room into the database
        $insert_sql = "INSERT INTO rooms (room_number, description, price, picture_link, site_link)
                       VALUES ('$room_number', '$description', '$price', '$picture_link', '$filenameWithoutExtension')";
        if ($conn->query($insert_sql) === TRUE) {


                $audit_userid = $_SESSION['admin_id'];
                $audit_name = $_SESSION['admin_nameaudit'];
                $audit_action = "Added room with room number: ".$room_number;
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}
            // Room added successfully, redirect back to admin dashboard or room list page
            echo '<script>window.parent.location.reload(); window.parent.closeAddPopup();</script>';
            exit();
        } else {
            // Error handling for the query
            $error_message = "Error adding room: " . $conn->error;
        }
    }
}


?>

<style>
  /* Your CSS for the iframe content here */
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

<h2>Add Room</h2>

<!-- Form fields for editing data -->
<form action="" method="post" enctype="multipart/form-data">
    <label for="name">Room Number:</label>
    <input type="text" id="room_number" name="room_number" required><br>

    <label for="description">Description:</label>
    <input type="text" id="description" name="description" required><br>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" required><br>

    <label for="room_picture">Room Picture (800x600 pixels):</label>
    <input type="file" id="room_picture" name="room_picture" accept=".jpg, .jpeg, .png" required>

    <button type="submit">Add Room</button>
    <button type="button" onclick="closeAddPopup()">Cancel</button>
</form>



