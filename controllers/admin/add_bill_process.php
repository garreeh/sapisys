<?php

include '../../connections/connections.php';

if (isset($_POST['add_bill'])) {
  // Get form data
  $user_id = $conn->real_escape_string($_POST['user_id']);
  $items = $conn->real_escape_string($_POST['items']);  // This contains both category_name and price
  $price = $conn->real_escape_string($_POST['price']);   // This is just the price, extracted separately
  $billing_id = $conn->real_escape_string($_POST['billing_id']);

  // Split the 'items' string to extract category_name and price (assuming 'items' is formatted as 'category_name:price')
  list($category_name, $extracted_price) = explode(':', $items);

  // Check the payment_status in the billing table before proceeding
  $check_sql = "SELECT payment_status FROM billing WHERE billing_id = '$billing_id'";
  $check_result = mysqli_query($conn, $check_sql);

  if ($check_result) {
    $row = mysqli_fetch_assoc($check_result);

    // If the payment status is 'Paid', prevent adding more items
    if ($row['payment_status'] === 'Paid') {
      $response = array('success' => false, 'message' => 'Payment is already marked as Paid. No more items can be added.');
      echo json_encode($response);
      exit();
    }
  } else {
    $response = array('success' => false, 'message' => 'Error checking payment status: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }

  // Construct SQL query (Save only the category_name and the price as per the form submission)
  $sql = "INSERT INTO `inside_billing` (user_id, items, price, billing_id)
            VALUES ('$user_id', '$category_name', '$extracted_price', $billing_id)";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Particulars added successfully
    $response = array('success' => true, 'message' => 'Particulars added successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error adding particulars
    $response = array('success' => false, 'message' => 'Error adding billing: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
} else {
  // Invalid request
  $response = array('success' => false, 'message' => 'Invalid request!');
  echo json_encode($response);
  exit();
}
