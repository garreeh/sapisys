<?php

$user_id = $_SESSION['user_id'];

// Query to sum total_price for today's sales
$query = "SELECT COUNT(pet_id) as total_pets FROM pets WHERE user_id = '$user_id'";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// If there are no sales, set daily_sales to 0
$total_pets = $row['total_pets'] ?? 0;
