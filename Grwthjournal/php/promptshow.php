<!DOCTYPE html>
<html>
	<head>
		<title>Prompt Show</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="./../assets/css/main.css" />
	</head>


<?php
/*  Application: prompt File
 *  Script Name: promptshow.php
 *  Description: Looks into the database and finds the user's journal responses.
 *  Last Change/Update: 10/12/2020
*/

// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
require_once "configInsertAdmin.php";

$link = mysqli_connect($db_server,$db_username,$db_password,$db_name);

$promptresponse = '';
$userID = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION['userID'];
    $sql = "SELECT grwth_prompt.promptresponse, grwth_prompt.submitted_at
            FROM grwth_prompt
            INNER JOIN grwth_login
            ON grwth_prompt.userID = grwth_login.userID
            WHERE grwth_login.userID = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_userID);

        // Set parameters
        $param_userID = $userID;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
          //set up table
          echo "<table class="styled-table"><tr><th>Response</th><th>Time</th></tr>";
          // Store result
          mysqli_stmt_bind_result($stmt, $col1, $col2);
          //output table data
          while(mysqli_stmt_fetch($stmt)){
            echo "<tr><td>".$col1."</td><td>".$col2."</td></tr>";
          }
          echo "</table>";
        } else {
          echo "0 results";
        }
    // Close statement
    mysqli_stmt_close($stmt);
  } else {
    echo "It didn't work.";
  }
} else {
  echo "It's not working";
}
?>

</html>
