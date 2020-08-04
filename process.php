<?php
include('includes/security.php');

// connect to database
require_once('database/dbconfig.php');
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die(mysqli_error($connection));

$key = "TechnologySandbox";

// [LOGIN]
if (isset($_POST['login_btn'])) {

    $loginEmail = mysqli_real_escape_string($connection, $_POST['loginEmail']);
    $loginPassword = mysqli_real_escape_string($connection, $_POST['loginPassword']);

    $query = "SELECT adminEmail, AES_DECRYPT(password, UNHEX(SHA2('$key',512))) 
              FROM account 
              WHERE adminEmail= '$loginEmail' 
              AND password= AES_ENCRYPT('$loginPassword', UNHEX(SHA2('$key',512))) ";
    $result = mysqli_query($connection, $query);

    if (mysqli_fetch_array($result)) {
        $_SESSION['username'] = $loginEmail;
        header('Location: index.php');
    } else {
        $_SESSION['message'] = "Invalid Email or Password!";
        $_SESSION['msg_type'] = "danger";
        header('Location: login.php');
    }
}


// [LOGOUT]
if (isset($_POST['logout_btn'])) {
    session_destroy();  //Unset all of the session variables
    unset($_SESSION['username']);  //  destroys username variable
    header('Location: user_index.html'); // direct to user page
}


// [CREATE ACCOUNT]
if (isset($_POST['save_btn'])) {

    // form variable
    $adminName = mysqli_real_escape_string($connection, $_POST['adminName']);
    $adminEmail = mysqli_real_escape_string($connection, $_POST['adminEmail']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $password_confirmed = mysqli_real_escape_string($connection, $_POST['password_confirmed']);

    // check if email already exists in the database 
    $query = "SELECT * FROM account WHERE adminEmail = '$adminEmail'";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0) {  // email exists - not avaliable for creating a new account
        $_SESSION['message'] =  "ERROR: Email already exists in the database ";
        $_SESSION['msg_type'] =  "danger";
        header('Location: account.php');
    } elseif ($password != $password_confirmed) {  // if password does not match
        $_SESSION['message'] =  "ERROR: Password not matched ";
        $_SESSION['msg_type'] =  "danger";
        header('Location: account.php');
    } else {


        // insert data into account table
        $query = "INSERT INTO account (adminName,adminEmail,password) 
                  VALUES ('$adminName','$adminEmail', AES_ENCRYPT('$password', UNHEX(SHA2('$key',512))))";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $_SESSION['message'] =  "New account added successfully";
            $_SESSION['msg_type'] =  "success";
            header('Location: account.php');
        } else {
            $_SESSION['message'] =  "ERROR: Cannot create account";
            $_SESSION['msg_type'] =  "danger";
            header('Location: account.php');
        }
    }
}

// [DELETE ACCOUNT]           
if (isset($_POST['delete_btn'])) {

    $accountId = mysqli_real_escape_string($connection, $_POST['delete_id']);

    $query = "DELETE FROM account WHERE accountId = $accountId ";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['message'] = "Account data deleted successfully";
        $_SESSION['msg_type'] = "danger";
        header('Location: account.php');
    } else {
        $_SESSION['message'] = "ERROR: Cannot delete account data";
        $_SESSION['msg_type'] = "danger";
        header('Location: account.php');
    }
}


// [UPDATE ACCOUNT]                
if (isset($_POST['update_btn'])) {

    // form variable
    $accountId = mysqli_real_escape_string($connection, $_POST['edit_id']);
    $adminName = mysqli_real_escape_string($connection, $_POST['edit_adminName']);
    $adminEmail = mysqli_real_escape_string($connection, $_POST['edit_adminEmail']);
    $password = mysqli_real_escape_string($connection, $_POST['edit_password']);
    $password_new = mysqli_real_escape_string($connection, $_POST['password_new']);
    $password_confirmed_new = mysqli_real_escape_string($connection, $_POST['password_confirmed_new']);

    if (empty($password_new) && empty($password_confirmed_new)) { // didnt change password
        $query = "UPDATE account SET adminName='$adminName', adminEmail='$adminEmail' 
                  WHERE accountId= '$accountId' ";
        $result = mysqli_query($connection, $query);
    } elseif ($password_new === $password_confirmed_new) {  // changed password and new password confirmed
        $query = "UPDATE account 
                  SET adminName='$adminName', adminEmail='$adminEmail', password=AES_ENCRYPT('$password_new', UNHEX(SHA2('$key',512))) 
                  WHERE accountId= '$accountId' ";
        $result = mysqli_query($connection, $query);
    } else {  // e.g new password not matching
        $_SESSION['message'] = "ERROR: Cannot update account data";
        $_SESSION['msg_type'] = "danger";
        header('Location: account.php');
    }
    if ($result) { // if result is not empty
        $_SESSION['message'] = "Account data updated successfully";
        $_SESSION['msg_type'] = "success";
        header('Location: account.php');
    } else {
        $_SESSION['message'] = "ERROR: Cannot update account data";
        $_SESSION['msg_type'] = "danger";
        header('Location: account.php');
    }
}


// close database connection
mysqli_close($connection);
