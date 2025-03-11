<?php

include '../../connections/connections.php';

if (isset($_POST['edit_appointment'])) {
  
    $appointment_id = $conn->real_escape_string($_POST['appointment_id']);
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $pet_id = $conn->real_escape_string($_POST['pet_id']);
    $timeslot_id = $conn->real_escape_string($_POST['timeslot_id']);
    $appointment_date = $conn->real_escape_string($_POST['appointment_date']);
    
    // Construct SQL query for UPDATE
    $sql = "UPDATE `appointment` 
            SET category_id = '$category_id',
                pet_id = '$pet_id',
                timeslot_id = '$timeslot_id',
                appointment_date = '$appointment_date'
            WHERE appointment_id = '$appointment_id'";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        // Appointment updated successfully
        $response = array('success' => true, 'message' => 'Appointment updated successfully!');
        echo json_encode($response);
        exit();
    } else {
        // Error updating appointment
        $response = array('success' => false, 'message' => 'Error updating Appointment: ' . mysqli_error($conn));
        echo json_encode($response);
        exit();
    } 
}
?>
