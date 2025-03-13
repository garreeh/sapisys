<?php
session_start();
include './../../connections/connections.php';

if (isset($_POST['username'], $_POST['password'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM `users` WHERE `S_USERCODE` = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Check if account is active
            if ($row["S_STATUSXX"] != 'Active') {
                echo json_encode(['success' => false, 'message' => 'Account is not active. Please verify your email.']);
                exit();
            }

            // Verify hashed password
            if (password_verify($password, $row["S_PASSWORD"])) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['S_USERCODE'] = $row['S_USERCODE'];
                $_SESSION['S_USERNAME'] = $row['S_USERNAME'];
                $_SESSION['S_STATUSXX'] = $row['S_STATUSXX'];
                $_SESSION['S_ACCESSNO'] = $row['S_ACCESSNO'];

                echo json_encode(['success' => true]);
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => 'Incorrect password. Please try again.']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect username. Please try again.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error executing query: ' . mysqli_error($conn)]);
        exit();
    }
}
