<?php

include '../../connections/connections.php';

if (isset($_POST['edit_user_type'])) {

  $user_type_id = $conn->real_escape_string($_POST['user_type_id']);
  $user_type_name = $conn->real_escape_string($_POST['user_type_name']);
  $appointments_module = $conn->real_escape_string($_POST['appointments_module']);
  $user_module = $conn->real_escape_string($_POST['user_module']);
  $patient_module = $conn->real_escape_string($_POST['patient_module']);
  $billing_module = $conn->real_escape_string($_POST['billing_module']);
  $appointment_setup_module = $conn->real_escape_string($_POST['appointment_setup_module']);
  $reports_module = $conn->real_escape_string($_POST['reports_module']);
  $vaccine_module = $conn->real_escape_string($_POST['vaccine_module']);



  // Construct SQL query for UPDATE
  $sql = "UPDATE `usertype` 
          SET 
            user_type_name = '$user_type_name',
            appointments_module = '$appointments_module',
            patient_module = '$patient_module',
            user_module = '$user_module',
            billing_module = '$billing_module',
            appointment_setup_module = '$appointment_setup_module',
            reports_module = '$reports_module',
            vaccine_module = '$vaccine_module'

          WHERE user_type_id = '$user_type_id'";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // User updated successfully
    $response = array('success' => true, 'message' => 'User Type updated successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error updating user
    $response = array('success' => false, 'message' => 'Error updating user: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
