<?php

// Define table and primary key
$table = 'appointment';
$primaryKey = 'appointment_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'appointment_id',
    'dt' => 0,
    'field' => 'appointment_id',
    'formatter' => function ($lab1, $row) {
      return $row['appointment_id'];
    }
  ),

  array(
    'db' => 'queue_number',
    'dt' => 1,
    'field' => 'queue_number',
    'formatter' => function ($lab2, $row) {
      $queue_number = $row['queue_number'];
      $style = 'background-color: lightgreen; border-radius: 5px; padding: 5px;';
      return "<span style=\"$style\">{$queue_number}</span>";
    }
  ),

  array(
    'db' => 'category.category_name',
    'dt' => 2,
    'field' => 'category_name',
    'formatter' => function ($lab3, $row) {
      return $row['category_name'];
    }
  ),

  array(
    'db' => 'pets.pet_name',
    'dt' => 3,
    'field' => 'pet_name',
    'formatter' => function ($lab3, $row) {
      return $row['pet_name'];
    }
  ),

  array(
    'db' => 'appointment_date',
    'dt' => 4,
    'field' => 'appointment_date',
    'formatter' => function ($lab3, $row) {
      return date("F j, Y", strtotime($row['appointment_date']));
    }
  ),


  array(
    'db' => 'appointment_status',
    'dt' => 5,
    'field' => 'appointment_status',
    'formatter' => function ($lab4, $row) {
      $appointment_status = $row['appointment_status'];

      // Define styles for different statuses
      $style = '';
      if ($appointment_status === 'Pending') {
        $style = 'background-color: lightyellow; border-radius: 5px; padding: 5px;';
      } elseif ($appointment_status === 'Ongoing') {
        $style = 'background-color: lightgreen; border-radius: 5px; padding: 5px;';
      } elseif ($appointment_status === 'Completed') {
        $style = 'background-color: lightgreen; border-radius: 5px; padding: 5px;';
      } elseif ($appointment_status === 'Cancelled') {
        $style = 'background-color: #FF474C; border-radius: 5px; padding: 5px;';
      }

      return "<span style=\"$style\">{$appointment_status}</span>";
    }
  ),


  array(
    'db' => 'appointment.created_at',
    'dt' => 6,
    'field' => 'created_at',
    'formatter' => function ($lab5, $row) {
      return date('Y-m-d', strtotime($row['created_at']));
    }
  ),

  array(
    'db' => 'appointment_id',
    'dt' => 7,
    'field' => 'appointment_id',
    'formatter' => function ($lab6, $row) {

      return '
      <div class="dropdown">
          <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['appointment_id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              &#x22EE;
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['appointment_id'] . '">
              <a class="dropdown-item fetchDataAppointment" href="#">Delete</a>
          </div>
      </div>';
    }
  ),
);

// Database connection details
include '../../connections/ssp_connection.php';

// Include the SSP class
require('../../assets/datatables/ssp.class.php');

$where = "appointment_status = 'Cancelled' OR appointment_status = 'Completed'";

$joinQuery = "FROM $table
              LEFT JOIN category ON $table.category_id = category.category_id
              LEFT JOIN users ON $table.user_id = users.user_id
              LEFT JOIN pets ON $table.pet_id = pets.pet_id";



// Fetch and encode JOIN AND WHERE
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where));

// Fetch and encode ONLY WHERE
// echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
