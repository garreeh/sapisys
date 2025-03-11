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

$sql = "SELECT * FROM vaccine";
$resultVaccination = mysqli_query($conn, $sql);

$vaccination_names = [];
if ($resultVaccination) {
  while ($row = mysqli_fetch_assoc($resultVaccination)) {
    $vaccination_names[] = $row;
  }
}

if (isset($_POST['vaccination_id'])) {
  $vaccination_id = $_POST['vaccination_id'];
  $sql = "SELECT * FROM vaccination WHERE vaccination_id = '$vaccination_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
?>
      <div class="modal fade" id="fetchDataVaccinationSolo" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Update Vaccination ID: <?php echo $row['vaccination_id']; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">

                <input type="hidden" class="form-control" id="vaccination_id" name="vaccination_id" value="<?php echo $row['vaccination_id'] ?>" required>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="vaccine_id">Service:</label>
                    <select class="form-control" id="vaccine_id" name="vaccine_id" required>
                      <option value="">Select Service</option>
                      <?php foreach ($vaccination_names as $vaccination_rows) : ?>
                        <option value="<?php echo $vaccination_rows['vaccine_id']; ?>"
                          <?php echo ($vaccination_rows['vaccine_id'] == $row['vaccine_id']) ? 'selected' : ''; ?>>
                          <?php echo $vaccination_rows['vaccine_name']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="expiration_date">Expiration Date:</label>
                    <input type="date" class="form-control" id="expiration_date" name="expiration_date" value="<?php echo $row['expiration_date'] ?>" required>

                  </div>
                </div>

                <input type="hidden" name="edit_vaccination" value="1">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="addCategoryButton">Add</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
  // Save Button in Edit Category
  $(document).ready(function() {
    $('#fetchDataVaccinationSolo form').submit(function(event) {
      event.preventDefault(); // Prevent default form submission
      // Store a reference to $(this)
      var $form = $(this);

      // Serialize form data
      var formData = $form.serialize();

      // Change button text to "Saving..." and disable it
      var $saveButton = $('#saveCategoryButton');
      $saveButton.text('Saving...');
      $saveButton.prop('disabled', true);

      // Send AJAX request
      $.ajax({
        type: 'POST',
        url: '/appointment/controllers/admin/edit_vaccine_solo_process.php',
        data: formData,
        success: function(response) {
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
            $('#fetchDataVaccinationSolo').modal('hide');
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
          // Handle error response
          console.error(xhr.responseText);
          Toastify({
            text: "Error occurred while editing category. Please try again later.",
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
      $('#vaccine_solo_table').DataTable().ajax.reload(null, false);
    }
  });
</script>