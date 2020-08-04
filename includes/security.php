<?php
session_start();

// if not logged in, always redirect to public user page
if (!$_SESSION['username']) {
    header('Location: user_index.html');
}
