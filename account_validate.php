<?php

// connect to database
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

// [CREATE ACCOUNT]
$adminEmail = mysqli_real_escape_string($connection, $_POST['adminEmail']);

// check if admin email already exists in the database
$query = "SELECT * FROM account WHERE adminEmail = '$adminEmail'";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {  // email exists
    echo "Email exists. Please choose a new one.";
}

// close database connection
mysqli_close($connection);