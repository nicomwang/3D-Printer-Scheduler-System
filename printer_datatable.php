<?php

// connect to database 
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

//colums for ordering
$col = array('printerId', 'printerName', 'printerStatus','adminNote');

//only show printers that are not deleted
$query = "SELECT * FROM printer WHERE isDeleted = '0'";
$result = mysqli_query($connection, $query);
$totalData = mysqli_num_rows($result);  

//Search
if (!empty($_POST['search']['value'])) {
    $query .= " AND (printerId Like '" . $_POST['search']['value'] . "%' ";
    $query .= " OR printerName Like '" . $_POST['search']['value'] . "%' ";
    $query .= " OR printerStatus Like '" . $_POST['search']['value'] . "%' ";
    $query .= " OR adminNote Like '" . $_POST['search']['value'] . "%' )";
}
$result = mysqli_query($connection, $query);
$totalFilter = mysqli_num_rows($result);


//Order 
if (!empty($_POST["order"])) {
    $query .= 'ORDER BY ' . $col[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
}

// content limit
if ($_POST["length"] != -1) {
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$result = mysqli_query($connection, $query);

$data = array();
while ($row = mysqli_fetch_array($result)) {
   
    $subdata = array();
    // change below for contents displaying on the printer page           
    $subdata[] = $row["printerId"];
    $subdata[] = $row["printerName"];
    $subdata[] = $row["printerStatus"];
    $subdata[] = $row["adminNote"];                               
    $subdata[] = '<button type="button" name="view_printer" id="' . $row["printerId"] . '" class="btn btn-info view_printer"><i class="far fa-eye"></i></button>';
    $subdata[] = '<button type="button" name="update" id="' . $row["printerId"] . '" class="btn btn-primary update" data-toggle="modal" data-target="#userModal"><i class="far fa-edit"></i></button>';
    $subdata[] = '<button type="button" name="delete" id="' . $row["printerId"] . '" class="btn btn-danger delete"> <i class="far fa-trash-alt"></i></button>';
    $data[] = $subdata;
}

$json_data = array(
    "draw"              =>  intval($_POST['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

// Output json 
echo json_encode($json_data);

// close database connection
mysqli_close($connection);

?>