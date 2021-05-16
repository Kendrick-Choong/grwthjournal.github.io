<?php
/*  Application: Configuration for Grwth User File
*  Script Name: configInsertUser.php
*  Description: This is the login information for the user when they need to do stuff regarding the database. Users are defined as people who already have an account with Grwth.
*  Last Change/Update: 4/19/2021
*  Author: Kenny Choong
*/

//Login Info
$db_server = "aa1e6yxzujg6rwt.cpm1bav9vi9r.us-west-2.rds.amazonaws.com";
$db_username = "Grwth_User";
$db_password = "IPef058sTMPM";
$db_name = "ebdb";

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
