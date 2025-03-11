<?php
include '../../connections/connections.php';

if (isset($_POST['add_files'])) {

  // Initialize response array
  $response = array('success' => false, 'message' => '');

  $target_dir = "../../uploads/files/";
  $target_filename = basename($_FILES["fileToUpload"]["name"]);
  $target_file = $target_dir . $target_filename;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  $pet_id = $conn->real_escape_string($_POST['pet_id']);
  $user_id = $conn->real_escape_string($_POST['user_id']);
  $file_name = $conn->real_escape_string($target_filename); // Get the file name

  // Create target directory if it doesn't exist
  if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
  }

  // Check for upload errors
  if ($_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK) {
    $response['message'] = "File upload error: " . $_FILES["fileToUpload"]["error"];
    echo json_encode($response);
    exit();
  }

  // Check if file already exists
  if (file_exists($target_file)) {
    $response['message'] = "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Allow certain file formats: JPG, JPEG, PNG, GIF, PDF, DOCX, TXT
  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "pdf"
    && $imageFileType != "docx" && $imageFileType != "txt"
  ) {
    $response['message'] = "Sorry, only JPG, JPEG, PNG, GIF, PDF, DOCX, and TXT files are allowed.";
    $uploadOk = 0;
  }

  // Check the file size (optional, set a max size limit in bytes)
  if ($_FILES["fileToUpload"]["size"] > 2000000) { // Example: 2MB limit
    $response['message'] = "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo json_encode($response);
    exit();
  } else {
    // Attempt to move the uploaded file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      $response['message'] = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
    } else {
      $response['message'] = "Sorry, there was an error uploading your file.";
      echo json_encode($response);
      exit();
    }
  }

  // Construct SQL query with file_name and path
  $sql = "INSERT INTO `file_uploads` (file_name, file_path, pet_id, user_id)
          VALUES ('$file_name', '$target_file', '$pet_id', '$user_id')";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    $response['success'] = true;
    $response['message'] = 'File added successfully!';
  } else {
    $response['message'] = 'Error adding file to database: ' . mysqli_error($conn);
  }

  echo json_encode($response);
  exit();
}
