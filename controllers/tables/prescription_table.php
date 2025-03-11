<?php
// Define table and primary key
$table = 'prescription';
$primaryKey = 'prescription_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'prescription_id',
    'dt' => 0,
    'field' => 'prescription_id',
    'formatter' => function ($lab1, $row) {
      return $row['prescription_id'];
    }
  ),

  array(
    'db' => 'prescription_notes',
    'dt' => 1,
    'field' => 'prescription_notes',
    'formatter' => function ($lab2, $row) {
      return '<a class="fetchDataPrescription" href="#"> Click to View</a> ';

      // return $row['prescription_notes'];
    }
  ),

  array(
    'db' => 'created_at',
    'dt' => 2,
    'field' => 'created_at',
    'formatter' => function ($lab4, $row) {
      return date('Y-m-d', strtotime($row['created_at']));
    }
  ),

  array(
    'db' => 'updated_at',
    'dt' => 3,
    'field' => 'updated_at',
    'formatter' => function ($lab5, $row) {
      return date('Y-m-d', strtotime($row['updated_at']));
    }
  ),

  array(
    'db' => 'prescription_id',
    'dt' => 4,
    'field' => 'prescription_id',
    'formatter' => function ($lab6, $row) {

      return '
      <div class="dropdown">
          <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['prescription_id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              &#x22EE;
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['prescription_id'] . '">
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
