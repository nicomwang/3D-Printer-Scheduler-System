<?php
+
// connect to database 
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// get form input
$studentEmail = mysqli_real_escape_string($connection, $_POST['studentEmail']);

// run query 
$query = "  SELECT objectName, objectId
            FROM printObject 
            WHERE studentEmail= '$studentEmail' ";

$result = mysqli_query($connection, $query);


// Returning array
$data_array = array();

while ($row = mysqli_fetch_array($result)) {
    $objectId = $row['objectId'];
    $objectName = $row['objectName'];
    $data_array[] = array("objectId" => $objectId, "objectName" => $objectName);
}

// encoding array to json format
echo json_encode($data_array);

// close database connection
mysqli_close($connection);
