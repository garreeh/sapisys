<style>
  /* Custom CSS for label color */
  .modal-body label {
    color: #333;
    /* Darker label color */
    font-weight: bolder;
  }
</style>

<?php
include './../../connections/connections.php';

if (isset($_POST['unavailable_id'])) {
  $unavailable_id = $_POST['unavailable_id'];
  $sql = "SELECT * FROM unavailable_dates WHERE unavailable_id = '$unavailable_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="modal fade" id="fetchDataUnavailableModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Update Date Details ID: <?php echo $row['unavailable_id']; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="unavailable_id" value="<?php echo $row['unavailable_id']; ?>">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="unavailable_date">Unavailable Date:</label>
                    <input type="date" class="form-control" id="unavailable_date" name="unavailable_date"
                      value="<?php echo $row['unavailable_date']; ?>" required min="<?php echo date('Y-m-d'); ?>">
                    <!-- Inline disabling of past dates -->
                  </div>
                </div>

                <!-- Add a hidden input field to submit the form with the button click -->
                <input type="hidden" name="edit_dates" value="1">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
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
  $(document).ready(function () {
    document.addEventListener('DOMContentLoaded', function () {
      const dateInput = document.getElementById('unavailable_date');
      const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
      dateInput.setAttribute('min', today); // Set the min attribute to today's date
    });

    $('#fetchDataUnavailableModal form').submit(function (event) {
      event.preventDefault(); // Prevent default form submission
      // Store a reference to $(this)
      var $form = $(this);

      // Serialize form data
      var formData = $form.serialize();

      // Change button text to "Saving..." and disable it
      var $saveButton = $('#saveButton');
      $saveButton.text('Saving...');
      $saveButton.prop('disabled', true);

      // Send AJAX request
      $.ajax({
        type: 'POST',
        url: '/appointment/controllers/admin/edit_unavailable_process.php',
        data: formData,
        success: function (response) {
          // Handle success response
          console.log(response); // Log the response for debugging
          response = JSON.parse(response);
          if (response.success) {
            Toastify({
              text: response.message,
              duration: 2000,
              backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
            }).showToast();

            // Optionally, close the modal
            $('#fetchDataUnavailableModal').modal('hide');
            window.reloadDataTable();

          } else {
            Toastify({
              text: response.message,
              duration: 2000,
              backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
            }).showToast();
          }
        },
        error: function (xhr, status, error) {
          // Handle error response
          console.error(xhr.responseText);
          Toastify({
            text: "Error occurred while editing supplier. Please try again later.",
            duration: 2000,
            backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
          }).showToast();
        },
        complete: function () {
          // Reset button text and re-enable it
          $saveButton.text('Save');
          $saveButton.prop('disabled', false);
        }
      });
    });
  });
</script>