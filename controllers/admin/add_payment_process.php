<?php
include '../../connections/connections.php';

if (isset($_POST['add_payment'])) {
  // Get form data
  $user_id = $conn->real_escape_string($_POST['user_id']);
  $billing_id = $conn->real_escape_string($_POST['billing_id']);
  $payment_method = $conn->real_escape_string($_POST['payment_method']);  // This is the new payment type (Cash/GCash)
  $reference_code = $conn->real_escape_string($_POST['reference_code']);

  // Initialize the variable for payment proof (if no file is uploaded, it will remain empty)
  $target_file = "";

  // Check if file was uploaded
  if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
    $target_dir = "../../uploads/gcash/";
    $target_filename = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $target_filename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Create target directory if it doesn't exist
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      $response['message'] = "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'pdf'])) {
      $response['message'] = "Sorry, only JPG, JPEG, PNG, GIF, and PDF files are allowed.";
      $uploadOk = 0;
    }

    // If upload failed, return an error message
    if ($uploadOk == 0) {
      $response['message'] = "Sorry, your file was not uploaded.";
      echo json_encode($response);
      exit();
    } else {
      // Move uploaded file
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $response['message'] = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
      } else {
        $response['message'] = "Sorry, there was an error uploading your file.";
        echo json_encode($response);
        exit();
      }
    }
  }

  // Check current payment status before updating
  $check_sql = "SELECT payment_status FROM billing WHERE billing_id = '$billing_id'";
  $result = mysqli_query($conn, $check_sql);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row['payment_status'] === 'Paid') {
      $response = array('success' => false, 'message' => 'This payment has already been marked as Paid. No further payments are accepted.');
      echo json_encode($response);
      exit();
    }
  } else {
    $response = array('success' => false, 'message' => 'Error checking payment status: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }

  // Update query to update the billing record with payment_method, reference_code, and payment_proof
  $sql = "UPDATE billing 
          SET payment_method = '$payment_method', 
              reference_code = '$reference_code', 
              payment_proof = '$target_file',  -- If no file is uploaded, $target_file will be an empty string
              payment_status = 'Paid'
          WHERE billing_id = '$billing_id'";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Payment successfully updated
    $response = array('success' => true, 'message' => 'Payment updated successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error updating payment
    $response = array('success' => false, 'message' => 'Error updating payment: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
} else {
  // Invalid request
  $response = array('success' => false, 'message' => 'Invalid request!');
  echo json_encode($response);
  exit();
}
