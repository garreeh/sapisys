<?php

include './../../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$user_id = isset($_GET['user_id']) ? htmlspecialchars($_GET['user_id']) : 'Unknown User';
$billing_id = isset($_GET['billing_id']) ? htmlspecialchars($_GET['billing_id']) : 'No Billing ID';


$sql = "SELECT * FROM category";
$resultCategory = mysqli_query($conn, $sql);

$category_names = [];
if ($resultCategory) {
  while ($row = mysqli_fetch_assoc($resultCategory)) {
    $category_names[] = $row;
  }
}

$sql = "SELECT * FROM vaccine";
$resultVaccine = mysqli_query($conn, $sql);

$vaccine_names = [];
if ($resultVaccine) {
  while ($row = mysqli_fetch_assoc($resultVaccine)) {
    $vaccine_names[] = $row;
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

<!-- Your modal and form HTML -->
<div class="modal fade" id="addBillModal" tabindex="-1" role="dialog" aria-labelledby="addBillingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBillingModalLabel">Add Billing Specific</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" id="addBillForm">

          <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $user_id ?>" readonly required>
          <input type="hidden" class="form-control" id="billing_id" name="billing_id" value="<?php echo $billing_id ?>" readonly required>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="items">Select Particulars:</label>
              <select class="form-control selectize" id="items" name="items" required>
                <option value="">Select Particulars</option>

                <!-- Loop through categories -->
                <?php foreach ($category_names as $category_rows) : ?>
                  <option value="<?php echo $category_rows['category_name'] . ':' . $category_rows['price']; ?>">
                    <?php echo $category_rows['category_name']; ?>
                  </option>
                <?php endforeach; ?>

                <!-- Loop through vaccines -->
                <?php foreach ($vaccine_names as $vaccine_rows) : ?>
                  <option value="<?php echo $vaccine_rows['vaccine_name'] . ':' . $vaccine_rows['price']; ?>">
                    <?php echo $vaccine_rows['vaccine_name']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group col-md-12">
              <label for="price">Price:</label>
              <input type="text" id="price" name="price" class="form-control" placeholder="Price here" readonly>
            </div>
          </div>

          <input type="hidden" name="add_bill" value="1">

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
    // Initialize Selectize
    $('#items').selectize({
      onChange: function(value) {
        if (value) {
          var parts = value.split(':');
          var itemName = parts[0]; // Item name
          var price = parts[1]; // Price

          $('#price').val(price);
        } else {
          $('#price').val('');
        }
      }
    });

    // Form submission with AJAX
    $('#addBillForm').submit(function(event) {
      event.preventDefault(); // Prevent default form submission

      var $form = $(this);
      var formData = $form.serialize(); // Serialize form data

      // Disable the button and show "Adding..."
      var $addButton = $('#addCategoryButton');
      $addButton.text('Adding...');
      $addButton.prop('disabled', true);

      // Send AJAX request
      $.ajax({
        type: 'POST',
        url: '/appointment/controllers/admin/add_bill_process.php',
        data: formData,
        success: function(response) {
          response = JSON.parse(response); // Parse the response
          if (response.success) {
            Toastify({
              text: response.message,
              duration: 2000,
              backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
            }).showToast();

            // Optionally close the modal after success
            $('#addBillModal').modal('hide');
            // Reload data or handle accordingly
            window.reloadDataTable();

            fetchOrderSummary();
            // Function to fetch updated order summary
            function fetchOrderSummary() {
              var user_id = "<?php echo $user_id; ?>" // Get the user ID from wherever you have it (e.g., from a session or global variable)
              var billing_id = "<?php echo $billing_id; ?>" // Get the user ID from wherever you have it (e.g., from a session or global variable)


              $.ajax({
                url: './../../controllers/admin/fetch_order_summary_process.php', // Path to your PHP script
                method: 'GET',
                data: {
                  user_id: user_id,
                  billing_id: billing_id,
                },
                dataType: 'json',
                success: function(response) {
                  // Update the order summary inputs with the fetched data
                  $('#billingID').val(response.billing_id); // Update total items
                  $('#totalOrders').val(response.total_items); // Update total items
                  $('#totalPrice').val('₱' + parseFloat(response.total_price).toFixed(2)); // Update total price (format to ₱)
                },
                error: function() {
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
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          Toastify({
            text: "Error occurred while adding billing. Please try again later.",
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
  });
</script>