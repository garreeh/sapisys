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
      return '<a href="../user/user_inside_billing_module.php?billing_id=' . $row['billing_id'] . '&user_id=' . $row['user_id'] . '">' . $row['billing_id'] . ' </a>';
    }
  ),

  array(
    'db' => 'users.user_fullname',
    'dt' => 1,
    'field' => 'user_fullname',
    'formatter' => function ($lab2, $row) {
      // return $row['user_fullname'];
      return '<a href="../user/user_inside_billing_module.php?billing_id=' . $row['billing_id'] . '&user_id=' . $row['user_id'] . '">' . $row['user_fullname'] . ' </a>';
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
      return '<a href="../user/user_inside_billing_module.php?billing_id=' . $billing_id . '&user_id=' . $row['user_id'] . '">' . '₱' . number_format($total_price, 2) . ' </a>';
    }
  ),


  array(
    'db' => 'payment_status',
    'dt' => 3,
    'field' => 'payment_status',
    'formatter' => function ($lab4, $row) {
      // return $row['payment_status'];
      return '<a href="../user/user_inside_billing_module.php?billing_id=' . $row['billing_id'] . '&user_id=' . $row['user_id'] . '">' . $row['payment_status'] . ' </a>';
    }
  ),

  array(
    'db' => 'billing.created_at',
    'dt' => 4,
    'field' => 'created_at',
    'formatter' => function ($lab5, $row) {
      // return date('Y-m-d', strtotime($row['created_at']));
      return '<a href="../user/user_inside_billing_module.php?billing_id=' . $row['billing_id'] . '&user_id=' . $row['user_id'] . '">' . date('Y-m-d', strtotime($row['created_at'])) . ' </a>';
    }
  ),

  array(
    'db' => 'users.user_id',
    'dt' => 5,
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

session_start();
$user_id = $_SESSION['user_id'];

$where = "billing.user_id = $user_id";

// THIS IS A SAMPLE ONLY
$joinQuery = "FROM $table
              LEFT JOIN users ON $table.user_id = users.user_id";

// Fetch and encode JOIN AND WHERE
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where));

// Fetch and encode ONLY WHERE
// echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
