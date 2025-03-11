<?php

include '../../connections/connections.php';

if (isset($_POST['edit_category'])) {

  $category_id = $conn->real_escape_string($_POST['category_id']);
  $category_name = $conn->real_escape_string($_POST['category_name']);
  $price = $conn->real_escape_string($_POST['price']);

  $sql = "UPDATE `category` 
          SET 
            category_name = '$category_name',
            price = '$price'
          WHERE category_id = '$category_id'";

  if (mysqli_query($conn, $sql)) {
    $response = array('success' => true, 'message' => 'Service updated successfully!');
    echo json_encode($response);
    exit();
  } else {
    $response = array('success' => false, 'message' => 'Error updating Service: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
