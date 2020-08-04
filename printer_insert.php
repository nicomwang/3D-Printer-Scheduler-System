<?php

// connect to database
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

if (isset($_POST["operation"])) {

	$printerName =  mysqli_real_escape_string($connection, $_POST["printerName"]);
	$buildVolume =  mysqli_real_escape_string($connection, $_POST["buildVolume"]);
	$printSurface = mysqli_real_escape_string($connection, $_POST["printSurface"]);
	$printerStatus =  mysqli_real_escape_string($connection, $_POST["printerStatus"]);
	$extruder    =  mysqli_real_escape_string($connection, $_POST["extruder"]);
	$publicNote    =  mysqli_real_escape_string($connection, $_POST["publicNote"]);
	$adminNote    = mysqli_real_escape_string($connection, $_POST["adminNote"]);
	$printerId    =  mysqli_real_escape_string($connection, $_POST["printer_id"]);
	$filamentType = mysqli_real_escape_string($connection, implode(', ', $_POST['filamentType']));
	$filamentSize = mysqli_real_escape_string($connection, implode(', ', $_POST['filamentSize']));
	$eventColor    =  mysqli_real_escape_string($connection, $_POST["eventColor"]);

	$checkboxFilamentType = $_POST['filamentType'];
	$checkboxFilamentSize = $_POST['filamentSize'];

	// [ADD PRINTER]
	if ($_POST["operation"] == "Add") {

		// insert into priner table
		$query = "INSERT INTO printer (printerName, buildVolume, printSurface, printerStatus, extruder, 
							  publicNote, adminNote, filamentType, filamentSize, eventColor, isDeleted ) 
                  VALUES ('$printerName', '$buildVolume', '$printSurface', '$printerStatus', '$extruder', 
						 NULLIF('$publicNote',''), NULLIF('$adminNote',''), '$filamentType', '$filamentSize', '$eventColor' , '0')";
		$result = mysqli_query($connection, $query);

		// insert info printerFilamentType Table 
		$lastPrinterId = mysqli_insert_id($connection); // get the printerId of last inserted printer
		foreach ($checkboxFilamentType as $chk1) { // loop through each selected filamentType
			$query1 = " INSERT INTO printerFilamentType (printerId, materialId) 
						SELECT p.printerId, m.materialId 
						FROM printer p, filamentType m
						WHERE p.printerId = '$lastPrinterId' 
						AND m.material = '$chk1' ";
			$result = mysqli_query($connection, $query1);
		} // end foreach

		// insert info printerFilamentSize Table
		foreach ($checkboxFilamentSize as $chk2) { // loop through each selected filamentSize
			$query2 = " INSERT INTO printerFilamentSize (printerId, sizeId) 
						SELECT p.printerId, s.sizeId 
						FROM printer p, filamentSize s
						WHERE p.printerId = '$lastPrinterId' 
						AND s.size = '$chk2' ";
			$result = mysqli_query($connection, $query2);
		} // end foreach

		if (!empty($result)) {
			echo 'Printer Added Successfully';
		} else {
			echo 'Failed to Add New Printer. Error description: ' . mysqli_error($connection);
		}
	}

	// [UPDATE PRINTER]
	if ($_POST["operation"] == "Update") {

		// update printer table
		$query = "  UPDATE printer 
			        SET printerName = '$printerName', buildVolume = '$buildVolume', printSurface = '$printSurface', 
			           printerStatus = '$printerStatus', extruder = '$extruder', publicNote = '$publicNote', 
					   adminNote = '$adminNote', filamentType = '$filamentType', filamentSize = '$filamentSize', eventColor='$eventColor'		 
				    WHERE printerId = '$printerId' ";
		$result = mysqli_query($connection, $query);

		// update printerfilamenttype - delete old filamentType checkbox and insert new checkbox 
		$query = "DELETE FROM printerfilamenttype WHERE printerId = '$printerId';";
		$result = mysqli_query($connection, $query);
		foreach ($checkboxFilamentType as $chk1) {
			$query1 = " INSERT INTO printerFilamentType (printerId, materialId) 
						SELECT p.printerId, m.materialId 
						FROM printer p, filamentType m
						WHERE p.printerId = '$printerId' 
						AND m.material = '$chk1'";
			$result = mysqli_query($connection, $query1);
		} // end foreach

		// update printerFilamentSize 
		$query = "DELETE FROM printerFilamentSize WHERE printerId = '$printerId';";
		$result = mysqli_query($connection, $query);
		foreach ($checkboxFilamentSize as $chk2) {
			$query2 = " INSERT INTO printerFilamentSize (printerId, sizeId) 
						SELECT p.printerId, s.sizeId 
						FROM printer p, filamentSize s
						WHERE p.printerId = '$printerId' 
						AND s.size = '$chk2' ";
			$result = mysqli_query($connection, $query2);
		} // end foreach

		if (!empty($result)) {
			echo 'Printer Updated Successfully';
		} else {
			echo 'Failed to Updated New Printer. Error description: ' . mysqli_error($connection);
		}
	}
}



// close database connection
mysqli_close($connection);
