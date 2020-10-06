<?php
/*  Application: Grwth Insert File
 *  Script Name: GrwthInsert.php
 *  Description: inserts basic form data into a SQL database.
 *  Last Change/Update: 09/24/2020
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

// Handle POST data
// This is where we deal with the input from the form
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST['submit'])){

    // check journal type they like (Good)
    if(!empty($_POST['journal_type_like'])){
      $journal_type_like = test_input($_POST['journal_type_like']);
    } else {
      $journal_type_like = "";
    }

    // check frequency of journaling (Good)
    if(isset($_POST['freq_journal'])){
      $freq_journal = $_POST['freq_journal'];
    } else {
      $freq_journal = "";
    }

    // check types of journal experience (Good)
    if(isset($_POST['journaltype'])){
      $checkbox = $_POST['journaltype'];
      foreach($checkbox as $checkboxresult){
        $journal_type.=$checkboxresult.",";
      }
    } else {
      $journal_type = "";
    }

    // check the number of journals they have done before (Good)
    if(isset($_POST['journal_number'])){
      $journal_number = $_POST['journal_number'];
    } else {
      $journal_number = "";
    }

    // check the comfort level of journaling
    if(isset($_POST['comfort_level'])){
      $comfort_level = $_POST['comfort_level'];
    }

    // check the comfort level of journaling with tickmarks
    if(isset($_POST['comfort_level2'])){
      $comfort_level2 = $_POST['comfort_level2'];
    }

    // check if there are any additional comments
    if(!empty($_POST['additional_comments'])){
      $additional_comments = test_input($_POST['additional_comments']);
    } else {
      $additional_comments = "";
    }

    $we_have_input = true;

    //whether ip is from share internet
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
      {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
      }
    //whether ip is from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
      {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }
    //whether ip is from remote address
    else
      {
        $ip_address = $_SERVER['REMOTE_ADDR'];
      }

    // In this area you would:
    // Check/test/verify the user input
    // Prepare it to be written to the database

    // Write it to the database
    if($we_have_input == true){
      $sql = "INSERT INTO grwth_survey(journal_type_like,freq_journal,journal_type_exp,prev_journal_num,comfort_with_journal,comfort_with_journal_v2,comments)
              VALUES ('$journal_type_like','$freq_journal','$journal_type','$journal_number','$comfort_level','$comfort_level2','$additional_comments')";
      if(!mysqli_query($con,$sql)){
        echo 'Not Inserted';
      } else {
        echo 'Inserted';
      }
    } else {
      echo 'Please add input to the form.';
    }
  }
} else {
  echo '<script>alert("Please change the survey method to POST.")</script>';
}

header("refresh:2; url = grwthjournal.co");
mysqli_close($con);
?>

<!DOCTYPE HTML>
<!--
	Original template: Industrious by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)

	Edited version: Torin Johnson
	For grwthjournal.co
-->
<html>
	<head>
		<title>What Adventure Would You Like to Someday Go On?</title>
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
				<li><a href="feedback.php">Provide Feedback</a></li>
				<li><a href="singup.php">Sign Up</a></li>
			</ul>
		</nav>

		<!-- Heading
		<div id="heading" >
			<!-- <h1>About Us</h1> -->
		</div> -->

	<!-- Main -->
		<section id="main" class="wrapper" style="background:linear-gradient(135deg, #1190c2 0%, #12b3a0 74%);">
			<div class="inner">
				<header>
					<h1 style="text-align:center; font-size:3rem; color: ghostwhite; text-shadow: 0px 1px 1px rgb(146, 109, 46);">What Adventure Would You Like to Someday Go On?</h1>
				</header>
				<div class="content" style="background-color: none; color: black; font-size:1.4rem; border-radius: 2rem;">

					<section>
						<textarea style="border:none; background-color: white; color: black; font-size:1.4rem; border-radius: 2rem;" name="additional_comments" rows="12" cols="50" maxlength="500" placeholder="Release your thoughts here"></textarea>
					</section>
					<br />
					<input type="submit" name="Save" value="Save" style="border-radius:20px;">

					<!--<p>Lorem ipsum dolor sit accumsan interdum nisi, quis tincidunt felis sagittis eget. tempus euismod. Magna et cursus lorem faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing accumsan eu faucibus. Integer ac pellentesque praesent tincidunt felis sagittis eget. tempus euismod tempus. Vestibulum ante ipsum primis in faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing accumsan eu faucibus. Integer ac pellentesque praesent tincidunt felis sagittis eget. tempus euismod. Vestibulum ante ipsum primis in faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing accumsan eu faucibus. Integer ac sed amet praesent. Nunc lacinia ante nunc ac gravida lorem ipsum dolor sit amet dolor feugiat consequat. </p>
				<p>Lorem ipsum dolor sit accumsan interdum nisi, quis tincidunt felis sagittis eget. tempus euismod. Magna et cursus lorem faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing accumsan eu faucibus. Integer ac pellentesque praesent tincidunt felis sagittis eget. tempus euismod tempus. Vestibulum ante ipsum primis in faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing accumsan eu faucibus. Integer ac pellentesque praesent tincidunt felis sagittis eget. tempus euismod. Vestibulum ante ipsum primis in faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing accumsan eu faucibus. Integer ac sed amet praesent. Nunc lacinia ante nunc ac gravida lorem ipsum dolor sit amet dolor feugiat consequat. </p>
				<hr />
				<h3>About the Team</h3>
				<p>In arcu accumsan arcu adipiscing accumsan orci ac. Felis id enim aliquet. Accumsan ac integer lobortis commodo ornare aliquet accumsan erat tempus amet porttitor. Ante commodo blandit adipiscing integer semper orci eget. Faucibus commodo adipiscing mi eu nullam accumsan morbi arcu ornare odio mi adipiscing nascetur lacus ac interdum morbi accumsan vis mi accumsan ac praesent.</p>
				<p>Felis sagittis eget tempus primis in faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing accumsan eu faucibus. Integer ac pellentesque praesent tincidunt felis sagittis eget. tempus euismod. Magna sed etiam ante ipsum primis in faucibus vestibulum. Blandit adipiscing eu ipsum primis in faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing accumsan eu faucibus lorem ipsum dolor sit amet nullam.</p>
				<hr />
				<h3>Contact Us</h3>
				<a href="#" class="logo icon fa-envelope-o"><span class="label">Icon</span></a>
				<p>Email: support@grwthjournal.co</p>
				<a href="#" class="logo icon fa-phone"><span class="label">Icon</span></a>
				<p>Phone: +1 (970)-640-8353</p> -->
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
							<li><a href="login.php">Log In</a></li>
						</ul>
					</section>
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
