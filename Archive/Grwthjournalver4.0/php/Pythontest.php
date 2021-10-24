<?php
    $command = escapeshellcmd('./../python/pythontest.py');
    $output = shell_exec($command);
    echo $output;
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    //Set the user id
    $user_id = $_SESSION["user_id"];

    //Create an SQL statement
    $sql = "SELECT grwth_prompt.prompt_title, grwth_prompt.prompt_response, grwth_prompt.submitted_at, grwth_prompt.entry_id, AVG(grwth_prompt.sentiment_value)
            FROM grwth_prompt
            INNER JOIN grwth_login
            ON grwth_prompt.user_id = grwth_login.user_id
            WHERE grwth_login.user_id = ?
            GROUP BY DATE_FORMAT(grwth_prompt.submitted_at, '%d')
						";
		// Remember to add LIMIT 3;

		//Prepare the link and the sql, if they don't work, throw an error.
    if($stmt = mysqli_prepare($link, $sql)){

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_user_id);

        // Set parameters
        $param_user_id = $user_id;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){

          // Store result
          mysqli_stmt_bind_result($stmt, $col1, $col2, $col3,$col4, $col5);

					$data_day = $data_week = $data_month = $data_year = "[";

          while(mysqli_stmt_fetch($stmt)){
            $col3 = date_create($col3);
            $data_day .= "{x: '".date_format($col3,"m/d/Y")."', y: ".$col5."}, ";
            $data_week .= "{x: '".date_format($col3,"m/d/Y")."', y: ".$col5."}, ";
            $data_month .= "{x: '".date_format($col3,"F Y")."', y: ".$col5."}, ";
            $data_year .= "{x: '".date_format($col3,"Y")."', y: ".$col5."}, ";
          }

					$data_day .= "]";
          $data_week .= "]";
          $data_month .= "]";
          $data_year .= "]";

        } else {
          echo "0 results";
        }
        echo $data_month;
    // Close statement
    mysqli_stmt_close($stmt);

  } else {
    echo "It didn't work.";
  }
} else {
  echo "It's not working";
?>
