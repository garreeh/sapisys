<?php
include './../../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$user_id = isset($_GET['user_id']) ? htmlspecialchars($_GET['user_id']) : 'Unknown User';
$billing_id = isset($_GET['billing_id']) ? htmlspecialchars($_GET['billing_id']) : 'No Billing ID';

if ($user_id) {
  // Fetch user's name directly from the database
  $query = "SELECT user_fullname FROM users WHERE user_id = $user_id";
  $result = mysqli_query($conn, $query);

  // Check if a result is returned
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_name = $row['user_fullname'] ?? 'Unknown User';
  } else {
    $user_name = 'Unknown User';
  }
} else {
  $user_name = 'Unknown User';
}


if ($billing_id) {
  // Fetch user's name directly from the database
  $query = "SELECT * FROM billing WHERE billing_id = $billing_id";
  $result = mysqli_query($conn, $query);

  // Check if a result is returned
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $payment_status = $row['payment_status'];
  } else {
    $payment_status = 'Error Payment Status Fetch';
  }
} else {
  $payment_status = 'Error Payment Status Query';
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


  <title>Admin | Billings</title>

  <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


  <link href="./../../assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
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
    <?php include './../../modals/billing/modal_add_inside_billing.php'; ?>

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
            <h1 class="h3 mb-0 text-gray-800">Billing for <?php echo $user_name; ?></h1>
          </div>

          <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4" data-toggle="modal"
            data-target="#addBillModal"> <i class="fas fa-plus"></i> Add Particulars</a>
          <!-- <a href="./../../excels/supplier_export.php" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4"><i class="fas fa-file-excel"></i> Export Excel</a> -->

          <div class="row">
            <!-- Left Column: Table -->
            <div class="col-xl-8 col-lg-8">
              <div class="tab-pane fade show active" id="aa" role="tabpanel" aria-labelledby="aa-tab">
                <div class="table-responsive">
                  <div id="modalContainerItems"></div>
                  <table class="table custom-table table-hover" name="inside_billing_table" id="inside_billing_table">
                    <thead>
                      <tr>
                        <th>Particulars</th>
                        <th>Price</th>
                        <th>Manage</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>

            <!-- Right Column: Card -->
            <div class="col-xl-4 col-lg-4">
              <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Total Orders Summary</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="form-group">
                    <input type="hidden" id="billingID" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                    <label for="totalOrders">Total Items:</label>
                    <input type="text" id="totalOrders" class="form-control" value="0" readonly>
                  </div>
                  <div class="form-group">
                    <label for="totalPrice">Total Price:</label>
                    <input type="text" id="totalPrice" class="form-control" value="₱0.00" readonly>
                  </div>

                  <div class="form-group">
                    <label for="totalPrice">Status:</label>
                    <input type="text" id="paymentStatus" class="form-control" value="Unpaid" readonly>
                  </div>

                  <?php include './../../modals/billing/modal_add_payment.php'; ?>
                  <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4" data-toggle="modal"
                    data-target="#addPaymentModal"> <i class="fas fa-plus"></i> Add Payment</a>

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

<!-- COPY THESE WHOLE CODE WHEN IMPORT SELECT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
  integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
  integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<!-- Include Selectize CSS -->

<!-- Include jQuery and Selectize JS -->

<script>
  $(document).ready(function () {
    $('select').selectize({
      sortField: 'text'
    });
  });
</script>
<!-- END OF SELECT -->


<script>
  $('#sidebarToggle').click(function () {
    $('#inside_billing_table').css('width', '100%');
    // console.log(table) //This is for testing only
  });

  $(document).ready(function () {
    var user_id = "<?php echo $user_id; ?>"; // PHP variable to JavaScript

    var inside_billing_table = $('#inside_billing_table').DataTable({
      "pagingType": "numbers",
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "./../../controllers/tables/inside_billing_table.php",
        "type": "GET",
        "data": function (d) {
          // Send user_id as additional data with the request
          d.user_id = user_id;
        }
      },
    });

    window.reloadDataTable = function () {
      inside_billing_table.ajax.reload();
    };
  });


  $(document).ready(function () {
    // Function to handle click event on datatable rows
    $('#inside_billing_table').on('click', 'tr td:nth-child(3) .fetchDataDelete', function () {
      var bill_id = $(this).data('bill-id'); // Get table_id from data attribute

      $.ajax({
        url: './../../modals/billing/modal_delete_inside_item.php',
        method: 'POST',
        data: {
          bill_id: bill_id
        },
        success: function (response) {
          $('#bill_id').val(bill_id);
          $('#modalContainerItems').html(response);
          $('#deleteModalBill').modal('show');
          console.log("#deleteModalBill" + bill_id);
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });
  });



  $(document).ready(function () {
    fetchOrderSummary();
    // Function to fetch updated order summary
    function fetchOrderSummary() {
      var user_id = "<?php echo $user_id; ?>"
      var billing_id = "<?php echo $billing_id; ?>"

      $.ajax({
        url: './../../controllers/admin/fetch_order_summary_process.php', // Path to your PHP script
        method: 'GET',
        data: {
          user_id: user_id,
          billing_id: billing_id,
        },
        dataType: 'json',
        success: function (response) {
          // Update the order summary inputs with the fetched data
          $('#billingID').val(response.billing_id); // Update billing ID
          $('#totalOrders').val(response.total_items); // Update total items

          // Check if total_price is empty or not a valid number, and set it to 0
          var totalPrice = parseFloat(response.total_price);
          if (isNaN(totalPrice)) {
            totalPrice = 0; // Set total price to 0 if it's empty or invalid
          }

          // Format total price to ₱ and update the input
          $('#totalPrice').val('₱' + totalPrice.toFixed(2)); // Update total price (format to ₱)
        },
        error: function () {
          console.log('Error fetching order summary');
        }
      });
    }
  });


  $(document).ready(function () {
    fetchUpdatedPayment();
    // Function to fetch updated order summary
    function fetchUpdatedPayment() {
      var user_id = "<?php echo $user_id; ?>"
      var billing_id = "<?php echo $billing_id; ?>"

      $.ajax({
        url: './../../controllers/admin/fetch_payment_process.php', // Path to your PHP script
        method: 'GET',
        data: {
          user_id: user_id,
          billing_id: billing_id,
        },
        dataType: 'json',
        success: function (response) {
          $('#paymentStatus').val(response.payment_status); // Update total items
        },
        error: function () {
          console.log('Error fetching order summary');
        }
      });
    }
  });
</script>