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

if (isset($_POST['user_type_id'])) {
  $user_type_id = $_POST['user_type_id'];
  $sql = "SELECT * FROM usertype WHERE user_type_id = '$user_type_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
?>
      <div class="modal fade" id="fetchDataUsertypeModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Update User Type Details ID: <?php echo $row['user_type_id']; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_type_id" value="<?php echo $row['user_type_id']; ?>">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="user_type_name">User Type:</label>
                    <input type="text" class="form-control" id="user_type_name" name="user_type_name" placeholder="Enter User Type" value="<?php echo $row['user_type_name']; ?>" required>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="appointments_module">Appointments:</label>
                    <select class="form-control" id="appointments_module" name="appointments_module">
                      <option value="1" <?php echo $row['appointments_module'] == 1 ? 'selected' : ''; ?>>Yes</option>
                      <option value="0" <?php echo $row['appointments_module'] == 0 ? 'selected' : ''; ?>>No</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="patient_module">Patient Module:</label>
                    <select class="form-control" id="patient_module" name="patient_module">
                      <option value="1" <?php echo $row['patient_module'] == 1 ? 'selected' : ''; ?>>Yes</option>
                      <option value="0" <?php echo $row['patient_module'] == 0 ? 'selected' : ''; ?>>No</option>
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="reports_module">Reports Module:</label>
                    <select class="form-control" id="reports_module" name="reports_module">
                      <option value="1" <?php echo $row['reports_module'] == 1 ? 'selected' : ''; ?>>Yes</option>
                      <option value="0" <?php echo $row['reports_module'] == 0 ? 'selected' : ''; ?>>No</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="user_module">User Module:</label>
                    <select class="form-control" id="user_module" name="user_module">
                      <option value="1" <?php echo $row['user_module'] == 1 ? 'selected' : ''; ?>>Yes</option>
                      <option value="0" <?php echo $row['user_module'] == 0 ? 'selected' : ''; ?>>No</option>
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="billing_module">Billing Module:</label>
                    <select class="form-control" id="billing_module" name="billing_module">
                      <option value="1" <?php echo $row['billing_module'] == 1 ? 'selected' : ''; ?>>Yes</option>
                      <option value="0" <?php echo $row['billing_module'] == 0 ? 'selected' : ''; ?>>No</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="appointment_setup_module">Appointment Setup Module:</label>
                    <select class="form-control" id="appointment_setup_module" name="appointment_setup_module">
                      <option value="1" <?php echo $row['appointment_setup_module'] == 1 ? 'selected' : ''; ?>>Yes</option>
                      <option value="0" <?php echo $row['appointment_setup_module'] == 0 ? 'selected' : ''; ?>>No</option>
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="vaccine_module">Vaccine Module:</label>
                    <select class="form-control" id="vaccine_module" name="vaccine_module">
                      <option value="1" <?php echo $row['vaccine_module'] == 1 ? 'selected' : ''; ?>>Yes</option>
                      <option value="0" <?php echo $row['vaccine_module'] == 0 ? 'selected' : ''; ?>>No</option>
                    </select>
                  </div>
                </div>

                <input type="hidden" name="edit_user_type" value="1">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn btn-danger" data-dismiss="modal">Close</button>
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
  // Save Button in Edit User Type
  $(document).ready(function() {
    $('#fetchDataUsertypeModal form').submit(function(event) {
      event.preventDefault(); // Prevent default form submission

      var $form = $(this);
      var $button = $form.find('button[type="submit"]'); // Reference to the submit button

      // Change button text to 'Saving...' and disable it
      $button.text('Saving...').prop('disabled', true);

      // Serialize form data
      var formData = $form.serialize();

      // Send AJAX request
      $.ajax({
        type: 'POST',
        url: '/appointment/controllers/admin/edit_usertype_process.php',
        data: formData,
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
            $('#fetchDataUsertypeModal').modal('hide');
            window.reloadDataTable();
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
            text: "Error occurred while editing user type. Please try again later.",
            duration: 2000,
            backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
          }).showToast();
        },
        complete: function() {
          // Reset button text and re-enable it
          $button.text('Save').prop('disabled', false);
        }
      });
    });
  });
</script>