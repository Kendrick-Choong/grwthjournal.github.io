<?php
/*  Application: Grwth Prompt Insert File
 *  Script Name: GrwthLoginInsert.php
 *  Description: Inserts prompt data into a SQL database.
 *  Last Change/Update: 9/24/2020
*/
require_once "configInsert.php";

$promptresponse = $_POST['promptresponse'];

if (!empty($_SERVER['HTTP_CLIENT_IP']))
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
//whether ip is from remote address
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }

$sql = "INSERT INTO grwth_prompt(promptresponse,ip_address)
        VALUES ('$promptresponse','$ip_address')";

if(!mysqli_query($con,$sql)){
  echo 'Not Inserted';
} else {
  echo 'Inserted';
}

mysqli_close($con);
?>
