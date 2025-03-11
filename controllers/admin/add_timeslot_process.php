<?php

include '../../connections/connections.php';

if (isset($_POST['add_timeslot'])) {
    // Get form data
    $time_from = $conn->real_escape_string($_POST['time_from']);
    $time_to = $conn->real_escape_string($_POST['time_to']);

    // Check if the time slot already exists or conflicts with existing slots
    $checkSql = "SELECT * FROM `timeslot` 
                 WHERE (time_from < '$time_to' AND time_to > '$time_from')";
    $checkResult = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        // Time slot conflicts with existing time slots
        $response = array('success' => false, 'message' => 'Time Slot overlaps with existing slots!');
        echo json_encode($response);
        exit();
    }

    // Construct SQL query for insertion
    $sql = "INSERT INTO `timeslot` (time_from, time_to) VALUES ('$time_from', '$time_to')";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        // Time slot added successfully
        $response = array('success' => true, 'message' => 'Time Slot Added successfully!');
        echo json_encode($response);
        exit();
    } else {
        // Error adding time slot
        $response = array('success' => false, 'message' => 'Error Adding Time Slot!: ' . mysqli_error($conn));
        echo json_encode($response);
        exit();
    }
}
?>
