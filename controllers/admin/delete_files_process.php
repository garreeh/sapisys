<?php

include '../../connections/connections.php';

if (isset($_POST['delete_files'])) {
  // Get form data
  $file_id = $conn->real_escape_string($_POST['file_id']);

  // Retrieve the file path from the database
  $query = "SELECT file_path FROM file_uploads WHERE file_id = '$file_id'";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $file_path = $row['file_path'];

    if (file_exists($file_path)) {
      if (!unlink($file_path)) {
        $response = array('success' => false, 'message' => 'Failed to delete the file from the server.');
        echo json_encode($response);
        exit();
      }
    } else {
      $response = array('success' => false, 'message' => 'File does not exist on the server.');
      echo json_encode($response);
      exit();
    }

    $sql = "DELETE FROM file_uploads WHERE file_id = '$file_id'";
    if (mysqli_query($conn, $sql)) {
      $response = array('success' => true, 'message' => 'File deleted successfully!');
      echo json_encode($response);
      exit();
    } else {
      $response = array('success' => false, 'message' => 'Error deleting File: ' . mysqli_error($conn));
      echo json_encode($response);
      exit();
    }
  } else {
    $response = array('success' => false, 'message' => 'File not found in the database.');
    echo json_encode($response);
    exit();
  }
} else {
  // Invalid request
  $response = array('success' => false, 'message' => 'Invalid request!');
  echo json_encode($response);
  exit();
}
