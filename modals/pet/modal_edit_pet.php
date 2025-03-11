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

if (isset($_POST['pet_id'])) {
  $pet_id = $_POST['pet_id'];
  $sql = "SELECT * FROM pets WHERE pet_id = '$pet_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
?>
      <div class="modal fade" id="fetchDataPetModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Update Pet Details ID: <?php echo $row['pet_id']; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="pet_id" value="<?php echo $row['pet_id']; ?>">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="pet_name">Pet Name:</label>
                    <input type="text" class="form-control" id="pet_name" name="pet_name" value="<?php echo $row['pet_name'] ?>" placeholder="Enter your Pet Name" required>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="breed">Breed:</label>
                    <input type="text" class="form-control" id="breed" name="breed" value="<?php echo $row['breed'] ?>" placeholder="Enter Breed" required>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="species">Species:</label>
                    <select class="form-control" id="species" name="species" required>
                      <option value="" disabled>Select an option</option>
                      <option value="Canine" <?php echo ($row['species'] === 'Canine') ? 'selected' : ''; ?>>Canine</option>
                      <option value="Feline" <?php echo ($row['species'] === 'Feline') ? 'selected' : ''; ?>>Feline</option>
                    </select>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="birthdate">Birthdate:</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $row['birthdate'] ?>" required>
                  </div>
                </div>


                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="neutered">Neutered:</label>
                    <select class="form-control" id="neutered" name="neutered" required>
                      <option value="" disabled>Select an option</option>
                      <option value="Yes" <?php echo ($row['neutered'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                      <option value="No" <?php echo ($row['neutered'] == 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                  </div>
                </div>

                <!-- Add a hidden input field to submit the form with the button click -->
                <input type="hidden" name="edit_pet" value="1">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
                  <!-- <input type="hidden" name="item_id" value="</?php echo $row['pet_id']; ?>"> -->
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
  // Save Button in Edit Supplier
  $(document).ready(function() {
    $('#fetchDataPetModal form').submit(function(event) {
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
        url: '/appointment/controllers/users/edit_pet_process.php',
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
            $('#fetchDataPetModal').modal('hide');
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
          // Handle error response
          console.error(xhr.responseText);
          Toastify({
            text: "Error occurred while editing supplier. Please try again later.",
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
  });
</script>