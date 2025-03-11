<?php

include '../../connections/connections.php';

if (isset($_POST['edit_dates'])) {
    $unavailable_id = $conn->real_escape_string($_POST['unavailable_id']);
    $unavailable_date = $conn->real_escape_string($_POST['unavailable_date']);

    // Check if the date already exists for another record
    $checkSql = "SELECT * FROM `unavailable_dates` WHERE unavailable_date = '$unavailable_date' AND unavailable_id != '$unavailable_id'";
    $checkResult = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        // Date already exists for another record
        $response = array('success' => false, 'message' => 'The date already exists for another record!');
        echo json_encode($response);
        exit();
    }

    // Construct SQL query for UPDATE
    $sql = "UPDATE `unavailable_dates` 
            SET unavailable_date = '$unavailable_date'
            WHERE unavailable_id = '$unavailable_id'";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        // Date updated successfully
        $response = array('success' => true, 'message' => 'Date updated successfully!');
        echo json_encode($response);
        exit();
    } else {
        // Error updating date
        $response = array('success' => false, 'message' => 'Error updating date: ' . mysqli_error($conn));
        echo json_encode($response);
        exit();
    } 
}
?>
