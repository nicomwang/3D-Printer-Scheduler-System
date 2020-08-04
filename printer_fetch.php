<?php

// connect to database 
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// fetch single row printer data for editing
if (isset($_POST["printer_id"])) {

	$query = "SELECT * FROM printer WHERE printerId = '" . $_POST["printer_id"] . "'";
	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_array($result);

	echo json_encode($row);
} 

// close database connection
mysqli_close($connection);
