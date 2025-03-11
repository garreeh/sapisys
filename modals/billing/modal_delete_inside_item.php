<style>
  /* Custom CSS for label color */
  .modal-body label {
    color: #333;
    /* Darker label color */
    font-weight: bolder;
  }
</style>

<?php

$billing_id = isset($_GET['billing_id']) ? htmlspecialchars($_GET['billing_id']) : 'No Billing ID';

include './../../connections/connections.php';

if (isset($_POST['bill_id'])) {
  $bill_id = $_POST['bill_id'];
  $sql = "SELECT * FROM inside_billing WHERE bill_id = '$bill_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="modal fade" id="deleteModalBill" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Bill ID: <?php echo $row['bill_id']; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="bill_id" value="<?php echo $row['bill_id']; ?>">
                <input type="hidden" name="billing_id" value="<?php echo $row['billing_id']; ?>">


                <div class="form-row">
                  <div class="form-group col-md-12">
                    <h4 for="price">Are you sure you want to delete?</h4>
                  </div>
                </div>

                <!-- Add a hidden input field to submit the form with the button click -->
                <input type="hidden" name="delete_inside_item" value="1">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="saveCategoryButton">Yes</button>
                  <!-- <input type="hidden" name="item_id" value="</?php echo $row['bill_id']; ?>"> -->
                  <button type="button" class="btn btn btn-danger" data-dismiss="modal">No</button>
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
  $(document).ready(function () {
    $('#deleteModalBill form').submit(function (event) {
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
        url: '/appointment/controllers/admin/delete_inside_item_process.php',
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
            $('#deleteModalBill').modal('hide');
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
            text: "Error occurred while editing category. Please try again later.",
            duration: 2000,
            backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
          }).showToast();
        },
        complete: function () {
          // Reset button text and re-enable it
          $saveButton.text('Yes');
          $saveButton.prop('disabled', false);
        }
      });
    });
  });
</script>