<?php
/*  Application: Grwth Feedback Insert File
*  Script Name: GrwthFeedbackInsert.php
*  Description: This file inserts the feedback responses from our feedback form.
*  Last Change/Update: 12/16/2020
*  Author: Kenny Choong
*/

// Start session
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['submit'])) {

    // connecting to Database
    require_once "configInsert.php";

    //Data from feedback form
    $prompt_quality = $_POST["prompt_quality"];
    $navigation_quality = $_POST["navigation_quality"];
    $understand_our_product = $_POST["understand_our_product"];
    $comfortable_with_product = $_POST["comfortable_with_product"];
    $enjoy_product = $_POST["enjoy_product"];
    $product_useful = $_POST["product_useful"];
    $improve_on = $_POST["improve_on"];
    $want_added = $_POST["want_added"];

    //check if inputs are empty
    if (empty($prompt_quality) || empty($navigation_quality) || empty($understand_our_product) || empty($comfortable_with_product) || empty($enjoy_product) || empty($product_useful) || empty($improve_on) || empty($want_added)) {
      header("Location: http://grwthjournal.co/php/feedback.php?feedback=empty");
      exit();
    }

    //Insert the survey data into the database
    $sql = "INSERT INTO grwth_feedback(promptQuality,navigationQuality,understandOurProduct,comfortableWithProduct,enjoyProduct,productUseful,improveOn, wantAdded)
            VALUES ('$prompt_quality','$navigation_quality','$understand_our_product','$comfortable_with_product','$enjoy_product','$product_useful','$improve_on','$want_added')";
  }
}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Feedback Survey</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="./../assets/css/main.css" />
	</head>
  <body class="is-preload" id="loginBody">

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

		<!-- Main -->
		<section id="cta" class="wrapper">
			<div class="inner">


          <?php if(!mysqli_query($con,$sql)){
                echo "<p style='font-size: 2rem;'>There was an error submitting your response, please try again.</p>";
              } else {
                echo "<p style='font-size: 2rem;'>Thank You For Your Feedback!</p>";
              } ?>
					<a href="./../index.html" style="font-size: 2rem;">Home</a>





				<!-- Script for making the survey questions rotate-->
				<script>

					function survChange(curr, next) {
						document.getElementById("q" + curr).style.display = "none";
						document.getElementById("q" + next).style.display = "block";
					}

				</script>
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
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>

	</body>
</html>
