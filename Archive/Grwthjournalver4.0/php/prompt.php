<?php
/*  Application: Prompt File
 *  Script Name: prompt.php
 *  Description: This is a file that puts the user's desired prompt into a text area to be submitted to the databse.
 *  Last Change/Update: 4/15/2021
 *  Author: Kenny Choong
*/

// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
require_once "configInsertAdmin.php";

//Set variables
$user_id = "";

//Check to see if the form is sending via POST method
if (isset($_GET["prompt_id"])) {

    //Set variables to be equal to survey responses and set a session variable for the selected prompt response.
    $user_id = $_SESSION["user_id"];
    $prompt_id = $_GET["prompt_id"];

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
} else {
  echo "It didn't work";
}
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
		<nav>
			<a href="#menu" id="menuButt"></a>
		</nav>
	</header>

	<!-- Nav -->
	<nav id="menu">
		<ul class="links">
      <li><a href="./../index.html">Home</a></li>
      <li><a href="./../about.html">About</a></li>
      <li><a href="dashboard.php">Dashboard</a></li>
	  <li><a href="./../privacypolicy.html">Privacy Policy</a></li>
		</ul>
	</nav>



	<!-- Main -->
	<section class="largeBack">
		<section id="main" class="wrapper">
			<div class="inner">
				<header>
					<br>
					<h1 style="text-align:center; font-size:3rem; color: white;"><?php echo $prompt_title;?></h1>
					<br>
				</header>
				<div class="content" style="background-color: ghostwhite; color: black; font-size:1.4rem; border-radius: 2rem;">

					<form method="Post" action="promptInsert.php?prompt_id=<?php echo $prompt_id;?>">
						<section>
							<textarea style="border:none; background-color: ghostwhite; color: black; font-size:1.4rem; border-radius: 2rem;" name="prompt_response" rows="12" cols="50" maxlength="500" placeholder="Release your thoughts here"></textarea>
						</section>
						<br />
						<input type="submit" name="Submit" value="Submit" style="border-radius:20px;">
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
		</section>

    		<!-- Scripts -->
        <script src="./../assets/js/jquery.min.js"></script>
    		<script src="./../assets/js/browser.min.js"></script>
    		<script src="./../assets/js/breakpoints.min.js"></script>
    		<script src="./../assets/js/util.js"></script>
    		<script src="./../assets/js/main.js"></script>

    	</body>
    </html>
