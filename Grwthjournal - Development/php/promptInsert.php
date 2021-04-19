<?php
/*  Application: Prompt Insert
 *  Script Name: promptInsert.php
 *  Description: This file will insert the prompt and the response into the database using SQL.
 *  Last Change/Update: 4/19/2021
 *  Author: Kenny Choong
*/

// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
require_once "configInsertAdmin.php";

//Set variables
$prompt_response = "";
$user_id = "";

//Check to see if the form is sending via POST method
if (isset($_GET['prompt_id'])) {

    //Set variables to be equal to survey responses
    $prompt_id = $_GET["prompt_id"];
    $prompt_response = $_POST["prompt_response"];
    $user_id = $_SESSION["user_id"];

    //Create an SQL statement to be injected into the database
    $sql = "SELECT grwth_prompt_name.prompt
            FROM grwth_prompt_name
            WHERE grwth_prompt_name.prompt_id = ?";

    if($stmt = mysqli_prepare($link, $sql)){

      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_prompt_id);

      //Set parameters
      $param_prompt_id = $prompt_id;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){

          mysqli_stmt_bind_result($stmt, $col1);

          mysqli_stmt_fetch($stmt);
          $prompt_title = $col1;
        }
      }

      $cleaned_prompt_response = str_replace("'","''","$prompt_response");
    //Create an SQL statement to be injected into the database
    $sql2 = "INSERT INTO grwth_prompt(user_id,prompt_title,prompt_response,sentiment_value)
            VALUES ('$user_id','$prompt_title','$cleaned_prompt_response','5')";

    //Check to see if the query can run, if it can't throw an error, if it can, redirect to the userprompts page.
    if(!mysqli_query($con,$sql2)){
      echo "There was an error submitting your response, please try again.";
    } else {
      header("Location:  http://127.0.0.1/edsa-Grwth/Grwthjournal/php/dashboard.php");
    }
}

//Close the connection
mysqli_close($con);
?>
