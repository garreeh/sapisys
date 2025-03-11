<?php

include '../../connections/connections.php';

if (isset($_POST['delete_vaccine'])) {
  // Get form data
  $vaccine_id = $conn->real_escape_string($_POST['vaccine_id']);

  // Construct SQL query to delete the particular item
  $sql = "DELETE FROM `vaccine` 
          WHERE vaccine_id = '$vaccine_id'";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Particular deleted successfully
    $response = array('success' => true, 'message' => 'Vaccine deleted successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error deleting particulars
    $response = array('success' => false, 'message' => 'Error deleting Vaccine: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
} else {
  // Invalid request
  $response = array('success' => false, 'message' => 'Invalid request!');
  echo json_encode($response);
  exit();
}
