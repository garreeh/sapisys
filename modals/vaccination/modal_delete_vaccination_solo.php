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

if (isset($_POST['vaccination_id'])) {
  $vaccination_id = $_POST['vaccination_id'];
  $sql = "SELECT * FROM vaccination WHERE vaccination_id = '$vaccination_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="modal fade" id="fetchDataVaccinationSoloDelete" tabindex="-1" role="dialog"
        aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Vaccination ID: <?php echo $row['vaccination_id']; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="vaccination_id" value="<?php echo $row['vaccination_id']; ?>">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <h4>Do you want to delete this Vaccine?</h4>
                  </div>
                </div>

                <!-- Add a hidden input field to submit the form with the button click -->
                <input type="hidden" name="delete_vaccination" value="1">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="saveCategoryButton">Yes</button>
                  <!-- <input type="hidden" name="item_id" value="</?php echo $row['vaccination_id']; ?>"> -->
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
    $('#fetchDataVaccinationSoloDelete form').submit(function (event) {
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
        url: '/appointment/controllers/admin/delete_vaccination_process.php',
        data: formData,
        success: function (response) {
          // Handle success response
          console.log(response); // Log the response for debugging
          response = JSON.parse(response);
          if (response.success) {
            Toastify({
              text: response.message,
              duration: 2000,
              backgroundColor: "linear-gradient(to right, #ff0000, #ff7f7f)"
            }).showToast();

            // Optionally, close the modal
            $('#fetchDataVaccinationSoloDelete').modal('hide');
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

  function reloadDataTable() {
    $('#vaccine_solo_table').DataTable().ajax.reload(null, false);
  }
</script>