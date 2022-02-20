<?php
session_start();
include_once('dbconnect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/PHPMailer/src/Exception.php';
require '/var/www/html/PHPMailer/src/PHPMailer.php';
require '/var/www/html/PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);
ini_set('display_errors',0);
include_once('dbconnect.php');
//css
echo '<html><head>
<title>Change Subscription</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<link rel="stylesheet" href="/css/register.css">';

//store the output of the form

if(isset($_SESSION['email'])){
$emailaddress = $_SESSION['email'];
} elseif(isset($_SESSION['email_address'])){
$emailaddress = $_SESSION['email_address'];
}

$_SESSION['description'] = $_POST['description'];
$description = $_SESSION['description'];

$_SESSION['alreadysentmail'] = $_POST['alreadysentmail'];
$alreadysentmail = $_SESSION['alreadysentmail'];

$account_type = $_SESSION['account_type'];

$subject = "Creator Application pending review";

if($account_type=='visitor'){
	echo '<meta http-equiv="refresh" content="0;URL=register.php"/> ';
}
else if( $account_type=='moderator'){
	echo '<meta http-equiv="refresh" content="0;URL=forbidden.php"/> ';
}

try {
$stmt = $conn->prepare("SELECT username FROM account WHERE email = ?");
$stmt->execute([$emailaddress]);
$data10 = $stmt->fetch(PDO::FETCH_NUM);
}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
$username = $data10[0];
//form itself
echo'
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <link rel="stylesheet" href="css/register.css">

    <head>
        <title>Change Subscription</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>

        <aside>

            <img class="asidePic" src="source_images/main-qimg-1e1a36a42698c414db02aa23bf5ea412.png" style="transform: scaleX(-1);pointer-events:none;">

        </aside>

        <section>
            <form action="change_sub.php" method ="post">
                <div class="container">

                    <a href="homepage.php"><img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png"></a>

                    <h1>Become a creator</h1>

                    <p>Please fill in this form to apply.</p>
                    <hr>

                    <textarea maxlength="500" style="padding:15px;border: none;background: #f1f1f1;display: flex;align-items: center;width:540pt;height:150pt;border-radius: 15px;" placeholder="Describe yourself and your music... (max 500 characters)" name="description" required></textarea>

										<input type="hidden" name="alreadysentmail" value="true">

										<br><br><input type="checkbox" id="boxx" required>
										<label for="boxx">I hereby confirm that I have read the Spotify <a href="terms_of_service.php">Terms of Service</a> and that I qualify for this position.</label><br>
                    <br><button type="submit" name="submit" class="registerbtn">Save & Apply</button>
					</form>


';

if(isset($_POST['submit']) && $_SESSION['first_run'] != 1){
try {
		//Server settings
		$mail->isSMTP();                                            // Send using SMTP
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = 'ssl://smtp.gmail.com';                    // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'songifymailer@gmail.com';                     // SMTP username
		$mail->Password   = '1A2b3C4d';                               // SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		//Recipients
		$mail->setFrom('songifymailer@gmail.com', 'Songify Mailer');
		$mail->addAddress('songifymailer@gmail.com', $username);     // Add a recipient

		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body = "The user $username has applied to become a composer with the following description: '".$description."' They are currently awaiting to be reviewed.";

		$mail->send();
} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
echo "Your submission was sent! It will be reviewed withing 5 days.
                </div>
                </section>
                </body>
                </html>";

								if(!isset($_SESSION['first_run'])){
								    $_SESSION['first_run'] = 1;
								}

}elseif(isset($_POST['submit']) && $_SESSION['first_run'] == 1){
	echo "You have already made an application! It is currently pending review.
	                </div>
	                </section>
	                </body>
	                </html>";
}
?>
