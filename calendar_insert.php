<?php

// connect to database 
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// form variables
$studentEmail  =  mysqli_real_escape_string($connection, $_POST["studentEmail"]);
$studentFirstName  =  mysqli_real_escape_string($connection, $_POST["studentFirstName"]);
$studentLastName  = mysqli_real_escape_string($connection, $_POST["studentLastName"]);

$objectName      =  mysqli_real_escape_string($connection, $_POST["objectName"]);
$printDuration     =  mysqli_real_escape_string($connection, $_POST["printDuration"]);
$filamentConsumed     = mysqli_real_escape_string($connection, $_POST["filamentConsumed"]);
$printReason     =  mysqli_real_escape_string($connection, $_POST["printReason"]);
$comment     =  mysqli_real_escape_string($connection, $_POST["comment"]);

$jobStatus   =  mysqli_real_escape_string($connection, $_POST["jobStatus"]);
$statusNote   =  mysqli_real_escape_string($connection, $_POST["statusNote"]);
$startTime    =  mysqli_real_escape_string($connection, $_POST["startTime"]);
$endTime    =  mysqli_real_escape_string($connection, $_POST["endTime"]);
$title     =  mysqli_real_escape_string($connection, $_POST["title"]);
$printerId  = mysqli_real_escape_string($connection, $_POST["printerId"]); // resourceId

$appointmentId  = mysqli_real_escape_string($connection, $_POST["appointmentId"]);
$objectId  = mysqli_real_escape_string($connection, $_POST["objectId"]);

if (isset($_POST["operation"])) {

    // [ADD EVENT]
    if ($_POST["operation"] == "Add") {

        // check if student exists
        $checkEmailQuery = "SELECT * FROM student WHERE studentEmail='$studentEmail' ";
        $checkResult = mysqli_query($connection, $checkEmailQuery);
        if (mysqli_num_rows($checkResult) > 0) {   // means email exists
            $query = "  UPDATE student 
                        SET studentFirstName = '$studentFirstName', studentLastName = '$studentLastName'		 
                        WHERE studentEmail = '$studentEmail' ";
            $result = mysqli_query($connection, $query);

        } elseif (mysqli_num_rows($checkResult) == 0) {
            // if student is not in the datatabse, insert into student table
            $query = "INSERT INTO student (studentEmail, studentFirstName, studentLastName ) 
                      VALUES ('$studentEmail', '$studentFirstName', '$studentLastName')";
            $result = mysqli_query($connection, $query);
        }


        // check if object exists
        $checkObjectQuery = "SELECT * FROM printObject WHERE objectId='$objectId'";
        $checkObjectResult = mysqli_query($connection, $checkObjectQuery);

        if (mysqli_num_rows($checkObjectResult) > 0) {   // object exists
            // if the admin selected an existing object in the datatabse, update printObject table
            $query = "  UPDATE printObject 
                        SET objectName = '$objectName', studentEmail = '$studentEmail', 
                            printDuration = '$printDuration', filamentConsumed = '$filamentConsumed',
                            printReason = '$printReason', comment = '$comment'			 
                        WHERE objectId='$objectId' ";
            $result = mysqli_query($connection, $query);

            // insert data into appointment table using associated objectId (stored in hidden objectId field)
            $query2 = " INSERT INTO appointment (printerId , objectId, jobStatus, statusNote, startTime, endTime, title) 
                        VALUES ('$printerId', '$objectId', '$jobStatus', NULLIF('$statusNote',''), '$startTime', DATE_FORMAT(ADDTIME('$startTime','$printDuration'), '%Y-%m-%d %H:%i'), '$title')";
            $result = mysqli_query($connection, $query2);

        } else {
            // if object is not in the datatabse, insert into printObject table
            $query1 = " INSERT INTO printObject (objectName , studentEmail, printDuration, filamentConsumed, printReason, comment) 
                        VALUES ('$objectName', '$studentEmail', '$printDuration', '$filamentConsumed', '$printReason', NULLIF('$comment',''))";
            $result = mysqli_query($connection, $query1);

            // insert data into appointment table using last inserted objectId
            $lastInsertedObjectId = mysqli_insert_id($connection);
            $query2 = "INSERT INTO appointment (printerId , objectId, jobStatus, statusNote, startTime, endTime, title) 
                   VALUES ('$printerId', '$lastInsertedObjectId', '$jobStatus', NULLIF('$statusNote',''), '$startTime', DATE_FORMAT(ADDTIME('$startTime','$printDuration'), '%Y-%m-%d %H:%i'), '$title')";
            $result = mysqli_query($connection, $query2);
        }

        if (!empty($result)) {
            echo 'Event Added Successfully';
        } else {
            echo 'Failed to Add New Event. Error description: ' . mysqli_error($connection);
        }
    }

    // [UPDATE EVENTS]
    if ($_POST["operation"] == "Update") {

        // update printer table
        $query = "  UPDATE student 
                    SET studentFirstName = '$studentFirstName', studentLastName = '$studentLastName'
                    WHERE studentEmail = '$studentEmail' ";
        $result = mysqli_query($connection, $query);

         // update printerObject table
        $query1 = " UPDATE printObject 
                    SET objectName = '$objectName', studentEmail = '$studentEmail', 
                        printDuration = '$printDuration', filamentConsumed = '$filamentConsumed',
                        printReason = '$printReason', comment = '$comment'			 
                    WHERE objectId = '$objectId'";
        $result = mysqli_query($connection, $query1);

         // update appointment table
        $query2 = " UPDATE appointment 
                    SET title= '$title', jobStatus='$jobStatus', statusNote='$statusNote', 
                        startTime='$startTime', endTime = ADDTIME('$startTime','$printDuration')
                    WHERE appointmentId = '$appointmentId' ";
        $result = mysqli_query($connection, $query2);


        if (!empty($result)) {
            echo 'Event Updated Successfully';
        } else {
            echo 'Failed to Update New Event. Error description: ' . mysqli_error($connection);
        }
    }
}


// close database connection
mysqli_close($connection);
