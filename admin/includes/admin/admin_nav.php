<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
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
      href="/sapisys/admin/views/dashboard.php">
      <div class="sidebar-brand-icon">
        <i class="fas fa-building"></i>
      </div>
      <div class="sidebar-brand-text mx-3">St. <sup>Augustine</sup></div>
    </a>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="/sapisys/admin/views/dashboard.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Admin Panel
    </div>
    <!-- <li class="nav-item">
      <a class="nav-link" href="/appointment/views/admin/appointment_request_module.php">
        <i class="fas fa-fw fa-calendar-check"></i>
        <span>Appointment Request's</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/appointment/views/admin/appointment_approved_module.php">
        <i class="fas fa-fw fa-calendar-check"></i>
        <span>Appointment Ongoing</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/appointment/views/admin/appointment_archive_module.php">
        <i class="fas fa-fw fa-calendar-check"></i>
        <span>Appointment Archived</span></a>
    </li>


    <li class="nav-item">
      <a class="nav-link" href="/appointment/views/admin/patients_module.php">
        <i class="fas fa-fw fa-prescription-bottle-alt"></i>
        <span>Patients</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/appointment/views/admin/billing_module.php">
        <i class="fas fa-fw fa-money-bill"></i>
        <span>Billings</span></a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <!-- <div class="sidebar-heading">
      Reports, Appointment Setup
    </div> -->

    <!-- Reports Collapse -->
    <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true"
              aria-controls="collapse1">
              <i class="fas fa-fw fa-clipboard-list"></i>
              <span>Reports</span>
            </a>
            <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/appointment/views/admin/sales_report_module.php">Sales Report</a>
              </div>

            </div>

          </li> -->

    <!-- Products Setup Collapse -->
    <!-- <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2" aria-expanded="true"
        aria-controls="collapse2">
        <i class="fas fa-fw fa-clipboard-list"></i>
        <span>Appointment Setup</span>
      </a>
      <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="/appointment/views/admin/category_module.php">Services</a>
          <a class="collapse-item" href="/appointment/views/admin/timeslot_module.php">Timeslot</a>
          <a class="collapse-item" href="/appointment/views/admin/unavailable_module.php">Unavailable Dates</a>
        </div>

      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/appointment/views/admin/vaccine_module.php">
        <i class="fas fa-fw fa-calendar-check"></i>
        <span>Vaccine</span></a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
      User Settings
    </div>

    <li class="nav-item">
      <a class="nav-link" href="/sapisys/admin/views/user_type_module.php">

        <i class="fas fa-fw fa-calendar-check"></i>
        <span>User Type List</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/sapisys/admin/views/users_module.php">

        <i class="fas fa-fw fa-calendar-check"></i>
        <span>Users</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/sapisys/admin/views/clients_module.php">
        <i class="fas fa-fw fa-calendar-check"></i>
        <span>Clients</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
      <a class="nav-link" href="/sapisys/admin/controllers/logout_process.php">
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