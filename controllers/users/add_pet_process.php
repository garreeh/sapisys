<?php

session_start(); // Start the session
include '../../connections/connections.php';

if (isset($_POST['add_pet'])) {
    // Get form data
    $pet_name = $conn->real_escape_string($_POST['pet_name']);
    $breed = $conn->real_escape_string($_POST['breed']);
    $species = $conn->real_escape_string($_POST['species']);
    $birthdate = $conn->real_escape_string($_POST['birthdate']);
    $neutered = $conn->real_escape_string($_POST['neutered']);

    // Get user_id from the session
    if (isset($_SESSION['user_id'])) {
        $user_id = $conn->real_escape_string($_SESSION['user_id']);
    } else {
        // Handle the case when user_id is not found in session
        $response = array('success' => false, 'message' => 'User not logged in!');
        echo json_encode($response);
        exit();
    }

    // Construct SQL query for insertion
    $sql = "INSERT INTO `pets` (pet_name, user_id, breed, species, birthdate, neutered) VALUES 
                              ('$pet_name', 
                               '$user_id', 
                               '$breed', 
                               '$species', 
                               '$birthdate', 
                               '$neutered')";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        // Pet added successfully
        $response = array('success' => true, 'message' => 'Pet Added successfully!');
        echo json_encode($response);
        exit();
    } else {
        // Error adding pet
        $response = array('success' => false, 'message' => 'Error Adding Pet!: ' . mysqli_error($conn));
        echo json_encode($response);
        exit();
    }
}
?>
