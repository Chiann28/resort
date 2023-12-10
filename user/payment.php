<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Hotel Management and Reservation System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!--   Vendor CSS Files 
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <!-- <link href="assets/css/style.css" rel="stylesheet"> -->

  <style>
    .holder {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f4f4f4;
}

.payment-container {
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  border-radius: 8px;
  width: 400px;
}

h1 {
  text-align: center;
}

.reservation-details {
  margin-bottom: 20px;
}

.payment-form {
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 6px;
}

input {
  padding: 8px;
  margin-bottom: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  padding: 10px;
  background-color: #4caf50;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

button:hover {
  background-color: #45a049;
}
  </style>

</head>

<body>

<div class="holder">
  <div class="payment-container">
    <h1>Reservation Payment</h1>

    <div class="reservation-details">
      <p>Reservation Details:</p>
      <!-- Include reservation details dynamically based on your system -->
      <p>Room: Standard Room</p>
      <p>Check-in Date: 2023-12-01</p>
      <p>Check-out Date: 2023-12-05</p>
      <p>Total Amount: $500.00</p>
    </div>

    <div class="payment-form">
      <label for="cardNumber">Card Number:</label>
      <input type="text" id="cardNumber" placeholder="Card Number" data-paymongo="cardNumber">

      <label for="expiry">Expiry:</label>
      <input type="text" id="expiry" placeholder="MM/YY" data-paymongo="expiry">

      <label for="cvc">CVC:</label>
      <input type="text" id="cvc" placeholder="CVC" data-paymongo="cvc">

      <button id="payButton">Pay Now</button>
    </div>
  </div>
</div>
  <script src="https://js.paymongo.com/v2/"></script>

</body>
</html>