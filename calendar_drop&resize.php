<?php 

// connect to database 
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// form variables
$appointmentId = mysqli_real_escape_string($connection,$_POST['appointmentId']);
$startTime = mysqli_real_escape_string($connection,$_POST['startTime']);
$endTime = mysqli_real_escape_string($connection,$_POST['endTime']);
$printerId = mysqli_real_escape_string($connection,$_POST['printerId']);

// update appointment table
$query = "  UPDATE appointment 
            SET startTime='$startTime', endTime= '$endTime', printerId = '$printerId'
            WHERE appointmentId = '$appointmentId' ";     
$result = mysqli_query($connection, $query);

// update printObject - duration
$query1 = " UPDATE printObject
            INNER JOIN appointment ON printObject.objectId = appointment.objectId
            SET printDuration = TIME_FORMAT(TIMEDIFF('$endTime','$startTime'), '%H:%i')
            WHERE appointmentId = '$appointmentId' ";    
$result = mysqli_query($connection, $query1); 

if (!empty($result)) {
    echo 'Event Updated Successfully';
} else {
    echo 'Failed to Update New Event. Error description: ' . mysqli_error($connection);
}


// close database connection
mysqli_close($connection);


?>