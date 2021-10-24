<?php
/*  Application: Prompt Insert
 *  Script Name: promptInsert.php
 *  Description: This is a temporary static prompt page that displays the prompt "What might a day of yours look like in 4 year?".
 *  Last Change/Update: 4/16/2021
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
            WHERE grwth_prompt_name.user_id = $user_id and grwth_prompt_name.user_prompt_id = $prompt_id";

    if($stmt = mysqli_prepare($link, $sql)){

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
      header("Location:  http://grwthjournal.us-west-2.elasticbeanstalk.com/php/dashboard.php");
    }
}

//Close the connection
mysqli_close($con);
?>
