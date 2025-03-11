<?php
// Include your database connection here
include '../../connections/connections.php';

$user_id = isset($_GET['user_id']) ? htmlspecialchars($_GET['user_id']) : 'Unknown User';
$billing_id = isset($_GET['billing_id']) ? htmlspecialchars($_GET['billing_id']) : 'No Billing ID';

// Fetch total items and total price from the database
$query = "SELECT *, COUNT(*) AS total_items, SUM(price) AS total_price FROM inside_billing WHERE billing_id = $billing_id";

$result = mysqli_query($conn, $query);

// Fetch data
$data = mysqli_fetch_assoc($result);

// Return the response as JSON
echo json_encode($data);
