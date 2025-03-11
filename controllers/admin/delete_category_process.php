<?php

include '../../connections/connections.php';

if (isset($_POST['delete_category'])) {
  // Get form data
  $category_id = $conn->real_escape_string($_POST['category_id']);

  // Construct SQL query to delete the particular item
  $sql = "DELETE FROM `category` 
          WHERE category_id = '$category_id'";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Particular deleted successfully
    $response = array('success' => true, 'message' => 'Service deleted successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error deleting particulars
    $response = array('success' => false, 'message' => 'Error deleting Service: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
} else {
  // Invalid request
  $response = array('success' => false, 'message' => 'Invalid request!');
  echo json_encode($response);
  exit();
}
