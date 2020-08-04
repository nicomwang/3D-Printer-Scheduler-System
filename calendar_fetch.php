<?php

require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// [FETCH ALL FOR UPDATE PAGE]
if (isset($_POST["appointmentId"])) {

	$query = "  SELECT * 
                FROM appointment, student, printObject
                WHERE appointment.objectId = printObject.objectId 
                AND printObject.studentEmail = student.studentEmail
                AND appointmentId = '" . $_POST["appointmentId"] . "'";
	$result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    
	echo json_encode($row);
} 


// [FETCH STUDENT INFO]
if(isset($_POST["studentEmail"]))  
 {  
      $query = "SELECT studentFirstName, studentLastName
                FROM student 
                WHERE studentEmail = '" . $_POST["studentEmail"] . "'";
      $result = mysqli_query($connection, $query);  
      $row = mysqli_fetch_array($result);
    
	echo json_encode($row);
 }  


 // [FETCH OBJECT INFO]
 if(isset($_POST["objectId"]))  
 {  
      $query = "SELECT *
                FROM printObject 
                WHERE objectId = '" . $_POST["objectId"] . "'";
      $result = mysqli_query($connection, $query);  
      $row = mysqli_fetch_array($result);
    
	echo json_encode($row);
 }  


// close database connection
mysqli_close($connection);
