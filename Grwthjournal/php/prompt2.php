<?php
/*  Application: prompt File
 *  Script Name: prompt.php
 *  Description: Serves as the login page for users and checks the database if the user exists.
 *  Last Change/Update: 10/8/2020
*/

// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
require_once "configInsertAdmin.php";

$prompt_title = "What is the number one thing bothering your right now and why?";
$prompt_response = '';
$userID = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prompt_response = $_POST['promptresponse'];
    $userID = $_SESSION['userID'];
    $sql = "INSERT INTO grwth_prompt(userID,prompt_title,prompt_response)
            VALUES ('$userID','$prompt_title','$prompt_response')";

    if(!mysqli_query($con,$sql)){
      echo 'There was an error submitting your response, please try again.';
    } else {
      header("Location: http://grwthjournal.co/php/userprompts.php");
    }
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
		<section id="main" class="wrapper" style="background:linear-gradient(135deg, #1190c2 0%, #12b3a0 74%);">
			<div class="inner">
				<header>
					<h1 style="text-align:center; font-size:3rem; color: ghostwhite; text-shadow: 0px 1px 1px rgb(146, 109, 46);"><?php echo $prompt_title ?></h1>
				</header>
				<div class="content" style="background-color: none; color: black; font-size:1.4rem; border-radius: 2rem;">

					<form method="Post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
						<section>
							<textarea style="border:none; background-color: white; color: black; font-size:1.4rem; border-radius: 2rem;" name="promptresponse" rows="12" cols="50" maxlength="500" placeholder="Release your thoughts here"></textarea>
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
