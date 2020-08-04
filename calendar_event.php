<?php

// connect to database 
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// run query 
$query = "  SELECT * FROM appointment, student, printObject, printer
            WHERE appointment.objectId = printObject.objectId 
            AND printObject.studentEmail = student.studentEmail
            AND appointment.printerId = printer.printerId
            AND printer.isDeleted = '0' " ;

$result = mysqli_query($connection, $query);

 // Returning array
$json_data = array();

// fetch result
while($row = mysqli_fetch_array($result)){

      // Merge the resource array into the return array
    array_push($json_data, array("title"=>$row["title"], 
                                 "start"=>$row["startTime"], 
                                 "end" => $row["endTime"],
                                 "id" => $row["appointmentId"],
                                 "resourceId" => $row["printerId"],
                                 "extendedProps" => array( "printerId" => $row["printerId"],
                                                           "jobStatus" => $row["jobStatus"],
                                                           "studentFirstName" =>$row["studentFirstName"],
                                                           "studentLastName" =>$row["studentLastName"])
                                ));
}

 // Output json 
echo json_encode($json_data);

// close database connection
mysqli_close($connection);
