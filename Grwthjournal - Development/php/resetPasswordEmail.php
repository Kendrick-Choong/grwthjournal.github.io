<?php
/*  Application: Password Reset Email File
 *  Script Name: passwordResetEmail.php
 *  Description: This file sends the email to the user so they can reset their password in case they lose it.
 *  Last Change/Update: 1/3/2021
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include config file and PhpMailer
require_once "configInsertUser.php";
require_once "phpmailer/vendor/autoload.php";

$link = mysqli_connect($db_server,$db_username,$db_password,$db_name);

// Define variables and initialize with empty values
$email = "";
$email_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Prepare a select statement
    $sql = "SELECT user_id FROM grwth_login WHERE email = ?";

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
      } else {
        echo "The link or the sql failed.";
      }

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){

        /* store result */
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1){
            $email = trim($_POST["email"]);
        } else{
            $email_err = "No user is registered with this email address.";
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    //Preparing SQL statement to check to see if temp key already exists (Might need deleting permission for this script)
    $sql = "DELETE FROM grwth_password_reset_temp WHERE email = ?";

    if($stmt = mysqli_prepare($link, $sql)){

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_email);

    }

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){

        /* store result */
        mysqli_stmt_store_result($stmt);

    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
    //Closing the statement and link
    mysqli_stmt_close($stmt);
    mysqli_close($link);



       if($email_err!=""){
         echo "<div class='error'>".$email_err."</div>
         <br /><a href='javascript:history.go(-1)'>Go Back</a>";
       } else{
         $exp_format = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
         $exp_date = date("Y-m-d H:i:s",$exp_format);
         $reset_key = md5(2418*2);
         $add_key = substr(md5(uniqid(rand(),1)),3,10);
         $reset_key = $reset_key . $add_key;
        // Insert Temp Table
        mysqli_query($con,
        "INSERT INTO `grwth_password_reset_temp` (`email`, `reset_key`, `exp_date`)
        VALUES ('".$email."', '".$reset_key."', '".$exp_date."');");

        $output='<p>Dear user,</p>';
        $output.='<p>Please click on the following link to reset your password.</p>';
        $output.='<p>-------------------------------------------------------------</p>';
        $output.='<p><a href="http://grwth-env.eba-qgk7pdim.us-west-2.elasticbeanstalk.com/php/passwordReset.php?
        reset_key='.$reset_key.'&email='.$email.'&action=reset" target="_blank">
        http://grwth-env.eba-qgk7pdim.us-west-2.elasticbeanstalk.com/php/passwordReset.php
        ?reset_key='.$reset_key.'&email='.$email.'&action=reset</a></p>';
        $output.='<p>-------------------------------------------------------------</p>';
        $output.='<p>Please be sure to copy the entire link into your browser.
        The link will expire after 1 day for security reason.</p>';
        $output.='<p>If you did not request this forgotten password email, no action
        is needed, your password will not be reset. However, you may want to log into
        your account and change your security password as someone may have guessed it.</p>';
        $output.='<p>Thanks,</p>';
        $output.='<p>Grwth Team</p>';
        $body = $output;

        $subject = "Password Recovery";

        $email_to = $email;

        $mail = new PHPMailer(true);

        $mail->isSMTP();

        $mail->Host = "smtp.mail.yahoo.com"; // Enter your host here

        $mail->SMTPAuth = true;

        $mail->SMTPSecure = "tls";

        $mail->Username = "cpoke111@yahoo.com"; // Enter your email here

        $mail->Password = "wnlcverrragdnbzu"; //Enter your password here

        $mail->Port = 587;

        $mail->IsHTML(true);

        $mail->From = "cpoke111@yahoo.com";

        $mail->FromName = "noreply@grwth.co";

        $mail->Subject = $subject;

        $mail->Body = $body;

        $mail->AddAddress($email);

        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;

        }

      echo '<script>alert("Email Sent")</script>';

      }
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Reset Password</title>
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

		<!-- Heading -->
		<!-- Main -->
		<section id="main" class="wrapper" style="background:linear-gradient(135deg, #1190c2 0%, #12b3a0 74%);">
			<div class="inner">
				<div class="content" style="margin: 0 10%; border-radius:20px;">


					<h1>Reset Password</h1>
            <p>Please fill in your email to reset your password.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
				<br>
                    <input onclick = "test()" type="submit" class="btn btn-primary" value="Reset">
                </div>
				<br>
                <p>Don't have an account? <a href="signup.php">Sign Up</a></
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
