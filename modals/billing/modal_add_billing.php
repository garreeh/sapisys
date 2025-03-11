<?php

include './../../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$sql = "SELECT * FROM users WHERE is_admin = 0 AND account_status = 'Active'";
$resultClient = mysqli_query($conn, $sql);

$user_names = [];
if ($resultClient) {
  while ($row = mysqli_fetch_assoc($resultClient)) {
    $user_names[] = $row;
  }
}

?>

<style>
  /* Custom CSS for label color */
  .modal-body label {
    color: #333;
    /* Darker label color */
    font-weight: bolder;
  }
</style>

<div class="modal fade" id="addBillingModal" tabindex="-1" role="dialog" aria-labelledby="addBillingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBillingModalLabel">Add Billing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="user_id">Select Client:</label>
              <select class="form-control" id="user_id" name="user_id" required>
                <option value="">Select Client</option>
                <?php foreach ($user_names as $user_rows) : ?>
                  <option value="<?php echo $user_rows['user_id']; ?>">
                    <?php echo $user_rows['user_fullname']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="date_today">Date Today:</label>
              <input type="date" class="form-control" id="date_today" name="date_today" value="<?php echo date('Y-m-d'); ?>" readonly required>
            </div>
          </div>

          <!-- Add a hidden input field to submit the form with the button click -->
          <input type="hidden" name="add_billing" value="1">

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
    $('#addBillingModal form').submit(function(event) {
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
        url: '/appointment/controllers/admin/add_billing_process.php',
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

            // Optionally, reset the selectize dropdown
            $('#user_id')[0].selectize.clear();

            // Optionally, close the modal
            $('#addBillingModal').modal('hide');
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