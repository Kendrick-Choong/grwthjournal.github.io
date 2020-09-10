<?php
/*  Application: Configuration file
*  Script Name: config.php
*  Description: inserts basic form data into a SQL database.
*  Last Change/Update: 09/8/2020
*/

$db_server = '127.0.0.1';
$db_username = 'root';
$db_password = '';
$db_name = 'test_database';

$con = mysqli_connect($db_server,$db_username,$db_password);
if(!$con){
  echo "Not connected to server";
}

if(!mysqli_select_db($con,$db_name)){
  echo "Database not selected";
}
?>
