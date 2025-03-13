<?php

// Define table and primary key
$table = 'clients';
$primaryKey = 'client_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'client_id',
    'dt' => 0,
    'field' => 'client_id',
    'formatter' => function ($lab1, $row) {
      return $row['client_id'];
    }
  ),
  array(
    'db' => 'S_CUSTCODE',
    'dt' => 1,
    'field' => 'S_CUSTCODE',
    'formatter' => function ($lab2, $row) {
      return $row['S_CUSTCODE'];
    }
  ),

  array(
    'db' => 'S_CUSTNAME',
    'dt' => 2,
    'field' => 'S_CUSTNAME',
    'formatter' => function ($lab3, $row) {
      return $row['S_CUSTNAME'];
    }
  ),

  array(
    'db' => 'S_AGNTCODE',
    'dt' => 3,
    'field' => 'S_AGNTCODE',
    'formatter' => function ($lab3, $row) {
      return $row['S_AGNTCODE'];
    }
  ),

  array(
    'db' => 'S_TOWNCODE',
    'dt' => 4,
    'field' => 'S_TOWNCODE',
    'formatter' => function ($lab3, $row) {
      return $row['S_TOWNCODE'];
    }
  ),

  array(
    'db' => 'client_id',
    'dt' => 5,
    'field' => 'client_id',
    'formatter' => function ($lab6, $row) {
      return '
                <div class="dropdown">
                    <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['client_id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['client_id'] . '">
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
$where = "client_id > 0";

// Fetch and encode data
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
