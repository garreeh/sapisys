<?php

include '../../connections/connections.php';

if (isset($_POST['add_vaccine'])) {
  // Get form data
  $vaccine_name = $conn->real_escape_string($_POST['vaccine_name']);
  $price = $conn->real_escape_string($_POST['price']);

  // Construct SQL query
  $sql = "INSERT INTO `vaccine` (vaccine_name, price)
          VALUES ('$vaccine_name', '$price')";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Supplier added successfully
    $response = array('success' => true, 'message' => 'Vaccine Added successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error adding supplier
    $response = array('success' => false, 'message' => 'Error Adding Vaccine!: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
