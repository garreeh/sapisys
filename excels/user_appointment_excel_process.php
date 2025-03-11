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
$fileName = $user_fullname . " appointments as of " . date('F d, Y') . ".xlsx";

// Define column names 
$excelData[] = array('Queue #', 'Service', 'Pet Name', 'Timeslot', 'Appointment Date', 'Status');

// Fetch records from database and store in an array 
$query = $conn->query("SELECT *
                              FROM appointment 
                              LEFT JOIN category ON appointment.category_id = category.category_id
                              LEFT JOIN pets ON appointment.pet_id = pets.pet_id
                              LEFT JOIN timeslot ON appointment.timeslot_id = timeslot.timeslot_id
                              WHERE appointment.user_id = '$user_id'");

if ($query->num_rows > 0) {
  while ($row = $query->fetch_assoc()) {
    $timeslot = $row['time_from'] . ' - ' . $row['time_to'];
    $lineData = array($row['queue_number'], $row['category_name'], $row['pet_name'], $timeslot, $row['appointment_date'], $row['appointment_status']);
    $excelData[] = $lineData;
  }
}

// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray($excelData);
$xlsx->downloadAs($fileName);

exit;

?>