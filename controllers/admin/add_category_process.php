<?php

include '../../connections/connections.php';

if (isset($_POST['add_category'])) {
	// Get form data
	$category_name = $conn->real_escape_string($_POST['category_name']);
	$price = $conn->real_escape_string($_POST['price']);

  // Construct SQL query
  $sql = "INSERT INTO `category` (category_name, price)
          VALUES ('$category_name', '$price')";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Supplier added successfully
    $response = array('success' => true, 'message' => 'Service Added successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error adding supplier
    $response = array('success' => false, 'message' => 'Error Adding Service!: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  } 
}
?>