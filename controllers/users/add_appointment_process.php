<?php

include '../../connections/connections.php';
session_start();

if (isset($_POST['add_appointment'])) {
    $user_id = $_SESSION['user_id'];
    
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $pet_id = $conn->real_escape_string($_POST['pet_id']);
    $timeslot_id = $conn->real_escape_string($_POST['timeslot_id']);
    $appointment_date = $conn->real_escape_string($_POST['appointment_date']);

    // Check if the time slot is already booked for the appointment date
    $check_sql = "SELECT * FROM `appointment` WHERE timeslot_id = '$timeslot_id' AND appointment_date = '$appointment_date'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Time slot is already booked
        $response = array('success' => false, 'message' => 'Time slot is already booked for the selected date.');
        echo json_encode($response);
        exit();
    }

    // Generate queue number
    $random_number = str_pad(rand(0, 99999), 8, '0', STR_PAD_LEFT);
    $queue_number = 'APP' . $random_number;

    // Insert the appointment
    $sql = "INSERT INTO `appointment` (category_id, user_id, pet_id, timeslot_id, appointment_date, queue_number, appointment_status)
            VALUES ('$category_id', '$user_id', '$pet_id', '$timeslot_id', '$appointment_date', '$queue_number', 'Pending')";

    if (mysqli_query($conn, $sql)) {
        $response = array('success' => true, 'message' => 'Appointment added successfully!', 'queue_number' => $queue_number);
        echo json_encode($response);
        exit();
    } else {
        $response = array('success' => false, 'message' => 'Error adding appointment!: ' . mysqli_error($conn));
        echo json_encode($response);
        exit();
    } 
}
?>
