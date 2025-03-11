<style>
  /* Custom CSS for label color */
  .modal-body label {
    color: #333;
    /* Darker label color */
    font-weight: bolder;
  }
</style>

<div class="modal fade" id="addPrescriptionModal" tabindex="-1" role="dialog" aria-labelledby="addVaccinationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addVaccinationModalLabel">Add Prescription</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="prescription_notes">Doctor's Prescription:</label>
              <textarea class="form-control" id="prescription_notes" name="prescription_notes" placeholder="Enter Doctor's Prescription" required rows="8"></textarea>
            </div>
          </div>

          <!-- These hidden input will get the link id's via javascript -->
          <input type="hidden" name="pet_id" id="pet_id" value="">
          <input type="hidden" name="user_id" id="user_id" value="">

          <input type="hidden" name="add_prescription" value="1">

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
    var pet_id = new URLSearchParams(window.location.search).get('pet_id');
    var user_id = new URLSearchParams(window.location.search).get('user_id');

    $('#addPrescriptionModal').on('shown.bs.modal', function() {
      $('#pet_id').val(pet_id);
      $('#user_id').val(user_id);
    });

    $('#addPrescriptionModal form').submit(function(event) {
      event.preventDefault(); // Prevent default form submission

      var $form = $(this);
      var formData = new FormData(this);

      formData.append('pet_id', $('#pet_id').val());
      formData.append('user_id', $('#user_id').val());

      var $addButton = $('#addCategoryButton'); // Make sure this ID matches your button's ID
      $addButton.text('Adding...');
      $addButton.prop('disabled', true);

      $.ajax({
        type: 'POST',
        url: '/appointment/controllers/admin/add_prescription_process.php',
        data: formData,
        processData: false, // Required to send FormData as-is
        contentType: false, // Prevent jQuery from setting contentType
        success: function(response) {
          console.log(response); // Log the response for debugging
          response = JSON.parse(response);
          if (response.success) {
            Toastify({
              text: response.message,
              duration: 2000,
              backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
            }).showToast();

            $form.trigger('reset');
            $('#addPrescriptionModal').modal('hide');
            reloadDataTable(); // Reload the table data

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
            text: "Error occurred while adding prescription. Please try again later.",
            duration: 2000,
            backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
          }).showToast();
        },
        complete: function() {
          $addButton.text('Add');
          $addButton.prop('disabled', false);
        }
      });
    });

    function reloadDataTable() {
      $('#prescription_table').DataTable().ajax.reload(null, false);
    }
  });
</script>