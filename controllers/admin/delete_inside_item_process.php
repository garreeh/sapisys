<?php

include '../../connections/connections.php';

if (isset($_POST['delete_inside_item'])) {
  // Get form data
  $bill_id = $conn->real_escape_string($_POST['bill_id']);
  $billing_id = $conn->real_escape_string($_POST['billing_id']);

  // Check the payment_status in the billing table before proceeding
  $check_sql = "SELECT payment_status FROM billing WHERE billing_id = '$billing_id'";
  $check_result = mysqli_query($conn, $check_sql);

  if ($check_result) {
    $row = mysqli_fetch_assoc($check_result);

    // If the payment status is 'Paid', prevent deleting items
    if ($row['payment_status'] === 'Paid') {
      $response = array('success' => false, 'message' => 'Payment is already marked as Paid. This bill cannot be modified anymore.');
      echo json_encode($response);
      exit();
    }
  } else {
    $response = array('success' => false, 'message' => 'Error checking payment status: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }

  // Construct SQL query to delete the particular item
  $sql = "DELETE FROM `inside_billing` 
          WHERE bill_id = '$bill_id'
          AND billing_id = '$billing_id'";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Particular deleted successfully
    $response = array('success' => true, 'message' => 'Particular deleted successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error deleting particulars
    $response = array('success' => false, 'message' => 'Error deleting billing: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
} else {
  // Invalid request
  $response = array('success' => false, 'message' => 'Invalid request!');
  echo json_encode($response);
  exit();
}
