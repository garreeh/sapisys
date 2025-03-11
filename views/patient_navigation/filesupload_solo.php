<?php
$pet_id = isset($_GET['pet_id']) ? $_GET['pet_id'] : null;
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

?>

<!-- Modal for Adding and Editing Supplier -->
<?php include './../../modals/files/modal_add_files.php'; ?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
  <!-- Main Content -->
  <div id="content">
    <!-- Topbar -->

    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4" data-toggle="modal"
        data-target="#AddFilesModal"> <i class="fas fa-plus"></i> Add Files </a>
      <!-- <a href="./../../excels/supplier_export.php" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mb-4"><i class="fas fa-file-excel"></i> Export Excel</a> -->

      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="tab-pane fade show active" id="aa" role="tabpanel" aria-labelledby="aa-tab">

            <div class="table-responsive">
              <div id="modalContainerEditFiles"></div>
              <div id="modalContainerViewFiles"></div>

              <table class="table custom-table table-hover" name="files_table" id="files_table">
                <thead>
                  <tr>
                    <th>File ID</th>
                    <th>File Name</th>
                    <th>File View</th>
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
    $('#files_table').css('width', '100%');
    // console.log(table) //This is for testing only
  });

  $(document).ready(function () {
    // Handle tab switching and DataTable initialization
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href"); // Get the target tab's ID

      if (target === '#files') { // Check if it's the 2x2 Photo tab
        initPhotoTable(); // Initialize DataTable for photos
      }
    });

    function initPhotoTable() {
      // Check if the DataTable is already initialized to prevent reinitialization
      if (!$.fn.DataTable.isDataTable('#files_table')) {
        $('#files_table').DataTable({
          "pagingType": "numbers",
          "processing": true,
          "serverSide": true,
          "ajax": {
            url: "./../../controllers/tables/files_table.php",
            type: "GET",
            data: function (d) {
              d.pet_id = <?php echo $pet_id; ?>; // Pass file_id here
              d.user_id = <?php echo $user_id; ?>; // Pass file_id here
            }
          },
        });
      } else {
        $('#files_table').DataTable().ajax.reload(); // Reload if already initialized
      }
    }

    // Initialize on document load if the first tab is the 2x2 Photo tab
    if ($('a[data-toggle="tab"].active').attr('href') === '#files') {
      initPhotoTable();
    }

    $('#files_table').on('click', 'tr td:nth-child(3) .fetchDataFilesView', function () {
      var file_id = $(this).closest('tr').find('td').first().text(); // Get file_id from the row
      $.ajax({
        url: './../../modals/files/modal_view_files.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          file_id: file_id
        },
        success: function (response) {
          $('#modalContainerViewFiles').html(response);
          $('#viewImageFiles').modal('show');
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });

    $('#files_table').on('click', 'tr td:nth-child(6) .fetchDataPres', function () {
      var file_id = $(this).closest('tr').find('td').first().text(); // Get file_id from the row
      $.ajax({
        url: './../../modals/files/modal_edit_files.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          file_id: file_id
        },
        success: function (response) {
          $('#modalContainerEditFiles').html(response);
          $('#fetchEditModal').modal('show');
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });

    $('#files_table').on('click', 'tr td:nth-child(6) .fetchDataPresDelete', function () {
      var file_id = $(this).closest('tr').find('td').first().text(); // Get file_id from the row
      $.ajax({
        url: './../../modals/files/modal_delete_files.php', // Path to PHP script to fetch modal content
        method: 'POST',
        data: {
          file_id: file_id
        },
        success: function (response) {
          $('#modalContainerEditFiles').html(response);
          $('#fetchDeleteModal').modal('show');
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });
  });
</script>