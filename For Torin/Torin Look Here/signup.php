<?php
/*  Application: Signup File
 *  Script Name: signup.php
 *  Description: This is the signup page where we will add new users to our database and check to see if they're already registered. They may add a name if they so choose.
 *  Last Change/Update: 5/16/2021
 *  Author: Kenny Choong
*/

// Start session
session_start();

// Include config file ($link should already be in config file)
require_once "configInsertAdmin.php";

//Define variables with empty values
$email = $password = $confirm_password = $preferred_name = "";
$email_err = $password_err = $confirm_password_err = "";

//Check to see if the form method is POST
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{

        // Prepare a select statement
        $sql = "SELECT user_id FROM grwth_login WHERE email = ?";

        //Prepare the link and the sql, if it fails, throw an error.
        if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters and clean up email
            $email = trim($_POST["email"]);

            //Removing illegal characters from email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            //Validating email... if it works, define the email variable, otherwise throw an error.
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
              $param_email = $email;
            } else {
              $email_err = "Not a valid email address.";
            }
          } else {
            echo "The link or the sql failed.";
          }


            // Attempt to execute the prepared statement, if it fails, throw an error
            if(mysqli_stmt_execute($stmt)){

                /* store result */
                mysqli_stmt_store_result($stmt);

                //If the resulting sql shows 1 row of data, then the email is already in use, otherwise trim the email.
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "An account with this email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
          }

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
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO grwth_login (email ,preferred_name ,password) VALUES (?, ?, ?)";

        //Prepare the link and SQL, if it fails, throw an error.
        if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_preferred_name, $param_password);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_preferred_name = trim($_POST["preferred_name"]); // Added preferred name to insert

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

              //Get the user_id for currently signed up user to initialize their first 5 prompts.
              $sql = "SELECT user_id, email FROM grwth_login WHERE email = ?";

              if($stmt = mysqli_prepare($link, $sql)){

                  // Bind variables to the prepared statement as parameters
                  mysqli_stmt_bind_param($stmt, "s", $param_email);

                  // Set parameters
                  $param_email = $email;

                  // Attempt to execute the prepared statement
                  if(mysqli_stmt_execute($stmt)){

                      // Store result
                      mysqli_stmt_store_result($stmt);

                      // Check if username exists, if yes then verify password
                      if(mysqli_stmt_num_rows($stmt) == 1){

                          // Bind result variables
                          mysqli_stmt_bind_result($stmt, $user_id, $email);

                          // Put 5 prompts under the user's id in the grwth_prompt_name table for the user's dashboard.
                          if(mysqli_stmt_fetch($stmt)){

                            $prompt1 = 'How was your day?';
                            $prompt2 = 'What is one thing you are happy about today?';
                            $prompt3 = 'What do you plan to do in the next couple of days?';
                            $prompt4 = 'If you were an animal, what would you be and why?';
                            $prompt5 = 'If you had $500, what would you buy and why?';

                            $intervals = array(
                              array(1,$prompt1),
                              array(2,$prompt2),
                              array(3,$prompt3),
                              array(4,$prompt4),
                              array(5,$prompt5));

                            foreach($intervals as $interval){
                                $x = implode(array_slice($interval,0,1));
                                $y = implode(array_slice($interval,1,1));
                                $sql = "INSERT INTO grwth_prompt_name(user_prompt_id, prompt, user_id)
                                        VALUES ('$x','$y','$user_id')";

                                if(!mysqli_query($con,$sql)){
                                  echo "Not Inserted";
                                }
                            }
                          }
                        }
                      }
                    }

                // Redirect to login page
                header("location: login.php");

            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
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
						<h1>Create An Account</h1>

						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
							<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
								<label>Email</label>
								<input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
								<span class="help-block"><?php echo $email_err; ?></span>
							</div>
              <div class="form-group">
								<label>Preferred Name</label>
								<input type="text" name="preferred_name" class="form-control" value="<?php echo $preferred_name; ?>">
								<span class="help-block"></span>
							</div>
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
								  <input type="reset" class="btn btn-default" value="Reset">
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
