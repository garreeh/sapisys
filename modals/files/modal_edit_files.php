<style>
  /* Custom CSS for label color */
  .modal-body label {
    color: #333;
    /* Darker label color */
    font-weight: bolder;
    /* Bolder font */
  }
</style>

<?php
include './../../connections/connections.php';

if (isset($_POST['file_id'])) {
  $file_id = $_POST['file_id'];
  $sql = "SELECT * FROM file_uploads WHERE file_id = '$file_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $file_path = basename($row['file_path']);
      $image_url = '../../uploads/files/' . $file_path; // Correct path to the image
      $file_name = $row['file_name'];
?>
      <div class="modal fade" id="fetchEditModal" tabindex="-1" role="dialog" aria-labelledby="fetchEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Update Files ID: <?php echo $row['file_id']; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form id="fileUploadForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="file_id" value="<?php echo $row['file_id']; ?>">

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="file_path">Files | Image:</label>
                    <input type="file" class="form-control" id="file_path" name="fileToUpload" accept="image/*">
                    <!-- Display existing image filename -->
                    <div class="file-info">
                      <?php if (!empty($file_path) && file_exists('../../uploads/files/' . $file_path)): ?>
                        <p><strong>Current Image: <?php echo $file_name ?></strong></p>
                      <?php else: ?>
                        <p>No image available.</p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <!-- Add a hidden input field to submit the form with the button click -->
                <input type="hidden" name="edit_files" value="1">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="saveCategoryButton">Save</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
<?php
    }
  }
}
?>

<script>
  $(document).ready(function() {
    $('#fileUploadForm').submit(function(event) {
      event.preventDefault(); // Prevent default form submission

      // Store a reference to $(this)
      var $form = $(this);
      var formData = new FormData($form[0]); // Use FormData to handle file upload

      // Change button text to "Saving..." and disable it
      var $saveButton = $('#saveCategoryButton');
      $saveButton.text('Saving...');
      $saveButton.prop('disabled', true);

      // Send AJAX request
      $.ajax({
        type: 'POST',
        url: '/appointment/controllers/admin/edit_files_process.php',
        data: formData,
        contentType: false, // Important for file uploads
        processData: false, // Important for file uploads
        success: function(response) {
          console.log(response); // Log the response for debugging
          response = JSON.parse(response);
          if (response.success) {
            Toastify({
              text: response.message,
              duration: 2000,
              backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
            }).showToast();

            // Optionally, close the modal
            $('#fetchEditModal').modal('hide');
            reloadDataTable();
          } else {
            Toastify({
              text: response.message,
              duration: 2000,
              backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
            }).showToast();
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          Toastify({
            text: "Error occurred while editing file. Please try again later.",
            duration: 2000,
            backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
          }).showToast();
        },
        complete: function() {
          // Reset button text and re-enable it
          $saveButton.text('Save');
          $saveButton.prop('disabled', false);
        }
      });
    });

    function reloadDataTable() {
      $('#files_table').DataTable().ajax.reload(null, false);
    }
  });
</script>