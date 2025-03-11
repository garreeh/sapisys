<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  // Redirect to the login page if the user is not logged in
  header("Location: /appointment/views/login.php");
  exit();
}

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== "0") {
  // If the user is not an admin (is_admin is not set or not "1"), redirect to the user dashboard
  header("Location: /appointment/index.php"); // Adjust the redirect location as needed
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
</head>

<body id="page-top">
  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
      href="/appointment/views/admin/dashboard.php">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Animal<sup>Clinic</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="/appointment/views/admin/dashboard.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      User Panel
    </div>

    <li class="nav-item">
      <a class="nav-link" href="/appointment/views/user/pets_module.php">
        <i class="fas fa-fw fa-money-bill"></i>
        <span>My Pets</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/appointment/views/user/appointment_module.php">
        <i class="fas fa-fw fa-cart-plus"></i>
        <span>Set Appointment</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/appointment/views/user/billings_module.php">
        <i class="fas fa-fw fa-cart-plus"></i>
        <span>My Billings</span></a>
    </li>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->
    <!-- Heading -->
    <!-- <div class="sidebar-heading">
      Settings
    </div> -->

    <!-- <li class="nav-item">
      <a class="nav-link" href="/appointment/views/admin/settings_module.php">
        <i class="fas fa-fw fa-cog"></i>
        <span>Account Setting</span></a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
      <a class="nav-link" href="/appointment/controllers/logout_process.php">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Sign Out</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
  </ul>
  <!-- End of Sidebar -->
</body>

</html>