<?php
/*  Application: Logout File
 *  Script Name: logout.php
 *  Description: Serves as a logout script that destroys the session a user is currently in.
 *  Last Change/Update: 09/6/2020
*/

// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php");
exit;
?>
