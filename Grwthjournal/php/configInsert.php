<?php
/* Application: Configuration for Inserting Data File
*  Script Name: configInsert.php
*  Description: This script configures the database connection to just be insert only for people who don't have accounts with Grwth and are using our intiial surveys.
*  Last Change/Update: 12/16/2020
*  Authoer: Kenny Choong
*/

//Login Info
$db_server = "localhost:3306";
$db_username = "aismarth_inonly";
$db_password = "INonlyPassword";
$db_name = "aismarth_grwth";

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
