<?php
/* Application: Configuration for Inserting Data File
*  Script Name: configInsert.php
*  Description: This script configures the database connection to just be insert only for people who don't have accounts with Grwth and are using our intiial surveys.
*  Last Change/Update: 4/19/2021
*  Author: Kenny Choong
*/

//Login Info
$db_server = "aa1e6yxzujg6rwt.cpm1bav9vi9r.us-west-2.rds.amazonaws.com";
$db_username = "Grwth_Insert_Only";
$db_password = "6o&21QXx^fhm1Zo";
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
