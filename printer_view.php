<?php

// connect to database
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

if (isset($_POST["printer_id"])) {

     $output = '';
     $query = "SELECT * FROM printer WHERE printerId = '" . $_POST["printer_id"] . "'";
     $result = mysqli_query($connection, $query);

     // create a table to show printer details
     $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';

     while ($row = mysqli_fetch_array($result)) {
          $output .= '  
               <tr>  
                     <td width="30%"><label><Strong>Printer Name</strong></label></td>  
                     <td width="70%">' . $row["printerName"] . '</td>  
               </tr>  
               <tr>  
                     <td width="30%"><label><Strong>Printer Status</strong></label></td>  
                     <td width="70%">' . $row["printerStatus"] . '</td>  
               </tr>  
               <tr>  
                    <td width="30%"><label><Strong>Build Volume</strong></label></td>  
                    <td width="70%">' . $row["buildVolume"] . ' mm </td>  
               </tr>  
               <tr>  
                    <td width="30%"><label><Strong>Printer Surface</strong></label></td>  
                    <td width="70%">' . $row["printSurface"] . '</td>  
               </tr>  
               <tr>  
                    <td width="30%"><label><Strong>Extruder</strong></label></td>  
                    <td width="70%">' . $row["extruder"] . '</td>  
               </tr> 
               <tr>  
                    <td width="30%"><label><Strong>Filament Type</strong></label></td>  
                    <td width="70%">' . $row["filamentType"] . '</td>  
               </tr> 
               <tr>  
                    <td width="30%"><label><Strong>Filament Size</strong></label></td>  
                    <td width="70%">' . $row["filamentSize"] . '</td>  
               </tr>  
               <tr>  
                    <td width="30%"><label><Strong>Public Note</strong></label></td>  
                    <td width="70%">' . $row["publicNote"] . '</td>  
               </tr>  
               <tr>  
                     <td width="30%"><label><Strong>Admin Note</strong></label></td>  
                     <td width="70%">' . $row["adminNote"] . '</td>  
               </tr> 
           ';
     }
     $output .= '  
           </table>  
      </div>  
      ';
     echo $output;

}

// close database connection
mysqli_close($connection);
