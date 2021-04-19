<?php
/*  Application: Edit Insert Prompt File
 *  Script Name: promptEditInsert.php
 *  Description: This is the insert file to update the selected prompt response from our users.
 *  Last Change/Update: 4/19/2021
 *  Author: Kenny Choong
*/

// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
require_once "configInsertAdmin.php";
$entry_id = $_SESSION['entry_id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){

  $prompt_response = $_POST["prompt_response"];

  $cleaned_prompt_response = str_replace("'","''","$prompt_response");

  //Create an SQL statement to be injected into the database
  $sql = "UPDATE grwth_prompt SET grwth_prompt.prompt_response = '$cleaned_prompt_response', grwth_prompt.last_modified = CURRENT_TIMESTAMP WHERE entry_id = '$entry_id'";

  //Check to see if the query can run, if it can't throw an error, if it can, redirect to the userprompts page.
  if(!mysqli_query($con,$sql)){
    echo "There was an error submitting your response, please try again.";
  } else {
    header("Location:  http://127.0.0.1/edsa-Grwth/Grwthjournal/php/userprompts.php");
  }
}

$_SESSION['entry_id'] = '';
//Close the connection
mysqli_close($con);
?>
