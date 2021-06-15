<?php
/*  Application: Prompt Edit File
 *  Script Name: promptEdit.php
 *  Description: This is a file that puts the user's desired prompt into a text area to be edited and resubmitted to the databse.
 *  Last Change/Update: 4/19/2021
 *  Author: Kenny Choong
*/

// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
require_once "configInsertAdmin.php";

//Set variables
$prompt_title = "";
$prompt_response = "";
$user_id = "";
//Check to see if the form is sending via POST method
if (isset($_GET["entry_id"])) {

    //Set variables to be equal to survey responses and set a session variable for the selected prompt response.
    $user_id = $_SESSION["user_id"];
    $entry_id = $_GET["entry_id"];
    $_SESSION["entry_id"] = $entry_id;

    //Create an SQL statement to be injected into the database
    $sql = "SELECT grwth_prompt.prompt_title, grwth_prompt.prompt_response, grwth_prompt.submitted_at, grwth_prompt.entry_id
            FROM grwth_prompt
            WHERE grwth_prompt.entry_id = ?";

    if($stmt = mysqli_prepare($link, $sql)){

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_entry_id);

        // Set parameters
        $param_entry_id = $entry_id;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){

          mysqli_stmt_bind_result($stmt, $col1, $col2, $col3,$col4);

          mysqli_stmt_fetch($stmt);
          $prompt_title = $col1;
          $prompt_response = $col2;
        }
      }
} else {
  echo "It didn't work";
}
//Close the connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Prompt Goes Here</title>
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
        <li><a href="dashboard.php">User Dashboard</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>



	<!-- Main -->
		<section id="main" class="wrapper" style="background:linear-gradient(135deg, #1190c2 0%, #12b3a0 74%);">
			<div class="inner">
				<header>
					<h1 style="text-align:center; font-size:3rem; color: ghostwhite; text-shadow: 0px 1px 1px rgb(146, 109, 46);"><?php echo $prompt_title?></h1>
				</header>
				<div class="content" style="background-color: none; color: black; font-size:1.4rem; border-radius: 2rem;">

					<form method="Post" action="promptEditInsert.php">
						<section>
							<textarea style="border:none; background-color: white; color: black; font-size:1.4rem; border-radius: 2rem;" name="prompt_response" rows="12" cols="50" maxlength="500" placeholder="Release your thoughts here"><?php echo $prompt_response; ?></textarea>
						</section>
						<br />
						<input type="submit" name="Save" value="Save" style="border-radius:20px;">
					</form>
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

    	</body>
    </html>
