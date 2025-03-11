<?php

include '../../connections/connections.php';

if (isset($_POST['add_billing'])) {
  // Get form data
  $user_id = $conn->real_escape_string($_POST['user_id']);

  // Construct SQL query
  $sql = "INSERT INTO `billing` (user_id)
          VALUES ('$user_id')";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Supplier added successfully
    $response = array('success' => true, 'message' => 'Billing Added successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error adding supplier
    $response = array('success' => false, 'message' => 'Error Adding Billing!: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
