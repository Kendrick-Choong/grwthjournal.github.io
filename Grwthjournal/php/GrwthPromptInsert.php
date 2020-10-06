<?php
/*  Application: Grwth Prompt Insert File
 *  Script Name: GrwthLoginInsert.php
 *  Description: Inserts prompt data into a SQL database.
 *  Last Change/Update: 9/24/2020
*/
require_once "configInsert.php";

$promptresponse = $_POST['promptresponse'];

//whether ip is from remote address

$sql = "INSERT INTO grwth_prompt(promptresponse)
        VALUES ('$promptresponse')";

if(!mysqli_query($con,$sql)){
  echo 'Not Inserted';
} else {
  echo 'Inserted';
}

header("Location: http://grwthjournal.co/");

mysqli_close($con);
?>
