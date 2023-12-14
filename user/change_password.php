<?php
session_start();

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate the form inputs
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Add additional validation as needed (e.g., password length, complexity, etc.)

    if ($newPassword !== $confirmPassword) {
        echo "New passwords do not match.";
        exit();
    }

    // Create a database connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $userId = $_SESSION['user_id']; // Assuming you have stored user ID in the session

    // Check if the current password matches the one in the database
    $checkPasswordQuery = "SELECT password FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($checkPasswordQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (password_verify($currentPassword, $row['password'])) {
        // Update the password in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updatePasswordQuery = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($updatePasswordQuery);
        $stmt->bind_param("si", $hashedPassword, $userId);
        $stmt->execute();

        echo "Password changed successfully.";
        header("Location: user_dashboard.php");
    } else {
        echo "Current password is incorrect.";
    }

    $conn->close();
} else {
    // Redirect to the change password form
    header("Location: change_password.html");
    exit();
}
?>
