<?php
include './../../connections/connections.php';

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

  <title>Animal Clinic | Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Custom fonts for this template-->
  <link href="./../../assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="./../../assets/admin/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="./../../assets/admin/calendar/css/calendar.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include './../../includes/admin/admin_nav.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <?php include './../../includes/admin/admin_topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row">
            <div class="page-header">
              <div class="pull-right form-inline">
                <div class="btn-group">
                  <button class="btn btn-primary" data-calendar-nav="prev">
                    << Prev</button> <button class="btn btn-default" data-calendar-nav="today">Today
                      </button>
                      <button class="btn btn-primary" data-calendar-nav="next">Next >></button>
                </div>
                <div class="btn-group" style="padding-left: 1rem;">
                  <button class="btn btn-primary" data-calendar-view="year">Year</button>
                  <button class="btn btn-primary active" data-calendar-view="month">Month</button>
                  <button class="btn btn-primary" data-calendar-view="week">Week</button>
                  <!-- <button class="btn primary-warning" data-calendar-view="day">Day</button> -->
                </div>
              </div>
              <strong>
                <br>

                <h1 style="font-weight:bold;">Today is: <span id="clockAndDate" style="font-weight:bold;"></span> <span id="current-day" style="font-weight:bold;"></span></h1>

                <script>
                  // Get today's date
                  const today = new Date();

                  // Array of weekday names
                  const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

                  // Get the current day name and date
                  const dayName = daysOfWeek[today.getDay()];
                  const dayDate = today.getDate();

                  // Display in format "26 Saturday"
                  document.getElementById('current-day').textContent = `(${dayName})`;
                </script>

                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                  <h3 class="h1 mb-0 font-weight-bold text-gray-800" style="font-weight:bold; color:goldenrod"></h3>
                </div>

              </strong>
            </div>
            <div class="table-responsive">
              <div class="row">
                <div class="col-md-12">
                  <div id="showEventCalendar"></div>
                </div>
                <div class="col-md-3">
                  <!-- <h4>All Events List</h4>
				<ul id="eventlist" class="nav nav-list"></ul> -->
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="./../../assets/admin/vendor/jquery/jquery.min.js"></script>
  <script src="./../../assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="./../../assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="./../../assets/admin/js/sb-admin-2.min.js"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>

  <script type="text/javascript" src="./../../assets/admin/calendar/js/calendar.js"></script>
  <script type="text/javascript" src="./../../assets/admin/calendar/js/events.js"></script>

  <!-- Page level plugins -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>

</html>

<!-- Running Clock Script -->
<script>
  function updateClockAndDate() {
    var now = new Date();
    var hours = now.getHours();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12; // Convert 24-hour time to 12-hour time
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var month = monthNames[now.getMonth()];
    var day = now.getDate();
    var year = now.getFullYear();

    // Format the time (add leading zero if needed)
    var formattedTime = hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds + " " + ampm;

    // Format the date
    var formattedDate = month + " " + day + ", " + year;

    // Update the clock and date elements
    document.getElementById("clockAndDate").innerText = formattedDate;


    // Update the clock and date every second
    setTimeout(updateClockAndDate, 1000);
  }

  // Initial call to start the clock and date
  updateClockAndDate();
</script>