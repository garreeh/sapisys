<?php

include '../../connection/connections.php';
session_start();

// Check if the user is an admin
if (isset($_SESSION['user_id'])) {
	$_SESSION = array();
	session_destroy();
	header("Location: /appointment/index.php");
	exit();
}


header("Location: /appointment/index.php");
exit();
?>