<?php
//THIS IS A WORKING SIGN-UP PAGE.
// Start session
session_start();

// Include config file
require_once "config.php";

$link = mysqli_connect($db_server,$db_username,$db_password,$db_name);

$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters and clean up email
            $email = trim($_POST["email"]);
              //Removing illegal characters from email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

              //Validating email
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
              $param_email = $email;
            } else {
              $email_err = "Not a valid email address.";
            }
          }


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "An account with this email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
          }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
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
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.html");
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

<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>


        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
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
            <div>
                  <input type="submit" class="btn btn-primary" value="Submit">
                  <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.html">Login here</a>.</p>
        </form>
    </div>
</body>
</html> -->





<!DOCTYPE HTML>
<!--
	Industrious by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
<head>
	<title>Sign Up</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" href="main.css" />
</head>
<body class="is-preload" id="loginBody">

	<!-- Header -->
	<header id="header">
		<a href="#" class="logo icon fa-tree"><span class="label">Icon</span></a>
		<nav>
			<a href="#menu">Menu</a>
		</nav>
	</header>

	<!-- Nav -->
	<nav id="menu">
		<ul class="links">
			<li><a href="index.html">Home</a></li>
			<li><a href="about.html">About</a></li>
			<li><a href="signup.html">Sign Up</a></li>
		</ul>
	</nav>

	<!-- Heading
	<div id="heading" >
		<h1>Login</h1>
	</div> -->
	<!-- Main -->





	<section id="main" class="wrapper" style="background:linear-gradient(135deg, #1190c2 0%, #12b3a0 74%);">
		<div class="inner" id="center">
			<div>

				<section>
					<div class="content signupbox" style="margin: 0 10%; border-radius:20px;">

						<!--<img src="./images/plant.png" class="plant">-->
						<h1>Create An Account</h1>

						<!--<form>
							<p>
								Email
								<input type="text" name="" placeholder="Enter Email" style="width: 100%;">
							</p>
							<br />
							<p>
								Preferred Name
								<input type="text" name="" placeholder="Enter Preferred Name" style="width: 100%;">
							</p>
							<br />
							<p>
								Password
								<input type="password" name="" placeholder="Enter Password" style="width: 100%;">
							</p>
							<br />
							<p>
								Confirm Password
								<input type="password" name="" placeholder="Confirm Password" style="width: 100%;">
							</p>
							<br />
							<p>
								<input type="radio" name="" value="yes" id="yes">
								<label for="yes"></label> I have read the <a href="#">Privacy Policy</a> and accept it
							</p>
							<p />
							<br />

							<input type="submit" name="" value="Sign Up"> <br>

							<br />
							<br />

							<a href="#">Already have an account? Login</a><br>

						</form> -->




						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
							<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
								<label>Email</label>
								<input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
								<span class="help-block"><?php echo $email_err; ?></span>
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
							<div>
								  <input type="submit" class="btn btn-primary" value="Submit">
								  <input type="reset" class="btn btn-default" value="Reset">
							</div>
							<p>Already have an account? <a href="login.html">Login here</a>.</p>
						</form>





					</div>
				</section>

			</div>
		</div>
	</section>
















	<!--<section class="wrapper">
		<div class="inner">
			<header class="special">


				<div class="signupbox">
					<!--<img src="./images/plant.png" class="plant">
					<h1>Create An Account</h1>
					<br />
					<form>
						<p>Email</p>
						<input type="text" name="" placeholder="Enter Email">
						<br />
						<p>Username</p>
						<input type="text" name="" placeholder="Enter Preferred Name">
						<br />
						<p>Password</p>
						<input type="password" name="" placeholder="Enter Password">
						<br />
						<p>Confirm Password</p>
						<input type="password" name="" placeholder="Confirm Password">
						<br />
						<p>
							<input type="radio" name="" value="yes" id="yes">
							<label for="yes"></label> I have read the <a href="#">Privacy Policy</a> and accept it
						</p>
						<p />
						<br />

						<input type="submit" name="" value="Sign Up"> <br>

						<br />

						<a href="#">Already have an account? Login</a><br>
					</form>


				</div>



			</header>
		</div>
	</section> -->
	<!-- Footer -->
	<footer id="footer">
		<div class="inner">
			<div class="content">
				<section>
					<h3>Accumsan montes viverra</h3>
					<p>Nunc lacinia ante nunc ac lobortis. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus ornare mi ut ante amet placerat aliquet. Volutpat eu sed ante lacinia sapien lorem accumsan varius montes viverra nibh in adipiscing. Lorem ipsum dolor vestibulum ante ipsum primis in faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing sed feugiat eu faucibus. Integer ac sed amet praesent. Nunc lacinia ante nunc ac gravida.</p>
				</section>
				<section>
					<h4>Sem turpis amet semper</h4>
					<ul class="alt">
						<li><a href="#">Dolor pulvinar sed etiam.</a></li>
						<li><a href="#">Etiam vel lorem sed amet.</a></li>
						<li><a href="#">Felis enim feugiat viverra.</a></li>
						<li><a href="#">Dolor pulvinar magna etiam.</a></li>
					</ul>
				</section>
				<section>
					<h4>Magna sed ipsum</h4>
					<ul class="plain">
						<li><a href="#"><i class="icon fa-twitter">&nbsp;</i>Twitter</a></li>
						<li><a href="#"><i class="icon fa-facebook">&nbsp;</i>Facebook</a></li>
						<li><a href="#"><i class="icon fa-instagram">&nbsp;</i>Instagram</a></li>
						<li><a href="#"><i class="icon fa-github">&nbsp;</i>Github</a></li>
					</ul>
				</section>
			</div>
			<div class="copyright">
				&copy; Untitled. Photos <a href="https://unsplash.co">Unsplash</a>, Video <a href="https://coverr.co">Coverr</a>.
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
