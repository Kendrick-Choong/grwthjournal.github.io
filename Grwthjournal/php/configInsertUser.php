<?php
/*  Application: Configuration for Grwth User File
*  Script Name: configInsertUser.php
*  Description: This is the login information for the user when they need to do stuff regarding the database. Users are defined as people who already have an account with Grwth.
*  Last Change/Update: 12/16/2020
*  Author: Kenny Choong
*/

//Login Info
$db_server = 'localhost:3306';
$db_username = 'aismarth_user';
$db_password = 'IPef058sTMPM';
$db_name = 'aismarth_grwth';

//Testing connection to server
$con = mysqli_connect($db_server,$db_username,$db_password);
if(!$con){
  echo "Not connected to server";
}

//Create a link for mysqli functions
$link = mysqli_connect($db_server,$db_username,$db_password,$db_name);

//Selecting a database from the server
if(!mysqli_select_db($con,$db_name)){
  echo "Database not selected";
}
?>
