<?php
include './../../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_GET['pet_id'])) {
  $pet_id = $_GET['pet_id'];
  $sql = "SELECT * FROM pets 
          LEFT JOIN users ON pets.user_id = users.user_id
          WHERE pet_id = '$pet_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    $pets = mysqli_fetch_assoc($result);
  }
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


  <title>Admin | Patient Solo</title>

  <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <link href="./../../assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
  <link href="./../../assets/admin/css/sb-admin-2.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
    integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include './../../includes/admin/admin_nav.php'; ?>
    <!-- End of Sidebar -->

    <!-- Modal for Adding and Editing Supplier -->


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <?php include './../../includes/admin/admin_topbar.php'; ?>

        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Client Details Card -->
          <?php if (isset($pets)): ?>
            <div class="card mb-4">
              <div class="card-header">
                <h4><strong>Pet ID: <?php echo $pets['pet_id']; ?></strong></h4>
              </div>
              <div class="card-body">
                <!-- Form for client details -->
                <form id="clientDetailsForm">
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <label for="client_name" class="form-label"><strong>Pet Name:</strong></label>
                      <input type="text" id="client_name_<?php echo $client_id; ?>" class="form-control"
                        value="<?php echo $pets['pet_name']; ?>" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="address" class="form-label"><strong>Species:</strong></label>
                      <input type="text" id="address_<?php echo $client_id; ?>" class="form-control"
                        value="<?php echo $pets['species']; ?>" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="mobile_number" class="form-label"><strong>Breed:</strong></label>
                      <input type="text" id="mobile_number_<?php echo $client_id; ?>" class="form-control"
                        value="<?php echo $pets['breed']; ?>" readonly>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="email" class="form-label"><strong>Owner:</strong></label>
                      <input type="text" id="email_<?php echo $client_id; ?>" class="form-control"
                        value="<?php echo $pets['user_fullname']; ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="birthday" class="form-label"><strong>Birthdate:</strong></label>
                      <input type="text" id="birthday_<?php echo $client_id; ?>" class="form-control"
                        value="<?php echo date('F j, Y', strtotime($pets['birthdate'])); ?>" readonly>
                    </div>
                  </div>
                </form>
              </div>
            </div>


            <!-- Tabs -->
            <div class="mb-4">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="prescription-tab" data-toggle="tab" href="#prescription" role="tab"
                    aria-controls="prescription" aria-selected="true">Prescriptions</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="vaccination-tab" data-toggle="tab" href="#vaccination" role="tab"
                    aria-controls="vaccination" aria-selected="false">Vaccines</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files"
                    aria-selected="false">Upload Files</a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false">Proof of Income</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Proof of Billing</a>
                </li> -->
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="prescription" role="tabpanel"
                  aria-labelledby="prescription-tab">
                  <br>
                  <?php include '../patient_navigation/prescription_solo.php' ?>
                </div>
                <div class="tab-pane fade" id="vaccination" role="tabpanel" aria-labelledby="vaccination-tab">
                  <br>
                  <?php include '../patient_navigation/vaccination_solo.php' ?>
                </div>
                <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                  <br>
                  <?php include '../patient_navigation/filesupload_solo.php' ?>
                </div>
                <!-- <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                  <br>
                  </?php include '../../documents/document_proofofincome.php' ?>
                </div>
                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                  <br>
                  </?php include '../../documents/document_proofofbilling.php' ?>
                </div> -->
              </div>
            </div>
          <?php else: ?>
            <p>No client details found.</p>
          <?php endif; ?>

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

  <!-- COPY THESE WHOLE CODE WHEN IMPORT SELECT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
    integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
    integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

  <script>
    $(document).ready(function () {
      $('select').selectize({
        sortField: 'text'
      });
    });
  </script>
  <!-- END OF SELECT -->



</body>

</html>

<script>
  $('#sidebarToggle').click(function () {
    $('#patients_table').css('width', '100%');
    // console.log(table) //This is for testing only
  });

  //Table for Product
  $(document).ready(function () {
    var patients_table = $('#patients_table').DataTable({
      "pagingType": "numbers",
      "processing": true,
      "serverSide": true,
      "ajax": "./../../controllers/tables/patients_table.php",
    });

    window.reloadDataTable = function () {
      patients_table.ajax.reload();
    };

  });
</script>