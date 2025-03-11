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

if (isset($_POST['prescription_id'])) {
  $prescription_id = $_POST['prescription_id'];
  $sql = "SELECT * FROM prescription WHERE prescription_id = '$prescription_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="modal fade" id="deletePrescriptionModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Prescription ID: <?php echo $row['prescription_id']; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="prescription_id" value="<?php echo $row['prescription_id']; ?>">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <h4>Do you want to delete this Prescription?</h4>
                  </div>
                </div>

                <!-- Add a hidden input field to submit the form with the button click -->
                <input type="hidden" name="delete_prescription" value="1">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Yes</button>
                  <!-- <input type="hidden" name="item_id" value="</?php echo $row['supplier_id']; ?>"> -->
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
  // Save Button in Edit Supplier
  $(document).ready(function () {
    $('#deletePrescriptionModal form').submit(function (event) {
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
        url: '/appointment/controllers/admin/delete_prescription_process.php',
        data: formData,
        success: function (response) {
          console.log(response); // Log the response for debugging
          response = JSON.parse(response);
          if (response.success) {
            Toastify({
              text: response.message,
              duration: 2000,
              backgroundColor: "linear-gradient(to right, #ff0000, #ff7f7f)"

            }).showToast();

            $('#deletePrescriptionModal').modal('hide');
            reloadDataTable();
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
            text: "Error occurred while editing user. Please try again later.",
            duration: 2000,
            backgroundColor: "linear-gradient(to right, #ff6a00, #ee0979)"
          }).showToast();
        },
        complete: function () {
          // Reset button text and re-enable it
          $button.text('Yes').prop('disabled', false);
        }
      });
    });
  });

  function reloadDataTable() {
    $('#prescription_table').DataTable().ajax.reload(null, false);
  }
</script>