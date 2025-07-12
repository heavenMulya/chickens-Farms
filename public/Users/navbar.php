<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatFresh - Premium Chicken, Meat & Fresh Eggs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="fas fa-drumstick-bite"></i> MeatFresh</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php#home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php#products">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="my_orders.php">My Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php#contact">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link cart-icon" href="cart.php">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-badge" id="cart-count">0</span>
          </a>
        </li>

        <!-- User dropdown -->
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle d-flex align-items-center"
            href="#"
            id="userDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <i class="fas fa-user-circle fa-lg me-1"></i>
            <span id="navbar-username">Username</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="profile.html"><i class="fas fa-user me-2"></i> Profile</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item" href="#" id="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Sign Out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
 <script src="assets/js/jquery-3.6.0.min.js"></script>
<script>

         const token = localStorage.getItem('api_token'); // Or use sessionStorage
  if (!token) {
    window.location.href = "login.php"; // Redirect to login if not authenticated
  }
   const userId = localStorage.getItem('user_id');
    const userName = localStorage.getItem('user_name');
    // Or use sessionStorage
          
           $('#navbar-username').text(userName)
$(document).ready(function () {
  $('#logout-btn').on('click', function (e) {
    e.preventDefault();

    const token = localStorage.getItem('api_token');

    if (!token) {
      window.location.href = "login.php";
      return;
    }

    $.ajax({
      url: '/api/logout',
      method: 'POST',
      headers: {
        Authorization: 'Bearer ' + token,
      },
      success: function (res) {
        localStorage.removeItem('api_token');
        Swal.fire({
          icon: 'success',
          title: 'Signed Out',
          text: res.message,
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          window.location.href = 'login.php';
        });
      },
      error: function () {
        Swal.fire('Oops!', 'Something went wrong during logout.', 'error');
      }
    });
  });
});
</script>

    

