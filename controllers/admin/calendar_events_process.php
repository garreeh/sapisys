<?php
include '../../connections/connections.php'; // Include database connection

$sqlEvents = "
    SELECT 
      appointment.appointment_id,
      appointment.queue_number,
      appointment.appointment_date,
      appointment.appointment_status,
      timeslot.time_from,
      timeslot.time_to,
      users.user_fullname,
      pets.pet_name
    FROM 
      appointment
    LEFT JOIN 
      timeslot ON appointment.timeslot_id = timeslot.timeslot_id
    LEFT JOIN 
      users ON appointment.user_id = users.user_id
    LEFT JOIN 
      pets ON appointment.pet_id = pets.pet_id
    WHERE 
      appointment.appointment_status = 'Ongoing'";

$resultset = mysqli_query($conn, $sqlEvents) or die("Database error: " . mysqli_error($conn));
$calendar = array();

while ($rows = mysqli_fetch_assoc($resultset)) {
  // Gather appointment and related user and pet data
  $appointment_id = $rows['appointment_id'];
  $queue_number = $rows['queue_number'];
  $appointment_date = $rows['appointment_date'];
  $time_from = $rows['time_from'];
  $time_to = $rows['time_to'];
  $appointment_status = $rows['appointment_status'];
  $user_fullname = $rows['user_fullname'];
  $pet_name = $rows['pet_name'];

  // Format start and end date-times
  $appointment_start_time = date('Y-m-d H:i:s', strtotime("$appointment_date $time_from"));
  $appointment_end_time = date('Y-m-d H:i:s', strtotime("$appointment_date $time_to"));

  // Convert to milliseconds for calendar format
  $start = strtotime($appointment_start_time) * 1000;
  $end = strtotime($appointment_end_time) * 1000;

  // Add to calendar array
  $calendar[] = array(
    'id' => $appointment_id,
    'title' => "Queue: $queue_number | User: $user_fullname | Pet: $pet_name | Status: $appointment_status | $time_from - $time_to",
    'class' => ($appointment_status == 'Ongoing') ? "event-warning" : "event-default",
    'start' => "$start",
    'end' => "$end"
  );
}

$calendarData = array(
  "success" => 1,
  "result" => $calendar
);

echo json_encode($calendarData);
exit;
