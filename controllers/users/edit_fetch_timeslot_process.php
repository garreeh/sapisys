<?php
include './../../connections/connections.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['date'])) {
    $selected_date = $_POST['date'];

    $selected_date = mysqli_real_escape_string($conn, $selected_date); // Make sure $selected_date is properly escaped
    $query = "SELECT timeslot.timeslot_id, timeslot.time_from, timeslot.time_to,
                  CASE 
                      WHEN appointment.appointment_id IS NULL THEN 'Available'
                      ELSE 'Booked'
                  END AS status
              FROM timeslot
              LEFT JOIN appointment ON timeslot.timeslot_id = appointment.timeslot_id 
              AND appointment.appointment_date = '$selected_date'";
    

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Fetch all time slots with their statuses
    $available_timeslots = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Add an additional property to indicate booking status
        $row['booked'] = ($row['status'] === 'Booked');
        $available_timeslots[] = $row;
    }

    // Return the available time slots as JSON with success status
    echo json_encode([
        'success' => true,
        'timeslots' => $available_timeslots
    ]);

    // Close the database connection
    mysqli_close($conn);
    exit;
}
?>
