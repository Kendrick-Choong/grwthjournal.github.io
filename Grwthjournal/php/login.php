<?php
/*  Application: Login File
 *  Script Name: login.php
 *  Description: Serves as the login page for users and checks the database if the user exists.
 *  Last Change/Update: 09/24/2020
*/

// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: userhome.php");
    exit;
}
// Include config file
require_once "configInsertAdmin.php";

$link = mysqli_connect($db_server,$db_username,$db_password,$db_name);

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  echo "hi";
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM grwth_login WHERE email = ?";

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
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            // Redirect user to welcome page
                            header("location: userhome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
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
				<li><a href="signup.php">Sign Up</a></li>
			</ul>
		</nav>

		<!-- Heading
	<div id="heading" >
		<h1>Login</h1>
	</div> -->
		<!-- Main -->
		<section id="main" class="wrapper" style="background:linear-gradient(135deg, #1190c2 0%, #12b3a0 74%);">
			<div class="inner">
				<div class="content" style="margin: 0 10%; border-radius:20px;">

					<!--<img src="./images/plant.png" class="plant">-->
					<h1>Login</h1>
					<form>
            <p>Please fill in your credentials to login.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
				<br>
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>
				<br>
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>

						<a href="./../progress.html">Lost Your Password?</a><br>
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
							<li><a href="./../progress.html">Privacy Policy</a></li>
							<li><a href="signup.php">Signup</a></li>
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
		<script src="./../assets/js/jquery.min.js"></script>
		<script src="./../assets/js/browser.min.js"></script>
		<script src="./../assets/js/breakpoints.min.js"></script>
		<script src="./../assets/js/util.js"></script>
		<script src="./../assets/js/main.js"></script>

	</body>
</html>
