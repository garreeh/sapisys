<?php

include '../../connections/connections.php';

if (isset($_POST['edit_vaccine'])) {

  $vaccine_id = $conn->real_escape_string($_POST['vaccine_id']);
  $vaccine_name = $conn->real_escape_string($_POST['vaccine_name']);
  $price = $conn->real_escape_string($_POST['price']);


  $sql = "UPDATE `vaccine` 
          SET 
            vaccine_name = '$vaccine_name',
            price = '$price'
          WHERE vaccine_id = '$vaccine_id'";

  if (mysqli_query($conn, $sql)) {
    $response = array('success' => true, 'message' => 'Vaccine updated successfully!');
    echo json_encode($response);
    exit();
  } else {
    $response = array('success' => false, 'message' => 'Error updating Vaccine: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
