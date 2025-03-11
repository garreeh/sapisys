<?php

// Define table and primary key
$table = 'timeslot';
$primaryKey = 'timeslot_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'timeslot_id',
    'dt' => 0,
    'field' => 'timeslot_id',
    'formatter' => function ($lab1, $row) {
      return $row['timeslot_id'];
    }
  ),

  array(
    'db' => 'time_from',
    'dt' => 1,
    'field' => 'time_from',
    'formatter' => function ($lab2, $row) {
      $time_from = date("g:i A", strtotime($row['time_from']));
      $style = 'background-color: lightgreen; border-radius: 5px; padding: 5px;';
      return "<span style=\"$style\">{$time_from}</span>";
    }
  ),

  array(
    'db' => 'time_to',
    'dt' => 2,
    'field' => 'time_to',
    'formatter' => function ($lab3, $row) {
      $time_to = date("g:i A", strtotime($row['time_to']));
      $style = 'background-color: lightgreen; border-radius: 5px; padding: 5px;';
      return "<span style=\"$style\">{$time_to}</span>";
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
    'db' => 'timeslot_id',
    'dt' => 5,
    'field' => 'timeslot_id',
    'formatter' => function ($lab6, $row) {

      return '
      <div class="dropdown">
          <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['timeslot_id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              &#x22EE;
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['timeslot_id'] . '">
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

$where = "timeslot_id";

// THIS IS A SAMPLE ONLY
// $joinQuery = "FROM $table
//               LEFT JOIN emp_users ON $table.emp_id = emp_users.emp_id";

// Fetch and encode JOIN AND WHERE
// echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where));

// Fetch and encode ONLY WHERE
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
