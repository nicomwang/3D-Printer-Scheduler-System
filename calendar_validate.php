<?php

// connect to database
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// form variable
$startTime = mysqli_real_escape_string($connection, $_POST['startTime']);
$endTime = mysqli_real_escape_string($connection, $_POST['endTime']);
$printerId = mysqli_real_escape_string($connection, $_POST['printerId']);

// check if this if selected printer has overlap event for selected time slot.
$query = "SELECT * FROM appointment 
          WHERE ((startTime > '$startTime' AND startTime < '$endTime')
          OR (endTime > '$startTime' AND endTime < '$endTime'))
          AND printerId = '$printerId' ";
$result = mysqli_query($connection, $query);

// if such event exists
if (mysqli_num_rows($result) > 0) { 
    echo "Schedule conflict, please change duration.";
}

// close database connection
mysqli_close($connection);