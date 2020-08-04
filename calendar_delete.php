<?php

require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// Delete printer 
if(isset($_POST["appointmentId"])){

	$appointmentId = $_POST['appointmentId'];

    $query = "DELETE FROM appointment WHERE appointmentId = '$appointmentId'";
    $result = mysqli_query($connection, $query);

	if(!empty($result))
	{
		echo ' Data Deleted Successfully';
	} else{
		echo 'Failed to Delete Printer Error description: ' . mysqli_error($connection);
	}
}

 // close database connection
 mysqli_close($connection);

?>
