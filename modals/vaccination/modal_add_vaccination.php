<style>
  /* Custom CSS for label color */
  .modal-body label {
    color: #333;
    /* Darker label color */
    font-weight: bolder;
  }
</style>

<div class="modal fade" id="addVaccinationModal" tabindex="-1" role="dialog" aria-labelledby="addVaccinationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addVaccinationModalLabel">Add Vaccination</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="vaccine_name">Vaccine Name:</label>
              <input type="text" class="form-control" id="vaccine_name" name="vaccine_name" placeholder="Enter Vaccine Name" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="price">Price:</label>
              <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" required>
            </div>
          </div>

          <!-- <div class="form-row">
            <div class="form-group col-md-12">
              <label for="expiration_date">Expiration Date:</label>
              <input type="date" class="form-control" id="expiration_date" name="expiration_date" required>
            </div>
          </div> -->

          <!-- Add a hidden input field to submit the form with the button click -->
          <input type="hidden" name="add_vaccine" value="1">

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="addCategoryButton">Add</button>
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
    $('#addVaccinationModal form').submit(function(event) {
      event.preventDefault(); // Prevent default form submission

      // Store a reference to $(this)
      var $form = $(this);

      // Serialize form data
      var formData = $form.serialize();

      // Change button text to "Adding..." and disable it
      var $addButton = $('#addCategoryButton');
      $addButton.text('Adding...');
      $addButton.prop('disabled', true);

      // Send AJAX request
      $.ajax({
        type: 'POST',
        url: '/appointment/controllers/admin/add_vaccine_process.php',
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
            $('#addVaccinationModal').modal('hide');
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
            text: "Error occurred while adding category. Please try again later.",
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