<?php

include '../../connections/connections.php';

if (isset($_POST['edit_prescription'])) {

  $prescription_id = $conn->real_escape_string($_POST['prescription_id']);
  $prescription_notes = $conn->real_escape_string($_POST['prescription_notes']);

  $sql = "UPDATE `prescription` 
          SET 
            prescription_notes = '$prescription_notes'
          WHERE prescription_id = '$prescription_id'";

  if (mysqli_query($conn, $sql)) {
    $response = array('success' => true, 'message' => 'Prescription updated successfully!');
    echo json_encode($response);
    exit();
  } else {
    $response = array('success' => false, 'message' => 'Error updating Prescription: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
