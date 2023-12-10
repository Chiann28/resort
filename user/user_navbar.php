

<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
  
<nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
<div class="container">
  <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span></span>
    <span></span>
    <span></span>
  </button>
  <a class="navbar-brand text-brand" href="user_dashboard.php">Kamantigue <span class="color-b">Beach Resort</span></a>

  <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link" href="user_dashboard.php">Home</a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="user_property_grid.php">Property</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="contact1.php">Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="news.php">News</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="user/user_login.html" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profile</a>
        <div class="dropdown-menu">
          <!-- <a class="dropdown-item" href="user_reservations.php">Cart</a> -->
          <a class="dropdown-item" href="my_reservations.php">My Transactions</a>
          <a class="dropdown-item" href="user_details.php">Account</a>
          <a class="dropdown-item" href="change_password.html">Security</a>
          <a class="dropdown-item" href="logout.php">Logout</a>
      </li>

      <a class="nav-link" href="user_reservations.php">
        <i class="fa fa-shopping-cart"></i>
        <sup id="cart-badge" class="badge badge-danger" style="color: red "></sup>
      </a>

    </ul>
  </div>


</div>
</nav>

</body>

<script>
    function updateCartBadge(reservation_count) {
    const cartBadge = document.getElementById("cart-badge");
    cartBadge.textContent = reservation_count.toString();
  }

    // Make an AJAX request to fetch the reservation count
    const xhr = new XMLHttpRequest();
  xhr.open("GET", "fetch_user_reservation.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const reservation_count = parseInt(xhr.responseText, 10);
      updateCartBadge(reservation_count);
    }
  };
  xhr.send();
  

</script>
</html>





