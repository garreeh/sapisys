<?php

// Define table and primary key
$table = 'vaccination';
$primaryKey = 'vaccination_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'vaccination_id',
    'dt' => 0,
    'field' => 'vaccination_id',
    'formatter' => function ($lab1, $row) {
      return $row['vaccination_id'];
    }
  ),

  array(
    'db' => 'vaccine.vaccine_name',
    'dt' => 1,
    'field' => 'vaccine_name',
    'formatter' => function ($lab2, $row) {
      return $row['vaccine_name'];
    }
  ),

  array(
    'db' => 'expiration_date',
    'dt' => 2,
    'field' => 'expiration_date',
    'formatter' => function ($lab2, $row) {
      return date('F j, Y', strtotime($row['expiration_date']));
    }
  ),



  array(
    'db' => 'vaccination.created_at',
    'dt' => 3,
    'field' => 'created_at',
    'formatter' => function ($lab4, $row) {
      return date('Y-m-d', strtotime($row['created_at']));
    }
  ),

  array(
    'db' => 'vaccination.updated_at',
    'dt' => 4,
    'field' => 'updated_at',
    'formatter' => function ($lab5, $row) {
      return date('Y-m-d', strtotime($row['updated_at']));
    }
  ),

  array(
    'db' => 'vaccination_id',
    'dt' => 5,
    'field' => 'vaccination_id',
    'formatter' => function ($lab6, $row) {

      return '
      <div class="dropdown">
          <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['vaccination_id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              &#x22EE;
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['vaccination_id'] . '">
              <a class="dropdown-item fetchDataVaccination" href="#">Edit</a>
              <a class="dropdown-item fetchDataVaccinationDelete" href="#">Delete</a>

          </div>
      </div>';
    }
  ),

);

// Database connection details
include '../../connections/ssp_connection.php';
// Include the SSP class
require('../../assets/datatables/ssp.class.php');

$pet_id = isset($_GET['pet_id']) ? $_GET['pet_id'] : null;
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

$where = "vaccination.pet_id = '$pet_id' AND vaccination.user_id = '$user_id'";

$joinQuery = "FROM $table
              LEFT JOIN vaccine ON $table.vaccine_id = vaccine.vaccine_id
              LEFT JOIN users ON $table.user_id = users.user_id
              LEFT JOIN pets ON $table.pet_id = pets.pet_id";

// Fetch and encode JOIN AND WHERE
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where));

// Fetch and encode ONLY WHERE
// echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));