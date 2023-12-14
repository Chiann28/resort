<?php
session_start();

require_once 'config.php';

// Create a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);


// Get the promo code submitted by the user
if (isset($_POST['promo_code']) && !empty($_POST['promo_code'])) {
    $promoCode = $_POST['promo_code'];
    $totalPrice = $_SESSION['initialPrice'];

    // Query the database to check if the promo code exists
    $promoQuery = "SELECT promo_discount FROM promocode WHERE promo_code =  ?";
    $stmt = $conn->prepare($promoQuery);
    $stmt->bind_param("s", $promoCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $promoDiscount = $row['promo_discount'];

        $_SESSION['promo_percentage'] = $promoDiscount / 100; // get the % of the promo so if its 10 and get the % it will be 0.01
        // Calculate the discount
        $newTotalPrice = $totalPrice - ($totalPrice * ($promoDiscount / 100));

        $_SESSION['updatedPrice'] = $newTotalPrice;


                $audit_userid = $_SESSION['user_id'];
                $audit_name = $_SESSION['user_nameaudit'];
                $audit_action = "Used PROMO with promo code: ".$promoCode;
                $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                if ($conn->query($auditloginsert) === TRUE) {}

        // Store the updated total price in a session variable or update it in the database

        // Redirect back to the user_reservations page
        header("Location: admin_reservations.php");
        exit();
    } else {
        // Promo code not found, display an error message
        echo "Invalid promo code. Please try again.";
        echo $promoCode;
    }
}
?>