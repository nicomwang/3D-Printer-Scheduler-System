<?php

// Connect to datatbase 
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// months of an academic year
$monthArray = array(9, 10, 11, 12, 1, 2, 3, 4, 5, 6, 7, 8);


// [PRINT RESULT]
if (isset($_POST["yearList_result"])) {
    $yearList_result =  mysqli_real_escape_string($connection, $_POST["yearList_result"]);  // get selected year
    $previousYear = intval($yearList_result) - 1;  // convert string of year to int. calculate first half of calendar year 
    // get acaedmic year range
    $september = $previousYear . "-09-01";  // e.g 2019-09-01
    $august = $yearList_result . "-08-30";  // e.g 2020-08-30
    $query = "  SELECT 
                     COUNT(CASE WHEN jobStatus = 'Success' THEN 1 END) as successCount,
                     COUNT(CASE WHEN jobStatus = 'Failed' THEN 1 END) as failedCount
                 FROM appointment 
                 WHERE startTime BETWEEN ' $september' AND '$august' ";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}


// [PRINT REASON]
if (isset($_POST["yearList_reason"])) {
    $yearList_reason =  mysqli_real_escape_string($connection, $_POST["yearList_reason"]);
    $previousYear = intval($yearList_reason) - 1;
    $september = $previousYear . "-09-01";  // e.g 2019-09-01
    $august = $yearList_reason . "-08-30";  // e.g 2020-08-30
    $query = "  SELECT 
                    COUNT(CASE WHEN printObject.printReason = 'School Project' THEN 1 END) as schoolCount,
                    COUNT(CASE WHEN printObject.printReason = 'Personal' THEN 1 END) as personalCount
                    FROM appointment INNER JOIN printObject 
                    ON appointment.objectId = printObject.objectId
                    WHERE startTime BETWEEN ' $september' AND '$august' ";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}


// [TOTAL PRINT TIME] 
if (isset($_POST["yearList_printTime"])) {
    $yearList_printTime =  mysqli_real_escape_string($connection, $_POST["yearList_printTime"]); // get selected year
    $previousYear = intval($yearList_printTime) - 1; // convert string of year to int. calculate first half of calendar year 
    foreach ($monthArray as $month) {
        if ($month >= "9") {
            $query = "  SELECT ROUND((SUM(TIME_TO_SEC(printObject.printDuration)))/60, 2) as totalDurationMinute,
                               ROUND((SUM(TIME_TO_SEC(printObject.printDuration)))/60/60, 2) as totalDurationHour 
                        FROM appointment INNER JOIN printObject 
                        ON appointment.objectId = printObject.objectId
                        WHERE MONTH(appointment.startTime) = '$month' AND YEAR(appointment.startTime) = '$previousYear' ";
        } elseif ($month < "9") {
            $query = "  SELECT ROUND((SUM(TIME_TO_SEC(printObject.printDuration)))/60, 2) as totalDurationMinute, 
                               ROUND((SUM(TIME_TO_SEC(printObject.printDuration)))/60/60, 2) as totalDurationHour 
                        FROM appointment INNER JOIN printObject 
                        ON appointment.objectId = printObject.objectId
                        WHERE MONTH(appointment.startTime) = '$month' AND YEAR(appointment.startTime) = '$yearList_printTime' ";
        }
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);
        $array[] = $row;
    } // end of foreach

    /* echo '<pre>'; print_r($array); echo '</pre>'; */
    echo json_encode($array);
}


// [TOTAL FILAMENT CONSUMED] 
if (isset($_POST["yearList_filament"])) {
    $yearList_filament =  mysqli_real_escape_string($connection, $_POST["yearList_filament"]); // get selected year
    $previousYear = intval($yearList_filament) - 1; // convert string of year to int. calculate first half of calendar year 

    foreach ($monthArray as $month) {
        if ($month >= "9") {
            $query = "  SELECT  ROUND(SUM(printObject.filamentConsumed), 2) as totalFilamentConsumed,
                                COUNT(appointment.appointmentId) as totalAppointments
                        FROM appointment INNER JOIN printObject 
                        ON appointment.objectId = printObject.objectId 
                        WHERE MONTH(appointment.startTime) = '$month' AND YEAR(appointment.startTime) = '$previousYear' ";
        } elseif ($month < "9") {
            $query = "  SELECT  ROUND(SUM(printObject.filamentConsumed), 2) as totalFilamentConsumed,
                                COUNT(appointment.appointmentId) as totalAppointments
                        FROM appointment INNER JOIN printObject 
                        ON appointment.objectId = printObject.objectId 
                        WHERE MONTH(appointment.startTime) = '$month' AND YEAR(appointment.startTime) = '$yearList_filament' ";
        }

        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);
        $array[] = $row;
    } // end of foreach

    /* echo '<pre>'; print_r($array); echo '</pre>'; */
    echo json_encode($array);
}


// [TOTAL NUMBER OF PRINTS]
if (isset($_POST["yearList_printNumber"])) {

    $yearList_printNumber =  mysqli_real_escape_string($connection, $_POST["yearList_printNumber"]); // get selected year
    $previousYear = intval($yearList_printNumber) - 1; // convert string of year to int. calculate first half of calendar year 

    // get all printers by id and store them in an array 
    $query = "  SELECT printerId FROM printer";
    $result = mysqli_query($connection, $query);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $printerIdArray[] = $row["printerId"];
        }
        // echo '<pre>'; print_r($printerIdArray); echo '</pre>';
    } else {
        echo "0 results";
    }

    // loop through each printer for 
    foreach ($printerIdArray as $printerId) {
        foreach ($monthArray as $month) {
            if ($month >= "9") {
                $query = "  SELECT DISTINCT printer.printerName, COUNT(appointment.printerId) as totalPrints
                        FROM appointment INNER JOIN printer 
                        ON appointment.printerId = printer.printerId
                        WHERE printer.printerId = '$printerId'
                        AND MONTH(appointment.startTime) = '$month' AND YEAR(appointment.startTime) = '$previousYear' ";
            } elseif ($month < "9") {
                $query = "  SELECT DISTINCT printer.printerName, COUNT(appointment.printerId) as totalPrints
                        FROM appointment INNER JOIN printer 
                        ON appointment.printerId = printer.printerId
                        WHERE printer.printerId = '$printerId'
                        AND MONTH(appointment.startTime) = '$month' AND YEAR(appointment.startTime) = '$yearList_printNumber' ";
            }
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            $array[] = $row;
        } // end of foreach 
    } // end of foreach

    $result = [];
    // go through each sub array and check if sub array is for the same printer name
    foreach($array as $value) { 
        if(!isset($result[$value["printerName"]])) { // No -  add it to the result array
            $result[$value["printerName"]]["printerName"] = $value["printerName"];
            $result[$value["printerName"]]["totalPrints"] = $value["totalPrints"];
        } else { // Yes - printer exists, append value of total prints to to this printer. 
            $result[$value["printerName"]]["totalPrints"] .= ", " . $value["totalPrints"];
        }
    }
    
    $result = array_values($result); // reindex the array
   // echo '<pre>'; print_r($newArray); echo '</pre>';  
    echo json_encode($result);
}
