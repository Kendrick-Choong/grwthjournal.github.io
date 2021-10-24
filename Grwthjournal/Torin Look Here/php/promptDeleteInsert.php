<?php
/*  Application: Delete Prompt File
 *  Script Name: promptDeleteInsert.php
 *  Description: This is the file that will delete a prompt response from our database.
 *  Last Change/Update: 1/10/2021
 *  Author: Kenny Choong
*/

// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
require_once "configInsertAdmin.php";


if (isset($_GET["entry_id"])) {

  //Get the entry id from the url
  $entry_id = $_GET["entry_id"];

  //Create an SQL statement to be injected into the database
  $sql = "DELETE FROM grwth_prompt WHERE entry_id = '$entry_id'";

  //Check to see if the query can run, if it can't throw an error, if it can, redirect to the userprompts page.
  if(!mysqli_query($con,$sql)){
    echo "There was an error submitting your response, please try again.";
  } else {
    header("Location:  http://grwthjournal.us-west-2.elasticbeanstalk.com/php/dashboard.php");
  }
}

//Close the connection
mysqli_close($con);
?>
