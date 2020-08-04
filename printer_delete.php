<?php

require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// [DELETE PRINTER]
if(isset($_POST["printer_id"])){

	$printerId = $_POST['printer_id'];
	
	// set isDeleted to true when clicked on delete button
	$query = " 	UPDATE printer 
				SET isDeleted = '1' 
				WHERE printerId = '$printerId' ";
	$result = mysqli_query($connection, $query);
	
	if(!empty($result))
	{
		// show deleted message while printer data remains in the database
		echo 'Printer Deleted Successfully';
	} else{
		echo 'Failed to Delete Printer Error description: ' . mysqli_error($connection);
	}
}


// close database connection
mysqli_close($connection);

?>
