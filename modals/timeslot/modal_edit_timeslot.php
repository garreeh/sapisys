<style>
  /* Custom CSS for label color */
  .modal-body label {
    color: #333; /* Darker label color */
    font-weight: bolder;
  }
</style>

<?php
include './../../connections/connections.php';

if (isset($_POST['timeslot_id'])) {
  $timeslot_id = $_POST['timeslot_id'];
  $sql = "SELECT * FROM timeslot WHERE timeslot_id = '$timeslot_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
  <div class="modal fade" id="fetchDataTimeslotModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-l" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update Timeslot Details ID: <?php echo $row['timeslot_id']; ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="timeslot_id" value="<?php echo $row['timeslot_id']; ?>">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="time_from">Time From:</label>
                <input type="time" class="form-control" id="time_from" name="time_from" value="<?php echo $row['time_from']; ?>" placeholder="Enter Time From" required>
              </div>
              <div class="form-group col-md-12">
                <label for="time_to">Time To:</label>
                <input type="time" class="form-control" id="time_to" name="time_to" value="<?php echo $row['time_to']; ?>" placeholder="Enter Time To" required>
              </div>
            </div>

            <!-- Add a hidden input field to submit the form with the button click -->
            <input type="hidden" name="edit_timeslot" value="1">

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
              <!-- <input type="hidden" name="item_id" value="</?php echo $row['timeslot_id']; ?>"> -->
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
    $('#fetchDataTimeslotModal form').submit(function(event) {
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
        url: '/appointment/controllers/admin/edit_timeslot_process.php',
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
            $('#fetchDataTimeslotModal').modal('hide');
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