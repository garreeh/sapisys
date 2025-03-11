<?php

include '../../connections/connections.php';

if (isset($_POST['add_prescription'])) {
  // Get form data
  $prescription_notes = $conn->real_escape_string($_POST['prescription_notes']);
  $pet_id = $conn->real_escape_string($_POST['pet_id']);
  $user_id = $conn->real_escape_string($_POST['user_id']);


  // Construct SQL query
  $sql = "INSERT INTO `prescription` (prescription_notes, pet_id, user_id)
          VALUES ('$prescription_notes', '$pet_id', '$user_id')";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Supplier added successfully
    $response = array('success' => true, 'message' => 'Prescription Added successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error adding supplier
    $response = array('success' => false, 'message' => 'Error Adding Prescription!: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
