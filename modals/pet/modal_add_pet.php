<style>
  /* Custom CSS for label color */
  .modal-body label {
    color: #333;
    /* Darker label color */
    font-weight: bolder;
  }
</style>

<div class="modal fade" id="addDataTimeslotModal" tabindex="-1" role="dialog" aria-labelledby="addDataTimeslotModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDataTimeslotModalLabel">Add Pet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="pet_name">Pet Name:</label>
              <input type="text" class="form-control" id="pet_name" name="pet_name" placeholder="Enter your Pet Name" required>
            </div>
            <div class="form-group col-md-6">
              <label for="species">Species:</label>
              <select class="form-control" id="species" name="species" required>
                <option value="" disabled selected>Select an option</option>
                <option value="Canine">Canine</option>
                <option value="Feline">Feline</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="breed">Breed:</label>
              <input type="text" class="form-control" id="breed" name="breed" placeholder="Enter Breed" required>
            </div>
            <div class="form-group col-md-6">
              <label for="birthdate">Birthdate:</label>
              <input type="date" class="form-control" id="birthdate" name="birthdate" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="neutered">Neutered:</label>
              <select class="form-control" id="neutered" name="neutered" required>
                <option value="" disabled selected>Select an option</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>

          <!-- Add a hidden input field to submit the form with the button click -->
          <input type="hidden" name="add_pet" value="1">

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="addButton">Add</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Toastify JS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


<script>
  $(document).ready(function() {
    $('#addDataTimeslotModal form').submit(function(event) {
      event.preventDefault(); // Prevent default form submission

      // Store a reference to $(this)
      var $form = $(this);

      // Serialize form data
      var formData = $form.serialize();

      // Change button text to "Adding..." and disable it
      var $addButton = $('#addButton');
      $addButton.text('Adding...');
      $addButton.prop('disabled', true);

      // Send AJAX request
      $.ajax({
        type: 'POST',
        url: '/appointment/controllers/users/add_pet_process.php',
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

            // Optionally, reset the form
            $form.trigger('reset');

            // Optionally, close the modal
            $('#addDataTimeslotModal').modal('hide');
            window.reloadDataTable();

            // Optionally, reload the DataTable or update it with the new data
            // Example: $('#dataTable').DataTable().ajax.reload();
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
            text: "Error occurred while adding supplier. Please try again later.",
            duration: 2000,
            backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
          }).showToast();
        },
        complete: function() {
          // Reset button text and re-enable it
          $addButton.text('Add');
          $addButton.prop('disabled', false);
        }
      });
    });
  });
</script>