<?php
/*  Application: Configuration for Inserting file
*  Script Name: configInsert.php
*  Description: inserts basic form data into a SQL database.
*  Last Change/Update: 09/10/2020
*/

$db_server = 'localhost:3306';
$db_username = 'aismarth_admin';
$db_password = '0xT1kSEJ**U)';
$db_name = 'aismarth_grw';

$con = mysqli_connect($db_server,$db_username,$db_password);
if(!$con){
  echo "Not connected to server";
}

if(!mysqli_select_db($con,$db_name)){
  echo "Database not selected";
}
?>
