<?php

// Define table and primary key
$table = 'inside_billing';
$primaryKey = 'bill_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'items',
    'dt' => 0,
    'field' => 'items',
    'formatter' => function ($lab2, $row) {
      return $row['items'];
    }
  ),

  array(
    'db' => 'inside_billing.price',
    'dt' => 1,
    'field' => 'price',
    'formatter' => function ($lab4, $row) {
      return $row['price'];
      // return '<a href="../admin/inside_billing_module.php?billing_id=' . $row['bill_id'] . '&user_id=' . $row['user_id'] . '">' . $row['total'] . ' </a>';
    }
  ),

  array(
    'db' => 'bill_id',
    'dt' => 2,
    'field' => 'bill_id',
    'formatter' => function ($lab6, $row) {
      $bill_id = $row['bill_id'];
      $payment_status = $row['payment_status']; // Assuming `payment_status` is part of the `$row`
    
      // Conditionally render the "Delete" link based on payment_status
      return '
        <div class="dropdown">
            <button class="btn btn-info" type="button" id="dropdownMenuButton' . $bill_id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                &#x22EE;
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $bill_id . '">
                ' . ($payment_status === 'Paid'
        ? '<a class="dropdown-item text-muted" href="#" aria-disabled="true" style="pointer-events: none; color: #6c757d;">Already Paid</a>'
        : '<a class="dropdown-item fetchDataDelete" href="#" data-bill-id="' . $bill_id . '">Delete</a>'
      ) . '
            </div>
        </div>';
    }
  ),



  array(
    'db' => 'inside_billing.user_id',
    'dt' => 3,
    'field' => 'user_id',
    'formatter' => function ($lab2, $row) {
      return $row['user_id'];
    }
  ),

  array(
    'db' => 'bill_id',
    'dt' => 4,
    'field' => 'bill_id',
    'formatter' => function ($lab2, $row) {
      return $row['bill_id'];
    }
  ),

  array(
    'db' => 'payment_status',
    'dt' => 4,
    'field' => 'payment_status',
    'formatter' => function ($lab2, $row) {
      return $row['payment_status'];
    }
  ),

);

// Database connection details
include '../../connections/ssp_connection.php';

// Include the SSP class
require('../../assets/datatables/ssp.class.php');

$user_id = isset($_GET['user_id']) ? htmlspecialchars($_GET['user_id']) : 'Unknown User';

$where = "inside_billing.user_id = $user_id";

// THIS IS A SAMPLE ONLY
$joinQuery = "FROM $table
              LEFT JOIN users ON $table.user_id = users.user_id
              LEFT JOIN category ON $table.category_id = category.category_id
              LEFT JOIN vaccine ON $table.vaccine_id = vaccine.vaccine_id
              LEFT JOIN billing ON $table.billing_id = billing.billing_id
              ";

// Fetch and encode JOIN AND WHERE
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where));

// Fetch and encode ONLY WHERE
// echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
