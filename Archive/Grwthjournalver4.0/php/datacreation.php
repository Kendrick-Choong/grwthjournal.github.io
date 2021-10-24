<?php
// Check if the user is already logged in, if yes then redirect him to welcome page
require_once "configInsertAdmin.php";

//Set variables
$prompt_title = "What might a day of yours look like in 4 years?";
$prompt_response = "Test test testing";
$user_id = "10";

for ($x = 0; $x <=4000; $x++){
  $sentiment_value = rand(1,10);
  $time = strtotime(date('Y/m/d',time()).'-'.$x.'days');
  $submitted_at = date('Y/m/d H:i:s',$time);
    //Create an SQL statement to be injected into the database
    $sql = "INSERT INTO grwth_prompt(user_id,prompt_title,prompt_response,sentiment_value,submitted_at)
            VALUES ('$user_id','$prompt_title','$prompt_response','$sentiment_value','$submitted_at')";

    //Check to see if the query can run, if it can't throw an error, if it can, redirect to the userprompts page.
    if(!mysqli_query($con,$sql)){
      echo "There was an error submitting your response, please try again.";
    }
}
 ?>
