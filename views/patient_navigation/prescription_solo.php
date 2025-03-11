<?php
$pet_id = isset($_GET['pet_id']) ? $_GET['pet_id'] : null;
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

?>

<!-- Modal for Adding and Editing Supplier -->
<?php include './../../modals/prescriptions/modal_add_prescription.php'; ?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
  <!-- Main Content -->
  <div id="content">
    <!-- Topbar -->

    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4" data-toggle="modal"
        data-target="#addPrescriptionModal"> <i class="fas fa-plus"></i> Add Prescription</a>
      <!-- <a href="./../../excels/supplier_export.php" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4"><i class="fas fa-file-excel"></i> Export Excel</a> -->

      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="tab-pane fade show active" id="aa" role="tabpanel" aria-labelledby="aa-tab">

            <div class="table-responsive">
              <div id="modalContainerCategory"></div>

              <table class="table custom-table table-hover" name="prescription_table" id="prescription_table">
                <thead>
                  <tr>
                    <th>Prescription ID</th>
                    <th>Prescription Notes</th>
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

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>
</body>

</html>

<script>
  $('#sidebarToggle').click(function () {
    $('#prescription_table').css('width', '100%');
    // console.log(table) //This is for testing only
  });

  $(document).ready(function () {
    // Handle tab switching and DataTable initialization
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href"); // Get the target tab's ID

      if (target === '#prescription') { // Check if it's the 2x2 Photo tab
        initPhotoTable(); // Initialize DataTable for photos
      }
    });

    function initPhotoTable() {
      // Check if the DataTable is already initialized to prevent reinitialization
      if (!$.fn.DataTable.isDataTable('#prescription_table')) {
        $('#prescription_table').DataTable({
          "pagingType": "numbers",
          "processing": true,
          "serverSide": true,
          "ajax": {
            url: "./../../controllers/tables/prescription_table.php",
            type: "GET",
            data: function (d) {
              d.pet_id = <?php echo $pet_id; ?>; // Pass prescription_id here
              d.user_id = <?php echo $user_id; ?>; // Pass prescription_id here
            }
          },
        });
      } else {
        $('#prescription_table').DataTable().ajax.reload(); // Reload if already initialized
      }
    }

    // Initialize on document load if the first tab is the 2x2 Photo tab
    if ($('a[data-toggle="tab"].active').attr('href') === '#prescription') {
      initPhotoTable();
    }

    // Event handler for column 5 click - dynamically fetch supplier details
    $('#prescription_table').on('click', 'tr td:nth-child(2) .fetchDataPrescription', function () {
      var prescription_id = $(this).closest('tr').find('td').first().text(); // Get prescription_id from the row
      $.ajax({
        url: './../../modals/prescriptions/modal_view_prescription.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          prescription_id: prescription_id
        },
        success: function (response) {
          $('#modalContainerCategory').html(response);
          $('#fetchDataPrescription').modal('show');
          console.log("#fetchDataPrescription" + prescription_id);
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });

    $('#prescription_table').on('click', 'tr td:nth-child(5) .fetchDataPres', function () {
      var prescription_id = $(this).closest('tr').find('td').first().text(); // Get prescription_id from the row
      $.ajax({
        url: './../../modals/prescriptions/modal_edit_prescription.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          prescription_id: prescription_id
        },
        success: function (response) {
          $('#modalContainerCategory').html(response);
          $('#editPrescriptionModal').modal('show');
          console.log("#editPrescriptionModal" + prescription_id);
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });

    $('#prescription_table').on('click', 'tr td:nth-child(5) .fetchDataPresDelete', function () {
      var prescription_id = $(this).closest('tr').find('td').first().text(); // Get prescription_id from the row
      $.ajax({
        url: './../../modals/prescriptions/modal_delete_prescription.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          prescription_id: prescription_id
        },
        success: function (response) {
          $('#modalContainerCategory').html(response);
          $('#deletePrescriptionModal').modal('show');
          console.log("#deletePrescriptionModal" + prescription_id);
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });
  });
</script>