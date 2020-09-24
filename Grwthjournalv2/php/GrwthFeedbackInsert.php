<?php
/*  Application: Grwth Feedback Insert File
*  Script Name: GrwthFeedbackInsert.php
*  Description: inserts feedback form data into a SQL database.
*  Last Change/Update: 09/24/2020
*/

//Setting up variables


// Start session
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['submit'])) {

    // connecting to Database
    require_once "configInsert.php";

    //Functions


    //Data from feedback form
    $promptQuality = $_POST['promptQuality'];
    $navigationQuality = $_POST['navigationQuality'];
    $understandOurProduct = $_POST['understandOurProduct'];
    $comfortableWithProduct = $_POST['comfortableWithProduct'];
    $enjoyProduct = $_POST['enjoyProduct'];
    $productUseful = $_POST['productUseful'];
    $improveOn = $_POST['improveOn'];
    $wantAdded = $_POST['wantAdded'];

    //check if inputs are empty
    if (empty($promptQuality) || empty($navigationQuality) || empty($understandOurProduct) || empty($comfortableWithProduct) || empty($enjoyProduct) || empty($productUseful) || empty($improveOn) || empty($wantAdded)) {
      header("Location: ../edsa-Grwth/feedback.php?feedback=empty");
      exit();
    }
    $sql = "INSERT INTO grwth_feedback(promptQuality,navigationQuality,understandOurProduct,comfortableWithProduct,enjoyProduct,productUseful,improveOn, wantAdded)
            VALUES ('$promptQuality','$navigationQuality','$understandOurProduct','$comfortableWithProduct','$enjoyProduct','$productUseful','$improveOn','$wantAdded')";
    if(!mysqli_query($con,$sql)){
      echo 'Not Inserted';
    } else {
      echo 'Inserted';
    }
  }
}
?>
