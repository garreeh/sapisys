<?php

include '../../connections/connections.php';

if (isset($_POST['edit_vaccination'])) {

  $vaccination_id = $conn->real_escape_string($_POST['vaccination_id']);
  $vaccine_id = $conn->real_escape_string($_POST['vaccine_id']);
  $expiration_date = $conn->real_escape_string($_POST['expiration_date']);


  $sql = "UPDATE `vaccination` 
          SET 
            vaccine_id = '$vaccine_id',
            expiration_date = '$expiration_date'
            
          WHERE vaccination_id = '$vaccination_id'";

  if (mysqli_query($conn, $sql)) {
    $response = array('success' => true, 'message' => 'Vaccination updated successfully!');
    echo json_encode($response);
    exit();
  } else {
    $response = array('success' => false, 'message' => 'Error updating Vaccination: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
