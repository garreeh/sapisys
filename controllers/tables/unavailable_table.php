<?php

// Define table and primary key
$table = 'unavailable_dates';
$primaryKey = 'unavailable_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'unavailable_id',
    'dt' => 0,
    'field' => 'unavailable_id',
    'formatter' => function ($lab1, $row) {
      return $row['unavailable_id'];
    }
  ),

  array(
    'db' => 'unavailable_date',
    'dt' => 1,
    'field' => 'unavailable_date',
    'formatter' => function ($lab2, $row) {
      $date = new DateTime($row['unavailable_date']);

      $style = 'background-color: #ff8787; border-radius: 5px; padding: 5px;';
      return "<span style=\"$style\">{$date->format('F j, Y')}</span>";
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
    'db' => 'unavailable_id',
    'dt' => 4,
    'field' => 'unavailable_id',
    'formatter' => function ($lab6, $row) {

      return '
      <div class="dropdown">
          <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['unavailable_id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              &#x22EE;
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['unavailable_id'] . '">
              <a class="dropdown-item fetchDataSupplier" href="#">Edit</a>
          </div>
      </div>';
    }
  ),

);

// Database connection details
include '../../connections/ssp_connection.php';

// Include the SSP class
require('../../assets/datatables/ssp.class_with_where.php');

$where = "unavailable_id";

// THIS IS A SAMPLE ONLY
// $joinQuery = "FROM $table
//               LEFT JOIN emp_users ON $table.emp_id = emp_users.emp_id";

// Fetch and encode JOIN AND WHERE
// echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where));

// Fetch and encode ONLY WHERE
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
