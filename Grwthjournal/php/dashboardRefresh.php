<?php
/*  Application: Dashboard Refresh
*  Script Name: dashboardRefresh.php
*  Description: This script is utilized to refresh the data in the prompt entry section of the dashboard without refreshing the entire page.
*  Last Change/Update: 4/19/2021
*  Author: Kenny Choong
*/

session_start();

require_once "configInsertUser.php";

$prompt_response = "";
$prompt_title = "";
$counter = 0;
$style = "";

$newLimitCountStart = $_POST['newLimitCountStart'];

$user_id = "";
$user_id = $_SESSION["user_id"];

  //Create an SQL statement
  $sql = "SELECT grwth_prompt.prompt_title, grwth_prompt.prompt_response, grwth_prompt.submitted_at, grwth_prompt.entry_id
          FROM grwth_prompt
          INNER JOIN grwth_login
          ON grwth_prompt.user_id = grwth_login.user_id
          WHERE grwth_login.user_id = ?
          ORDER BY grwth_prompt.submitted_at DESC
          LIMIT $newLimitCountStart, 4
          ";

  //Prepare the link and the sql, if they don't work, throw an error.
  if($stmt = mysqli_prepare($link, $sql)){

      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_user_id);

      // Set parameters
      $param_user_id = $user_id;

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){

        // Bind result
        mysqli_stmt_bind_result($stmt, $col1, $col2, $col3,$col4);

        // Store result for num rows method
        mysqli_stmt_store_result($stmt);
        echo
        "<section id='oldPrompts'>";

          while(mysqli_stmt_fetch($stmt)){
            $col3 = date_create($col3);
            $counter++;
            if ($counter % 2 == 1){
              $style = "L";
            } else {
              $style = "R";
            }
            echo
            "<section class='oldEntries' id=".$style.">
              <!-- <img src='media/images/TreeBook.jpg'> -->
              <h3>".$col1."</h1>
              <p>".$col2."</p>
              <h4>".date_format($col3, "F d, Y")."</h4>
              <button type='button' id=".$col4." class='Edit'>Edit</button>
            </section>";
          }

        echo
        "<script type='text/javascript'>
          $('.Edit').click(function () {
              location.href = 'promptEdit.php?entry_id='+this.id;
          });
        </script>";

  // Close statement
  mysqli_stmt_close($stmt);

    } else {
      echo "The second if statement didn't work.";
    }
  } else {
    echo "The first if statement didn't work";
  }
?>
