<?php
// Load the database configuration file 
include '../connections/connections.php';


// Include XLSX generator library 
include '../assets/PHPExcel/PHPExcel.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$user_id = $_SESSION['user_id'];
$user_fullname = $_SESSION['user_fullname'];

// Excel file name for download 
$fileName = $user_fullname . " Pets as of " . date('F d, Y') . ".xlsx";

// Define column names 
$excelData[] = array('Pet Name', 'Breed', 'Species', 'Neutered', 'Birth Day');

// Fetch records from database and store in an array 
$query = $conn->query("SELECT *
FROM pets WHERE user_id = '$user_id'");

if ($query->num_rows > 0) {
  while ($row = $query->fetch_assoc()) {
    $lineData = array($row['pet_name'], $row['breed'], $row['species'], $row['neutered'], $row['birthdate']);
    $excelData[] = $lineData;
  }
}

// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray($excelData);
$xlsx->downloadAs($fileName);

exit;

?>