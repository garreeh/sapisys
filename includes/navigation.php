<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// if (isset($_SESSION['user_id'])) {
//   if (!isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == "1") {
//       // If the user is an admin, redirect to the admin dashboard
//       header("Location: /appointment/views/admin/dashboard.php.php");
//   } else {
//       // If the user is not an admin, redirect to the user dashboard
//       header("Location: /appointment/index.php");
//   }
//   exit();
// }

?>

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
  <div class="container">
    <a class="navbar-brand" href="index.php">Animal <span>Clinic</span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="oi oi-menu"></span> Menu
    </button>

    <div class="collapse navbar-collapse" id="ftco-nav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="chatbot.php" class="nav-link">Chatbot</a></li>
        <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
        <li class="nav-item"><a href="./views/login.php" class="nav-link">Login</a></li>

      </ul>
    </div>
  </div>
</nav>