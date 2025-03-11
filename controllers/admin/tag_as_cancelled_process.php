<?php
include '../../connections/connections.php';

if (isset($_POST['tag_as_cancel'])) {

  // Get appointment_id and user_id
  $appointment_id = $conn->real_escape_string($_POST['appointment_id']);

  // Construct SQL query for UPDATE
  $sql = "UPDATE `appointment` 
          SET 
              appointment_status = 'Cancelled'
          WHERE appointment_id = '$appointment_id'";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // User updated successfully
    $response = array('success' => true, 'message' => 'Tag as Cancelled successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error updating user
    $response = array('success' => false, 'message' => 'Error Tagging: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
