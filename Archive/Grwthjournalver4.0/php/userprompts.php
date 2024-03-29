<?php
/*  Application: User Prompts File
 *  Script Name: userprompts.php
 *  Description: This is the first page that users see after they login into our website.
 *  Last Change/Update: 1/10/2021
 *  Author: Kenny Choong
*/

// Initialize the session (has to be at the very beginning of any script before HTML or PHP).
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>User Page</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="./../assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Header -->
		<header id="header">
			<a href="./../index.html" class="logo icon fa-tree"><span class="label">Icon</span></a>
			<nav>
				<a href="#menu">Menu</a>
			</nav>
		</header>

		<!-- Nav -->
		<nav id="menu">
			<ul class="links">
				<li><a href="./../index.html">Home</a></li>
        <li><a href="./../about.html">About</a></li>
				<li><a href="feedback.php">Provide Feedback</a></li>
        <li><a href="signup.php">Sign Up</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="userhome.php">User Dashboard</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>

		<!-- Heading -->
		<div id="heading" style="background:linear-gradient(135deg, #1190c2 0%, #12b3a0 74%);">
			<h1>
        <?php if(empty($_SESSION["preferred_name"])){
                    echo "Your";
                  } else {
                    echo htmlspecialchars($_SESSION["preferred_name"])."'s";
                  } ?> Dashboard
     </h1>
		</div>

		<!-- Main -->
		<section id="main" class="wrapper">
			<div class="inner">
				<div class="content">

<?php

require_once "configInsertAdmin.php";

$link = mysqli_connect($db_server,$db_username,$db_password,$db_name);

$prompt_response = "";
$prompt_title = "";
$user_id = "";
$counter = 1;

//Check to see if the survey method is GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    //Set the user id
    $user_id = $_SESSION["user_id"];

    //Create an SQL statement
    $sql = "SELECT grwth_prompt.prompt_title, grwth_prompt.prompt_response, grwth_prompt.submitted_at, grwth_prompt.entry_id
            FROM grwth_prompt
            INNER JOIN grwth_login
            ON grwth_prompt.user_id = grwth_login.user_id
            WHERE grwth_login.user_id = ?";

    //Prepare the link and the sql, if they don't work, throw an error.
    if($stmt = mysqli_prepare($link, $sql)){

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_user_id);

        // Set parameters
        $param_user_id = $user_id;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){

          //set up table
          echo
					"<table class='styled-table'>
						<thead>
							<tr>
                <th>Prompt</th>
								<th>Response</th>
								<th>Time</th>
                <th>Action</th>
							</tr>
					  </thead>";

          // Store result
          mysqli_stmt_bind_result($stmt, $col1, $col2, $col3,$col4);

          //output table data
					echo
						"<tbody>";
          while(mysqli_stmt_fetch($stmt)){
            $col3 = date_create($col3);
            echo
						"<tr>
							<td>".$col1."</td>
							<td>".$col2."</td>
              <td>".date_format($col3, "F d, Y")."</td>
              <td>
                <button type='button' id=".$col4." class='Edit'>Edit</button>
                <button type='button' id=".$col4." class='Delete'>Delete</button>
              </td>
						</tr>";

          }
          echo
					 "</tbody>
				  </table>";
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
				</div>
			</div>
		</section>

		<!-- Footer -->
		<footer id="footer">
			<div class="inner">
				<div class="content">
					<section>
						<h3>Your Privacy is Our Concern</h3>
						<p>At Grwth, no human will <em>ever</em> see or use your individual data, and the machines will only use it (with your permission) to create custom repsonses for your benefit. If opted in, your data will be aggregated with thousands of other peoples to see large scale trends in population segments.</p>
					</section>
					<section>
						<h4>Navigation</h4>
						<ul class="alt">
							<li><a href="./../index.html">Home</a></li>
              <li><a href="./../about.html">About</a></li>
              <li><a href="signup.php">Logout</a></li>
							<li><a href="./../privacypolicy.html">Privacy Policy</a></li>
						</ul>
					</section>
					<!-- Icons for social media if we want to hyperlink our accounts -->
					<!--<section>
					<li><a href="#"><i class="icon fa-github">&nbsp;</i>Github</a></li>
					<h4>Follow Our Journey</h4>
					<ul class="plain">
						<li><a href="#"><i class="icon fa-twitter">&nbsp;</i>Twitter</a></li>
						<li><a href="#"><i class="icon fa-facebook">&nbsp;</i>Facebook</a></li>
						<li><a href="#"><i class="icon fa-instagram">&nbsp;</i>Instagram</a></li>
					</ul>
				</section> -->
				</div>
				<div class="copyright">
					&copy; grwthLLC
				</div>
			</div>
		</footer>

		<!-- Scripts -->
		<script src="./../assets/js/jquery.min.js"></script>
		<script src="./../assets/js/browser.min.js"></script>
		<script src="./../assets/js/breakpoints.min.js"></script>
		<script src="./../assets/js/util.js"></script>
		<script src="./../assets/js/main.js"></script>

    <script type="text/javascript">
      $(".Edit").click(function () {
          location.href = "promptEdit.php?entry_id="+this.id;
      });
    </script>

    <script type="text/javascript">
      $(".Delete").click(function () {
          location.href = "promptDeleteInsert.php?entry_id="+this.id;
      });
    </script>

	</body>
</html>
