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
      return '<a href="../admin/patient_solo_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '">' . $row['pet_id'] . ' </a>';
    }
  ),

  array(
    'db' => 'users.user_fullname',
    'dt' => 1,
    'field' => 'user_fullname',
    'formatter' => function ($lab2, $row) {
      // $queue_number = $row['queue_number'];
      // $style = 'background-color: lightgreen; border-radius: 5px; padding: 5px;';
      // return "<span style=\"$style\">{$queue_number}</span>";
      return '<a href="../admin/patient_solo_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '">' . $row['user_fullname'] . ' </a>';
    }
  ),

  array(
    'db' => 'pet_name',
    'dt' => 2,
    'field' => 'pet_name',
    'formatter' => function ($lab3, $row) {
      return '<a href="../admin/patient_solo_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '">' . $row['pet_name'] . ' </a>';
    }
  ),

  array(
    'db' => 'breed',
    'dt' => 3,
    'field' => 'breed',
    'formatter' => function ($lab3, $row) {
      return '<a href="../admin/patient_solo_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '">' . $row['breed'] . ' </a>';
    }
  ),

  array(
    'db' => 'species',
    'dt' => 4,
    'field' => 'species',
    'formatter' => function ($lab3, $row) {
      return '<a href="../admin/patient_solo_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '">' . $row['species'] . ' </a>';
    }
  ),


  array(
    'db' => 'neutered',
    'dt' => 5,
    'field' => 'neutered',
    'formatter' => function ($lab4, $row) {
      return '<a href="../admin/patient_solo_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '">' . $row['neutered'] . ' </a>';
    }
  ),


  array(
    'db' => 'pets.created_at',
    'dt' => 6,
    'field' => 'created_at',
    'formatter' => function ($lab5, $row) {
      return date('Y-m-d', strtotime($row['created_at']));
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
              <a class="dropdown-item" href="../admin/patient_solo_module.php?pet_id=' . $row['pet_id'] . '&user_id=' . $row['user_id'] . '" target="_blank">View</a>
          </div>
      </div>';
    }
  ),

  array(
    'db' => 'users.user_id',
    'dt' => 8,
    'field' => 'user_id',
    'formatter' => function ($lab5, $row) {
      return $row['user_id'];
    }
  ),
);

// Database connection details
include '../../connections/ssp_connection.php';

// Include the SSP class
require('../../assets/datatables/ssp.class.php');

$where = "pets.pet_id";

$joinQuery = "FROM $table
              LEFT JOIN users ON $table.user_id = users.user_id";

// Fetch and encode JOIN AND WHERE
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where));

// Fetch and encode ONLY WHERE
// echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
