<?php
$pet_id = isset($_GET['pet_id']) ? $_GET['pet_id'] : null;
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

$sql = "SELECT * FROM vaccine";
$resultVaccination = mysqli_query($conn, $sql);

$vaccination_names = [];
if ($resultVaccination) {
  while ($row = mysqli_fetch_assoc($resultVaccination)) {
    $vaccination_names[] = $row;
  }
}

?>

<!-- Modal for Adding and Editing Supplier -->
<?php include './../../modals/vaccination/modal_add_vaccination_solo.php'; ?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
  <!-- Main Content -->
  <div id="content">
    <!-- Topbar -->

    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4" data-toggle="modal" data-target="#addVaccineSoloModal"> <i class="fas fa-plus"></i> Add Vaccination</a> -->
      <!-- <a href="./../../excels/supplier_export.php" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4"><i class="fas fa-file-excel"></i> Export Excel</a> -->

      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="tab-pane fade show active" id="aa" role="tabpanel" aria-labelledby="aa-tab">

            <div class="table-responsive">
              <div id="modalContainer"></div>

              <table class="table custom-table table-hover" name="vaccine_solo_table" id="vaccine_solo_table">
                <thead>
                  <tr>
                    <th>Vaccine ID</th>
                    <th>Vaccine Name</th>
                    <th>Expiration Date</th>
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
  $('#sidebarToggle').click(function() {
    $('#vaccine_solo_table').css('width', '100%');
    // console.log(table) //This is for testing only
  });

  $(document).ready(function() {
    // Handle tab switching and DataTable initialization
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
      var target = $(e.target).attr("href"); // Get the target tab's ID

      if (target === '#vaccination') { // Check if it's the 2x2 Photo tab
        initPhotoTable(); // Initialize DataTable for photos
      }
    });

    function initPhotoTable() {
      // Check if the DataTable is already initialized to prevent reinitialization
      if (!$.fn.DataTable.isDataTable('#vaccine_solo_table')) {
        $('#vaccine_solo_table').DataTable({
          "pagingType": "numbers",
          "processing": true,
          "serverSide": true,
          "ajax": {
            url: "./../../controllers/tables/vaccine_solo_table.php",
            type: "GET",
            data: function(d) {
              d.pet_id = <?php echo $pet_id; ?>; // Pass vaccination_id here
              d.user_id = <?php echo $user_id; ?>; // Pass vaccination_id here
            }
          },
        });
      } else {
        $('#vaccine_solo_table').DataTable().ajax.reload(); // Reload if already initialized
      }
    }

    // Initialize on document load if the first tab is the 2x2 Photo tab
    if ($('a[data-toggle="tab"].active').attr('href') === '#vaccination') {
      initPhotoTable();
    }

    // Event handler for column 5 click - dynamically fetch supplier details
    $('#vaccine_solo_table').on('click', 'tr td:nth-child(6) .fetchDataVaccination', function() {
      var vaccination_id = $(this).closest('tr').find('td').first().text(); // Get vaccination_id from the row
      $.ajax({
        url: './../../modals/vaccination/modal_edit_vaccination_solo.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          vaccination_id: vaccination_id
        },
        success: function(response) {
          $('#modalContainer').html(response);
          $('#fetchDataVaccinationSolo').modal('show');
          console.log("#fetchDataVaccinationSolo" + vaccination_id);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });
  });
</script>