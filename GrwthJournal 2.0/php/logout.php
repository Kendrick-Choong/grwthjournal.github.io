<?php
/*  Application: User Logout File
 *  Script Name: logout.php
 *  Description: This file serves as a logout script that destroys the session a user is currently in so they cannot see their dashboard or use our product anymore.
 *  Last Change/Update: 12/16/2020
 *  Author: Kenny Choong
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
