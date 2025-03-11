<?php
// Define table and primary key
$table = 'file_uploads';
$primaryKey = 'file_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'file_id',
    'dt' => 0,
    'field' => 'file_id',
    'formatter' => function ($lab1, $row) {
      return $row['file_id'];
    }
  ),

  array(
    'db' => 'file_name',
    'dt' => 1,
    'field' => 'file_name',
    'formatter' => function ($lab2, $row) {
      return $row['file_name'];
    }
  ),

  array(
    'db' => 'file_path',
    'dt' => 2,
    'field' => 'file_path',
    'formatter' => function ($lab2, $row) {
      $files = $row['file_path'];
      $file_extension = strtolower(pathinfo($files, PATHINFO_EXTENSION));

      if ($file_extension === 'pdf') {
        return '<a href="' . $files . '" target="_blank">View PDF</a>';
      } elseif (in_array($file_extension, ['doc', 'docx'])) {
        return '<a href="' . $files . '" target="_blank">View Document</a>';
      } elseif (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
        return '<a class="fetchDataFilesView" href="#">View Image</a>';
      } elseif ($file_extension === 'txt') {
        return '<a href="' . $files . '" download target="_blank">Download Notepad File</a>';
      } else {
        return 'Unsupported file type';
      }
    }
  ),

  array(
    'db' => 'created_at',
    'dt' => 3,
    'field' => 'created_at',
    'formatter' => function ($lab4, $row) {
      return date('Y-m-d', strtotime($row['created_at']));
    }
  ),

  array(
    'db' => 'updated_at',
    'dt' => 4,
    'field' => 'updated_at',
    'formatter' => function ($lab5, $row) {
      return date('Y-m-d', strtotime($row['updated_at']));
    }
  ),

  array(
    'db' => 'file_id',
    'dt' => 5,
    'field' => 'file_id',
    'formatter' => function ($lab6, $row) {

      return '
      <div class="dropdown">
          <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['file_id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              &#x22EE;
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['file_id'] . '">
              <a class="dropdown-item fetchDataPres" href="#">Edit</a>
              <a class="dropdown-item fetchDataPresDelete" href="#">Delete</a>
          </div>
      </div>';
    }
  ),

);

// Database connection details
include '../../connections/ssp_connection.php';

// Include the SSP class
require('../../assets/datatables/ssp.class_with_where.php');

$pet_id = isset($_GET['pet_id']) ? $_GET['pet_id'] : null;
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

$where = "pet_id = '$pet_id' AND user_id = '$user_id'";

// THIS IS A SAMPLE ONLY
// $joinQuery = "FROM $table
//               LEFT JOIN emp_users ON $table.emp_id = emp_users.emp_id";

// Fetch and encode JOIN AND WHERE
// echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where));

// Fetch and encode ONLY WHERE
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
