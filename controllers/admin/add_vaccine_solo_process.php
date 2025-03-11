<?php

include '../../connections/connections.php';

if (isset($_POST['add_vaccination'])) {
  // Get form data
  $pet_id = $conn->real_escape_string($_POST['pet_id']);
  $user_id = $conn->real_escape_string($_POST['user_id']);
  $vaccine_id = $conn->real_escape_string($_POST['vaccine_id']);
  $expiration_date = $conn->real_escape_string($_POST['expiration_date']);


  // Construct SQL query
  $sql = "INSERT INTO `vaccination` (pet_id, user_id, vaccine_id, expiration_date)
          VALUES ('$pet_id', '$user_id', '$vaccine_id', '$expiration_date')";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Supplier added successfully
    $response = array('success' => true, 'message' => 'Vaccination Added successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error adding supplier
    $response = array('success' => false, 'message' => 'Error Adding Vaccination!: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
