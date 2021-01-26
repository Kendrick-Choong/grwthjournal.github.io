<?php
/*  Application: Grwth Survey Insert File
 *  Script Name: GrwthSurveyInsert.php
 *  Description: This form inserts our survey data from our main html page about user's journaling habits.
 *  Last Change/Update: 12/16/2020
 *  Author: Kenny Choong
*/

// Start session
session_start();

// Load Functions
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// This is where function to connect to the database will be included
require_once "configInsert.php";

// Set script variables
$we_have_input = false;
$journal_type = "";

// Handling and chekcing POST data
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST["submit"])){

    // check journal type they like (Good)
    if(!empty($_POST["journal_type_like"])){
      $journal_type_like = test_input($_POST["journal_type_like"]);
    } else {
      $journal_type_like = "";
    }

    // check frequency of journaling (Good)
    if(isset($_POST["freq_journal"])){
      $freq_journal = $_POST["freq_journal"];
    } else {
      $freq_journal = "";
    }

    // check types of journal experience (Good)
    if(isset($_POST["journal_type"])){
      $check_box = $_POST["journal_type"];
      foreach($check_box as $check_box_result){
        $journal_type.=$check_box_result.",";
      }
    } else {
      $journal_type = "";
    }

    // check the number of journals they have done before (Good)
    if(isset($_POST["journal_number"])){
      $journal_number = $_POST["journal_number"];
    } else {
      $journal_number = "";
    }

    // check the comfort level of journaling
    if(isset($_POST["comfort_level"])){
      $comfort_level = $_POST["comfort_level"];
    }

    // check the comfort level of journaling with tickmarks
    if(isset($_POST["comfort_level2"])){
      $comfort_level2 = $_POST["comfort_level2"];
    }

    // check if there are any additional comments
    if(!empty($_POST["additional_comments"])){
      $additional_comments = test_input($_POST["additional_comments"]);
    } else {
      $additional_comments = "";
    }

    $we_have_input = true;

    // Write it to the database
    if($we_have_input == true){
      $sql = "INSERT INTO grwth_survey(journal_type_like,freq_journal,journal_type_exp,prev_journal_num,comfort_with_journal,comfort_with_journal_v2,comments)
              VALUES ('$journal_type_like','$freq_journal','$journal_type','$journal_number','$comfort_level','$comfort_level2','$additional_comments')";
      if(!mysqli_query($con,$sql)){
        echo "Not Inserted";
      } else {
        header("Location: http://grwthjournal.co/index.html");
        mysqli_close($con);
        exit();
      }
    } else {
      echo "Please add input to the form.";
    }
  }
} else {
  echo "<script>alert('Please change the survey method to POST.')</script>";
}
mysqli_close($con);
?>
