<style>
  /* Custom CSS for label color */
  .modal-body label {
    color: #333; /* Darker label color */
    font-weight: bolder;
  }
  .modal-body img {
    max-width: 100%; /* Ensure the image fits within the modal */
    height: auto;
    max-height: 300px; /* Limit the image height */
    object-fit: contain; /* Maintain aspect ratio */
  }
  .file-info {
    margin-top: 10px;
  }
</style>

<?php
include './../../connections/connections.php';

// Fetch user types from the database
$sql = "SELECT * FROM supplier";
$result = mysqli_query($conn, $sql);

$supplier_names = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $supplier_names[] = $row;
    }
}

// Fetch user types from the database
$sql = "SELECT * FROM category";
$resultCategory = mysqli_query($conn, $sql);

$category_names = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($resultCategory)) {
        $category_names[] = $row;
    }
}

if (isset($_POST['product_id'])) {
  $product_id = $_POST['product_id'];
  $sql = "SELECT * FROM product WHERE product_id = '$product_id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $product_image = basename($row['product_image']);
      $image_url = '../../uploads/' . $product_image; // Construct the image URL
    ?>
  <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update Product ID: <?php echo $row['product_id']; ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
          
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="product_sku">Product SKU:</label>
              <input type="text" class="form-control" id="product_sku" name="product_sku" placeholder="Enter Product SKU" value="<?php echo $row['product_sku']; ?>" required>
            </div>
            <div class="form-group col-md-6">
              <label for="product_name">Product Name:</label>
              <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" value="<?php echo $row['product_name']; ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="product_description">Product Description:</label>
              <input type="text" class="form-control" id="product_description" name="product_description" placeholder="Enter Product Description" value="<?php echo $row['product_description']; ?>" required>
            </div>
            <div class="form-group col-md-6">
              <label for="product_unitprice">Product Unit Price:</label>
              <input type="number" class="form-control" id="product_unitprice" name="product_unitprice" placeholder="Enter Product Unit Price" value="<?php echo $row['product_unitprice']; ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="product_sellingprice">Product Selling Price:</label>
              <input type="number" class="form-control" id="product_sellingprice" name="product_sellingprice" placeholder="Enter Product Selling Price" value="<?php echo $row['product_sellingprice']; ?>" required>
            </div>
            <div class="form-group col-md-6">
              <label for="product_image">Product Image:</label>
              <input type="file" class="form-control" id="product_image" name="fileToUpload">
              <!-- Display existing image filename -->
              <div class="file-info">
                <?php if (!empty($product_image) && file_exists('../../uploads/' . $product_image)): ?>
                  <p><strong>Current Image:</strong> <?php echo $product_image; ?></p>
                <?php else: ?>
                  <p>No image available.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="supplier_id">Supplier:</label>
              <select class="form-control" id="supplier_id" name="supplier_id" required>
                <?php foreach ($supplier_names as $supplier_rows) : ?>
                  <option value="<?php echo $supplier_rows['supplier_id']; ?>">
                    <?php echo $supplier_rows['supplier_name']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="category_id">Category:</label>
              <select class="form-control" id="category_id" name="category_id" required>
                <?php foreach ($category_names as $category_rows) : ?>
                  <option value="<?php echo $category_rows['category_id']; ?>">
                    <?php echo $category_rows['category_name']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

            <!-- Add a hidden input field to submit the form with the button click -->
            <input type="hidden" name="edit_product" value="1">

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="saveProductButton">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- COPY THESE WHOLE CODE WHEN IMPORT SELECT -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

  <script>
    $(document).ready(function() {
      $('select').selectize({
        sortField: 'text'
      });
    });
  </script>
  <!-- END OF SELECT -->

<?php 
    }
  }
}
?>

<script>
  $(document).ready(function() {
    $('#editProductModal form').submit(function(event) {
      event.preventDefault(); // Prevent default form submission
      
      var $form = $(this);
      
      // Create a FormData object to handle file uploads
      var formData = new FormData($form[0]);

      // Change button text to "Saving..." and disable it
      var $saveButton = $('#saveProductButton');
      $saveButton.text('Saving...');
      $saveButton.prop('disabled', true);

      // Send AJAX request
      $.ajax({
        type: 'POST',
        url: '/appointment/controllers/admin/edit_product_process.php',
        data: formData,
        processData: false, // Prevent jQuery from automatically transforming the data into a query string
        contentType: false, // Let the browser set the content type for the FormData
        success: function(response) {
          console.log(response); // Log the response for debugging
          response = JSON.parse(response);
          if (response.success) {
            Toastify({
              text: response.message,
              duration: 2000,
              backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
            }).showToast();
            
            $('#editProductModal').modal('hide');
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
          console.error(xhr.responseText);
          Toastify({
            text: "Error occurred while editing product. Please try again later.",
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
