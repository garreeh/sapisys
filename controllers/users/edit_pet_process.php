<?php

include '../../connections/connections.php';

if (isset($_POST['edit_pet'])) {
    $pet_id = $conn->real_escape_string($_POST['pet_id']);
    $pet_name = $conn->real_escape_string($_POST['pet_name']);
    $breed = $conn->real_escape_string($_POST['breed']);
    $species = $conn->real_escape_string($_POST['species']);
    $birthdate = $conn->real_escape_string($_POST['birthdate']);
    $neutered = $conn->real_escape_string($_POST['neutered']);

    // Construct SQL query for UPDATE
    $sql = "UPDATE `pets` 
            SET pet_name = '$pet_name',
                breed = '$breed',
                species = '$species',
                birthdate = '$birthdate',
                neutered = '$neutered'
            WHERE pet_id = '$pet_id'";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        // Pet updated successfully
        $response = array('success' => true, 'message' => 'Pet updated successfully!');
        echo json_encode($response);
        exit();
    } else {
        // Error updating pet
        $response = array('success' => false, 'message' => 'Error updating Pet: ' . mysqli_error($conn));
        echo json_encode($response);
        exit();
    } 
}
?>
