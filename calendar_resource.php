<?php

// connect to database 
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// run query 
$query = "SELECT printerName, printerStatus, printerId, eventColor 
          FROM printer 
          WHERE isDeleted = '0'";
$result = mysqli_query($connection, $query);

 // Returning array
$data_array = array();

while($row = mysqli_fetch_array($result)){
  array_push($data_array, array( "title"=>$row["printerName"], 
                                "id" => $row["printerId"], 
                                "printerStatus"=>$row["printerStatus"], 
                                "eventColor" => $row["eventColor"]));
}

// Output json 
echo json_encode($data_array);

// close database connection
mysqli_close($connection);
