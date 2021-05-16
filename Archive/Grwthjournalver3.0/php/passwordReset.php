<?php
/*  Application: Password Reset File
 *  Script Name: passwordReset.php
 *  Description: This is the password reset file that will verify a user's new password adheres to our requirements and makes sure the link is valid.
 *  Last Change/Update: 12/23/2020
 *  Author: Kenny Choong
*/

// Start session
session_start();

// Include config file ($link should already be in config file)
require_once "configInsertUser.php";

$password = $confirm_password = "";
$error = $password_err = $confirm_password_err = "";

if (isset($_GET["reset_key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && ($_SERVER["REQUEST_METHOD"] == "POST")){

   $reset_key = $_GET["reset_key"];
   $email = $_GET["email"];
   $cur_date = date("Y-m-d H:i:s");

   $sql = "SELECT * FROM grwth_password_reset_temp WHERE reset_key= '$reset_key' and email= '$email'";

   $query = mysqli_query($con,$sql);

   $row = mysqli_num_rows($query);

   if ($row == ""){

         $error .= '<h2>Invalid Link</h2>
         <p>The link is invalid/expired. Either you did not copy the correct link
         from the email, or you have already used the key in which case it is
         deactivated.</p>
         <p><a href="http://grwthjournal.co/php/resetPasswordEmail.php">
         Click here</a> to reset password.</p>';

       } else {

        $row = mysqli_fetch_assoc($query);
        $exp_date = $row['exp_date'];

        if ($exp_date >= $cur_date){

          // Validate password with at least 6 characters
          if(empty(trim($_POST["password"]))){
              $password_err = "Please enter a password.";
          } elseif(strlen(trim($_POST["password"])) < 6){
              $password_err = "Password must have at least 6 characters.";
          } else{
              $password = trim($_POST["password"]);
          }

          // Validate confirm password to see if they're the same
          if(empty(trim($_POST["confirm_password"]))){
              $confirm_password_err = "Please confirm password.";
          } else{
              $confirm_password = trim($_POST["confirm_password"]);
              if(empty($password_err) && ($password != $confirm_password)){
                  $confirm_password_err = "Password did not match.";
              }
          }

          // Check input errors before inserting in database
          if(empty($password_err) && empty($confirm_password_err)){

              // Prepare an update statement
              $sql = "UPDATE grwth_login SET grwth_login.password = (?) WHERE email = '$email'";

              //Prepare the link and SQL, if it fails, throw an error.
              if($stmt = mysqli_prepare($link, $sql)){

                  // Bind variables to the prepared statement as parameters
                  mysqli_stmt_bind_param($stmt, "s", $param_password);

                  // Set parameters
                  $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                  // Attempt to execute the prepared statement
                  if(!mysqli_stmt_execute($stmt)){

                      echo "Something went wrong. Please try again later.";

                  }
                }

            // Close statement
            mysqli_stmt_close($stmt);

            // Prepare a delete statement
            $sql = "DELETE FROM grwth_password_reset_temp WHERE email = '$email'";

            // Attempt to execute the prepared statement
            if(!mysqli_query($con,$sql)){

              echo "Not Inserted";

            } else {

              echo "<script>alert('Password Reset')</script>";

              // Redirect to login page
              header("location: login.php");
            }
          }
        } else {

          $error .= "<h2>Link Expired</h2>
          <p>The link is expired. You are trying to use the expired link which
          as valid only 24 hours (1 days after request).<br /><br /></p>";

        }
      }
    }

if($error!=""){
  echo "<div class='error'>".$error."</div><br />";
  }

?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Sign Up</title>
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
	<section id="main" class="wrapper" style="background:linear-gradient(135deg, #1190c2 0%, #12b3a0 74%);">
		<div class="inner" id="center">
			<div>

				<section>
					<div class="content signupbox" style="margin: 0 10%; border-radius:20px;">

						<!--<img src="./images/plant.png" class="plant">-->
						<h1>Reset Password</h1>

						<form action="" method="POST">
							<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
								<label>Password</label>
								<input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
								<span class="help-block"><?php echo $password_err; ?></span>
							</div>
							<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
								<label>Confirm Password</label>
								<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
								<span class="help-block"><?php echo $confirm_password_err; ?></span>
							</div>
							<br>
							<div>
								  <input type="submit" class="btn btn-primary" value="Submit">
							</div>
							<br>
							<p>Already have an account? <a href="login.php">Login here</a></p>
							<p><a href = "./../privacypolicy.html">Privacy Policy</a></p>
						</form>

					</div>
				</section>

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
