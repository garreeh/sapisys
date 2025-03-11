<?php
include '../../connections/connections.php';
// Define table and primary key
$table = 'billing';
$primaryKey = 'billing_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'billing_id',
    'dt' => 0,
    'field' => 'billing_id',
    'formatter' => function ($lab1, $row) {
      // return $row['billing_id'];
      return '<a href="../admin/inside_billing_module.php?billing_id=' . $row['billing_id'] . '&user_id=' . $row['user_id'] . '">' . $row['billing_id'] . ' </a>';
    }
  ),

  array(
    'db' => 'users.user_fullname',
    'dt' => 1,
    'field' => 'user_fullname',
    'formatter' => function ($lab2, $row) {
      // return $row['user_fullname'];
      return '<a href="../admin/inside_billing_module.php?billing_id=' . $row['billing_id'] . '&user_id=' . $row['user_id'] . '">' . $row['user_fullname'] . ' </a>';
    }
  ),

  array(
    'db' => 'billing_id',
    'dt' => 2,
    'field' => 'billing_id',
    'formatter' => function ($lab4, $row) use ($conn) {

      // Query to sum prices based on billing_id
      $billing_id = $row['billing_id'];
      $query = "SELECT SUM(price) AS total_price FROM inside_billing WHERE billing_id = '$billing_id'";
      $result = mysqli_query($conn, $query);

      // Fetch total price
      $total = mysqli_fetch_assoc($result);
      $total_price = $total['total_price'];

      // Return the formatted HTML with total price link
      return '<a href="../admin/inside_billing_module.php?billing_id=' . $billing_id . '&user_id=' . $row['user_id'] . '">' . '₱' . number_format($total_price, 2) . ' </a>';
    }
  ),


  array(
    'db' => 'payment_status',
    'dt' => 3,
    'field' => 'payment_status',
    'formatter' => function ($lab4, $row) {
      // return $row['payment_status'];
      return '<a href="../admin/inside_billing_module.php?billing_id=' . $row['billing_id'] . '&user_id=' . $row['user_id'] . '">' . $row['payment_status'] . ' </a>';
    }
  ),

  array(
    'db' => 'billing.created_at',
    'dt' => 4,
    'field' => 'created_at',
    'formatter' => function ($lab5, $row) {
      // return date('Y-m-d', strtotime($row['created_at']));
      return '<a href="../admin/inside_billing_module.php?billing_id=' . $row['billing_id'] . '&user_id=' . $row['user_id'] . '">' . date('Y-m-d', strtotime($row['created_at'])) . ' </a>';
    }
  ),

  array(
    'db' => 'billing_id',
    'dt' => 5,
    'field' => 'billing_id',
    'formatter' => function ($lab6, $row) {

      return '
      <div class="dropdown">
          <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['billing_id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              &#x22EE;
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['billing_id'] . '">
              <a class="dropdown-item fetchDataCategory" href="../admin/inside_billing_module.php?billing_id=' . $row['billing_id'] . '&user_id=' . $row['user_id'] . '">Modify</a>
              <a class="dropdown-item delete-user" href="#" data-user-id="' . $row['billing_id'] . '">Delete</a>
          </div>
      </div>';
    }
  ),

  array(
    'db' => 'users.user_id',
    'dt' => 6,
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

$where = "billing_id";

// THIS IS A SAMPLE ONLY
$joinQuery = "FROM $table
              LEFT JOIN users ON $table.user_id = users.user_id";

// Fetch and encode JOIN AND WHERE
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where));

// Fetch and encode ONLY WHERE
// echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
