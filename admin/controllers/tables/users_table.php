<?php

// Define table and primary key
$table = 'users';
$primaryKey = 'user_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'user_id',
    'dt' => 0,
    'field' => 'user_id',
    'formatter' => function ($lab1, $row) {
      return $row['user_id'];
    }
  ),
  array(
    'db' => 'S_USERCODE',
    'dt' => 1,
    'field' => 'S_USERCODE',
    'formatter' => function ($lab2, $row) {
      return $row['S_USERCODE'];
    }
  ),
  array(
    'db' => 'S_USERNAME',
    'dt' => 2,
    'field' => 'S_USERNAME',
    'formatter' => function ($lab3, $row) {
      return $row['S_USERNAME'];
    }
  ),

  array(
    'db' => 'S_STATUSXX',
    'dt' => 3,
    'field' => 'S_STATUSXX',
    'formatter' => function ($lab5, $row) {
      $account_status = $row['S_STATUSXX'];
      $color = ($account_status === 'Active') ? '#90EE90' : '#FFCCCB'; // Light Green for Active, Light Red for Inactive
      $width = '70px';
      $height = '30px';
      $border_radius = '10px';

      return '<span style="display: inline-block; background-color: ' . $color . '; width: ' . $width . '; height: ' . $height . '; border-radius: ' . $border_radius . '; text-align: center; line-height: ' . $height . '; ">' . $account_status . '</span>';
    }
  ),

  array(
    'db' => 'user_id',
    'dt' => 4,
    'field' => 'user_id',
    'formatter' => function ($lab6, $row) {
      return '
                <div class="dropdown">
                    <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['user_id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['user_id'] . '">
                        <a class="dropdown-item fetchDataUser" href="#">Edit</a>
                        <a class="dropdown-item fetchDataUserDelete" href="#">Delete</a>
                    </div>
                </div>';
    }
  ),

);

// Database connection details
include '../../../connections/ssp_connection.php';

// Include the SSP class
require('../../../assets/datatables/ssp.class_with_where.php');

// Define where clause if needed
$where = "user_id > 0";

// Fetch and encode data
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
