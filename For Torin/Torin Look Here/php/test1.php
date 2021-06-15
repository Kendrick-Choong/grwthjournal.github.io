<?php echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n"; ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "phpmailer/vendor/autoload.php";
$email = 'mikekliang@gmail.com';
$key = '12345';

$output='<p>Dear user,</p>';
$output.='<p>Please click on the following link to reset your password.</p>';
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p><a href="http://grwthjournal.co/?
key='.$key.'&email='.$email.'&action=reset" target="_blank">
http://grwthjournal.co/
?key='.$key.'&email='.$email.'&action=reset</a></p>';
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

$mail->SMTPDebug = 3;

$mail->isSMTP();

$mail->Host = "smtp.mail.yahoo.com"; // Enter your host here

$mail->SMTPAuth = true;

$mail->SMTPSecure = "tls";

$mail->Username = "cpoke111@yahoo.com"; // Enter your email here

$mail->Password = "wnlcverrragdnbzu"; //Enter your password here

$mail->Port = 587;

$mail->IsHTML(true);

$mail->From = "cpoke111@yahoo.com";

$mail->FromName = "Kendrick Choong";

$mail->Subject = $subject;

$mail->Body = $body;

$mail->AddAddress($email);

try {
    $mail->send();
    echo "Message has been sent successfully";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
