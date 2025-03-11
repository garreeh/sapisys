<?php

include './../../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$user_id = isset($_GET['user_id']) ? htmlspecialchars($_GET['user_id']) : 'Unknown User';
$billing_id = isset($_GET['billing_id']) ? htmlspecialchars($_GET['billing_id']) : 'No Billing ID';

?>

<style>
  /* Custom CSS for label color */
  .modal-body label {
    color: #333;
    /* Darker label color */
    font-weight: bolder;
  }
</style>

<!-- Your modal and form HTML -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addBillingModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBillingModalLabel">Add Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" id="addPaymentForm">

          <!-- Hidden Inputs for user_id and billing_id -->
          <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $user_id ?>" readonly
            required>
          <input type="hidden" class="form-control" id="billing_id" name="billing_id" value="<?php echo $billing_id ?>"
            readonly required>

          <div class="form-row">
            <div class="form-group col-md-12">
              <h5>Tag as Paid?</h5>

              <!-- Radio Buttons for Cash and Gcash -->
              <label>
                <input type="radio" name="payment_method" value="Cash" id="payment_cash" checked> Cash
              </label>
              <label>
                <input type="radio" name="payment_method" value="GCash" id="payment_gcash"> Gcash
              </label>
            </div>
          </div>

          <!-- Reference Code and Proof of Payment (hidden initially) -->
          <div id="gcash_details" style="display:none;">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="reference_code">Reference Code:</label>
                <input type="text" id="reference_code" name="reference_code" placeholder="Enter Reference Cpde"
                  class="form-control">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="payment_proof">Upload Proof of Payment:</label>
                <input type="file" id="payment_proof" name="fileToUpload" class="form-control-file">
              </div>
            </div>
          </div>

          <!-- Hidden Input to mark the addition of bill -->
          <input type="hidden" name="add_payment" value="1">

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
  $(document).ready(function () {
    // Form submission with AJAX
    $('#addPaymentForm').submit(function (event) {
      event.preventDefault(); // Prevent default form submission

      var $form = $(this);

      // Serialize form data
      var formData = new FormData($form[0]);

      // Disable the button and show "Adding..."
      var $addButton = $('#addCategoryButton');
      $addButton.text('Adding...');
      $addButton.prop('disabled', true);

      // Send AJAX request
      $.ajax({
        type: 'POST',
        url: '/appointment/controllers/admin/add_payment_process.php',
        data: formData,
        processData: false, // Important to prevent jQuery from processing the data
        contentType: false, // Important to prevent jQuery from setting content type (we need to handle multipart form data)
        success: function (response) {
          response = JSON.parse(response); // Parse the response
          if (response.success) {
            Toastify({
              text: response.message,
              duration: 2000,
              backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
            }).showToast();

            // Optionally close the modal after success
            $('#addPaymentModal').modal('hide');
            // Reload data or handle accordingly
            window.reloadDataTable();

            $('#items')[0].selectize.clear(); // Clear Selectize dropdown

            fetchUpdatedPayment();
            // Function to fetch updated order summary
            function fetchUpdatedPayment() {
              var user_id = "<?php echo $user_id; ?>"
              var billing_id = "<?php echo $billing_id; ?>"

              $.ajax({
                url: './../../controllers/admin/fetch_payment_process.php', // Path to your PHP script
                method: 'GET',
                data: {
                  user_id: user_id,
                  billing_id: billing_id,
                },
                dataType: 'json',
                success: function (response) {
                  $('#paymentStatus').val(response.payment_status); // Update total items
                },
                error: function () {
                  console.log('Error fetching order summary');
                }
              });
            }
          } else {
            Toastify({
              text: response.message,
              duration: 2000,
              backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
            }).showToast();
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
          Toastify({
            text: "Error occurred while adding billing. Please try again later.",
            duration: 2000,
            backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
          }).showToast();
        },
        complete: function () {
          $addButton.text('Add');
          $addButton.prop('disabled', false);
        }
      });
    });

    $('#addPaymentModal').on('hidden.bs.modal', function () {

      // Reset the dropdowns to their default states
      $('#items')[0].selectize.clear(); // Clear Selectize dropdown

    });
  });

  document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
    radio.addEventListener('change', function () {
      if (document.getElementById('payment_gcash').checked) {
        document.getElementById('gcash_details').style.display = 'block';
      } else {
        document.getElementById('gcash_details').style.display = 'none';
      }
    });
  });
</script>