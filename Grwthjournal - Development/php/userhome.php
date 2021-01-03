<?php
/*  Application: User Dahboard File
 *  Script Name: userhome.php
 *  Description: This is the first page that users see after they login into our website and serves as the user dashboard where they can see all of their stats.
 *  Last Change/Update: 1/3/2021
 *  Author: Kenny Choong
*/

// Initialize the session
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
			<h1><?php if(empty($_SESSION["preferred_name"])){
                    echo "Your";
                  } else {
                    echo htmlspecialchars($_SESSION["preferred_name"])."'s";
                  } ?> Dashboard</h1>
		</div>

		<!-- Main -->
		<section id="main" class="wrapper">
			<div class="inner">
				<div class="content">
					<header>
						<h2>Journal Entries</h2>
					</header>
					<a href="prompt1.php"><p>Journal Prompt 1</p></a>
					<a href="prompt2.php"><p>Journal Prompt 2</p></a>
          <a href="userprompts.php"><p>Get old prompts</p></a>
					<hr />
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
