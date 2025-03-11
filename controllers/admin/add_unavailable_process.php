<?php

include '../../connections/connections.php';

if (isset($_POST['add_unavailable'])) {
    // Get form data
    $unavailable_date = $conn->real_escape_string($_POST['unavailable_date']);

    $checkSql = "SELECT * FROM `unavailable_dates` WHERE unavailable_date = '$unavailable_date'";
    $checkResult = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        $response = array('success' => false, 'message' => 'Date Close already exists!');
        echo json_encode($response);
        exit();
    }

    $sql = "INSERT INTO `unavailable_dates` (unavailable_date) VALUES ('$unavailable_date')";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        $response = array('success' => true, 'message' => 'Date Close Added successfully!');
        echo json_encode($response);
        exit();
    } else {
        $response = array('success' => false, 'message' => 'Error Adding Date Close!: ' . mysqli_error($conn));
        echo json_encode($response);
        exit();
    }
}
?>
