<?php
include './../../connections/connections.php';

if (isset($_POST['edit_files']) && $_POST['edit_files'] == '1') {
  $file_id = $_POST['file_id'];

  // Initialize response array
  $response = [
    'success' => false,
    'message' => 'An error occurred while processing your request.'
  ];

  // Fetch the current file path from the database before updating
  $sql = "SELECT file_path FROM file_uploads WHERE file_id = '$file_id'";
  $result = mysqli_query($conn, $sql);
  $currentFilePath = '';

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $currentFilePath = $row['file_path'];
  } else {
    $response['message'] = 'File record not found.';
    echo json_encode($response);
    exit;
  }

  // Check if a file was uploaded
  if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
    // Define the target directory for uploads
    $targetDir = '../../uploads/files/';
    // Get the uploaded file information
    $fileName = basename($_FILES['fileToUpload']['name']);
    $targetFilePath = $targetDir . $fileName;

    // Check if the new file already exists and handle accordingly (optional)
    if (file_exists($targetFilePath)) {
      $response['message'] = 'File already exists. Please rename the file and try again.';
      echo json_encode($response);
      exit;
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFilePath)) {
      // Delete the old file if it exists
      if (!empty($currentFilePath) && file_exists($currentFilePath)) {
        unlink($currentFilePath);
      }

      // Update the database with the new full file path and file name
      $sql = "UPDATE file_uploads SET file_path = '$targetFilePath', file_name = '$fileName' WHERE file_id = '$file_id'";
      if (mysqli_query($conn, $sql)) {
        $response['success'] = true;
        $response['message'] = 'File updated successfully!';
      } else {
        $response['message'] = 'Database update failed: ' . mysqli_error($conn);
      }
    } else {
      $response['message'] = 'Failed to move uploaded file.';
    }
  } else {
    // If no file is uploaded, just update the file_id (optional)
    $response['message'] = 'No file uploaded, updating without new file.';
    $sql = "UPDATE file_uploads SET file_path = file_path WHERE file_id = '$file_id'"; // Optional, or handle accordingly
    if (mysqli_query($conn, $sql)) {
      $response['success'] = true;
      $response['message'] = 'No new file uploaded, but the record was updated successfully!';
    } else {
      $response['message'] = 'Database update failed: ' . mysqli_error($conn);
    }
  }

  // Return response in JSON format
  echo json_encode($response);
  exit;
}
