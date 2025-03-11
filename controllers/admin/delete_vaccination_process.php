<?php

include '../../connections/connections.php';

if (isset($_POST['delete_vaccination'])) {
  // Get form data
  $vaccination_id = $conn->real_escape_string($_POST['vaccination_id']);

  // Construct SQL query to delete the particular item
  $sql = "DELETE FROM `vaccination` 
          WHERE vaccination_id = '$vaccination_id'";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Particular deleted successfully
    $response = array('success' => true, 'message' => 'Vaccination deleted successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error deleting particulars
    $response = array('success' => false, 'message' => 'Error deleting Vaccination: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
} else {
  // Invalid request
  $response = array('success' => false, 'message' => 'Invalid request!');
  echo json_encode($response);
  exit();
}
