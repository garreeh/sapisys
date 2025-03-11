<?php

include '../../connections/connections.php';

if (isset($_POST['delete_prescription'])) {
  // Get form data
  $prescription_id = $conn->real_escape_string($_POST['prescription_id']);

  // Construct SQL query to delete the particular item
  $sql = "DELETE FROM `prescription` 
          WHERE prescription_id = '$prescription_id'";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Particular deleted successfully
    $response = array('success' => true, 'message' => 'Prescription deleted successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error deleting particulars
    $response = array('success' => false, 'message' => 'Error deleting Prescription: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
} else {
  // Invalid request
  $response = array('success' => false, 'message' => 'Invalid request!');
  echo json_encode($response);
  exit();
}
