<?php

// Define table and primary key
$table = 'pets';
$primaryKey = 'pet_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'pet_id',
    'dt' => 0,
    'field' => 'pet_id',
    'formatter' => function ($lab1, $row) {
      return '<a href="../user/user_patient_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '" target="_blank">' . $row['pet_id'] . ' </a>';
    }
  ),

  array(
    'db' => 'pet_name',
    'dt' => 1,
    'field' => 'pet_name',
    'formatter' => function ($lab2, $row) {
      $pet_name = $row['pet_name'];
      $style = 'background-color: lightgreen; border-radius: 5px; padding: 5px;';
      return "<span style=\"$style\">{$pet_name}</span>";
    }
  ),

  array(
    'db' => 'breed',
    'dt' => 2,
    'field' => 'breed',
    'formatter' => function ($lab3, $row) {
      return '<a href="../user/user_patient_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '" target="_blank">' . $row['breed'] . ' </a>';
    }
  ),

  array(
    'db' => 'species',
    'dt' => 3,
    'field' => 'species',
    'formatter' => function ($lab3, $row) {
      return '<a href="../user/user_patient_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '" target="_blank">' . $row['species'] . ' </a>';
    }
  ),

  array(
    'db' => 'neutered',
    'dt' => 4,
    'field' => 'neutered',
    'formatter' => function ($lab3, $row) {
      return '<a href="../user/user_patient_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '" target="_blank">' . $row['neutered'] . ' </a>';
    }
  ),


  array(
    'db' => 'created_at',
    'dt' => 5,
    'field' => 'created_at',
    'formatter' => function ($lab4, $row) {
      return date('Y-m-d', strtotime($row['created_at']));
    }
  ),

  array(
    'db' => 'updated_at',
    'dt' => 6,
    'field' => 'updated_at',
    'formatter' => function ($lab5, $row) {
      return date('Y-m-d', strtotime($row['updated_at']));
    }
  ),

  array(
    'db' => 'pet_id',
    'dt' => 7,
    'field' => 'pet_id',
    'formatter' => function ($lab6, $row) {

      return '
      <div class="dropdown">
          <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['pet_id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              &#x22EE;
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['pet_id'] . '">
              <a class="dropdown-item" href="../user/user_patient_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '" target="_blank">View More</a>
              <a class="dropdown-item fetchDataSupplier" href="#">Edit</a>
          </div>
      </div>';
    }
  ),

  array(
    'db' => 'user_id',
    'dt' => 8,
    'field' => 'user_id',
    'formatter' => function ($lab3, $row) {
      return $row['user_id'];
    }
  ),

);

// Database connection details
include '../../connections/ssp_connection.php';

// Include the SSP class
require('../../assets/datatables/ssp.class_with_where.php');
session_start();
$user_id = $_SESSION['user_id'];

$where = "user_id = '$user_id'";

// THIS IS A SAMPLE ONLY
// $joinQuery = "FROM $table
//               LEFT JOIN emp_users ON $table.emp_id = emp_users.emp_id";

// Fetch and encode JOIN AND WHERE
// echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where));

// Fetch and encode ONLY WHERE
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
