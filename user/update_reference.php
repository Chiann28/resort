<?php
    session_start();
    require_once 'config.php';
    $message = "";
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $payment_type =  $_REQUEST['type'];
        $user_id = $_SESSION['user_id'];

        $reference_number = $_POST['reference_num'];

        $validationchecker = 0;
        $sqlg = "SELECT * FROM reservations WHERE reference_number = '$reference_number'";
        $resultg = $conn->query($sqlg);
        if ($resultg->num_rows > 0) 
        {
            while ($rowg = $resultg->fetch_assoc()) 
            {
              $validationchecker++;
            }
        }

        if($validationchecker == 0)
        {
          $sql = "SELECT * FROM reservations WHERE user_id = '$user_id' AND status = 'Pending' AND reference_number IS NULL";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) 
          {
              while ($row = $result->fetch_assoc()) 
              {
                  $room_id = $row['room_id'];
                  $roomPrice = 0;
                  $origroomPrice = 0;

                  if($room_id != ''){
                    $roomQuery = "SELECT price FROM rooms WHERE room_id = '{$row['room_id']}'";
                    $roomResult = $conn->query($roomQuery);

                    if ($roomResult->num_rows > 0) {
                        $roomData = $roomResult->fetch_assoc();
                        $roomPrice = $roomData['price'];
                        $origroomPrice = $roomPrice;
                    }

                    if($payment_type == "half"){
                        $roomPrice = $roomPrice * 0.3;
                        
                    }
                  }else{
                    $roomPrice = $row['services_price'];
                    $origroomPrice = $row['services_price'];

                    if($payment_type == "half"){
                        $roomPrice = $roomPrice * 0.3;
                    }
                  }

                  if(isset($_SESSION['promo_percentage']) && $_SESSION['promo_percentage'] != '' && $payment_type != 'half')
                  {
                    $discount_percentage = $_SESSION['promo_percentage'];
                    $origroomPrice = $origroomPrice - ($origroomPrice * $discount_percentage);
                    $roomPrice = $roomPrice - ($roomPrice * $discount_percentage);
                  }


                  $reservation_id = $row['reservation_id'];
                  // Update the reference number in the reservations table
                  $sql = "UPDATE reservations SET reference_number = '$reference_number', payable_amount = '$origroomPrice', paid_amount = '$roomPrice' WHERE user_id = '$user_id' AND reservation_id = '$reservation_id'";

                  if ($conn->query($sql) === TRUE) {


                    $audit_userid = $_SESSION['user_id'];
                    $audit_name = $_SESSION['user_nameaudit'];
                    $audit_action = "Guest paid its reservation with reservation ID: ".$reservation_id." thru Gcash, payment reference #: ".$reference_number ;
                    $auditloginsert = "INSERT INTO audit (user_id, user_name, action_taken) VALUES ('$audit_userid', '$audit_name', '$audit_action')";
                    if ($conn->query($auditloginsert) === TRUE) {}

                    $message = "Your Payment Has Been Successfully Submitted";
                    header('Location: payment_success.php');
                  } 
                  else 
                  {
                      $error_message = "Error: " . $sql . "<br>" . $conn->error;
                      echo $error_message;
                      exit();
                  }
              }
          }
        }
        else
        {

        }
    }
?>