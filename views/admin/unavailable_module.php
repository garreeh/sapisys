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
  <link href="./../../assets/img/favicon.ico" rel="icon">


  <title>Admin | Set Appointment</title>

  <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


  <link href="./../../assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="./../../assets/admin/css/sb-admin-2.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include './../../includes/admin/admin_nav.php'; ?>
    <!-- End of Sidebar -->

    <!-- Modal for Adding and Editing Supplier -->
    <?php include './../../modals/unavailable/modal_add_dates.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <?php include './../../includes/admin/admin_topbar.php'; ?>

        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Set Unavailable Dates Module</h1>
          </div>

          <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4" data-toggle="modal" data-target="#addUnavailableDateModal"> <i class="fas fa-plus"></i> Add Date</a>
          <!-- <a href="./../../excels/supplier_export.php" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4"><i class="fas fa-file-excel"></i> Export Excel</a> -->

          <div class="row">
            <div class="col-xl-12 col-lg-12">
              <div class="tab-pane fade show active" id="aa" role="tabpanel" aria-labelledby="aa-tab">

                <div class="table-responsive">
                  <div id="modalContainerSupplier"></div>

                  <table class="table custom-table table-hover" name="unavailable_table" id="unavailable_table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Date Closed</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        <th>Manage</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.container-fluid -->
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

  <script src="./../../assets/admin/vendor/jquery/jquery.min.js"></script>
  <script src="./../../assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="./../../assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="./../../assets/admin/js/sb-admin-2.min.js"></script>

  <!-- Data tables -->
  <link rel="stylesheet" type="text/css" href="./../../assets/datatables/datatables.min.css" />
  <script type="text/javascript" src="./../../assets/datatables/datatables.min.js"></script>



</body>

</html>

<script>
  $('#sidebarToggle').click(function() {
    $('#unavailable_table').css('width', '100%');
    // console.log(table) //This is for testing only
  });

  //Table for Supplier
  $(document).ready(function() {
    var unavailable_table = $('#unavailable_table').DataTable({
      "pagingType": "numbers",
      "processing": true,
      "serverSide": true,
      "ajax": "./../../controllers/tables/unavailable_table.php",
    });

    window.reloadDataTable = function() {
      unavailable_table.ajax.reload();
    };

  });

  //Column 5
  $(document).ready(function() {
    // Function to handle click event on datatable rows
    $('#unavailable_table').on('click', 'tr td:nth-child(5) .fetchDataSupplier', function() {
      var unavailable_id = $(this).closest('tr').find('td').first().text(); // Get the user_id from the clicked row

      $.ajax({
        url: './../../modals/unavailable/modal_edit_dates.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          unavailable_id: unavailable_id
        },
        success: function(response) {
          $('#modalContainerSupplier').html(response);
          $('#fetchDataUnavailableModal').modal('show');
          console.log("#fetchDataUnavailableModal" + unavailable_id);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });
  });
</script>