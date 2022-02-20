<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',0);
include_once('dbconnect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/PHPMailer/src/Exception.php';
require '/var/www/html/PHPMailer/src/PHPMailer.php';
require '/var/www/html/PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);

$emailaddress = $_SESSION['email_address']; //this one's the variable from the login page in case they were redirected to the register page
$pwfemail = $_SESSION['pwf_email_address']; //this one's the variable from the passwordforgotten page in case they were redirected to the register page

$_SESSION['email'] = $_POST['email'];
$email = $_SESSION['email'];

$_SESSION['emailadd'] = $_POST['emailadd'];
$emailadd = $_SESSION['emailadd'];

$_SESSION['uname'] = $_POST['uname'];
$uname = $_SESSION['uname'];

$_SESSION['usrname'] = $_POST['usrname'];
$usrname = $_SESSION['usrname'];

$_SESSION['psw'] = $_POST['psw'];
$psw = $_SESSION['psw'];

$_SESSION['pass'] = $_POST['pass'];
$pass = $_SESSION['pass'];

$_SESSION['psw-repeat'] = $_POST['psw-repeat'];
$rpsw = $_SESSION['psw-repeat'];

$_SESSION['pass-repeat'] = $_POST['pass-repeat'];
$rpass = $_SESSION['pass-repeat'];

$_SESSION['confirmcode'] = $_POST['confirmcode'];
$confirmcode = $_SESSION['confirmcode'];

$_SESSION['alreadysentmail'] = $_POST['alreadysentmail'];
$alreadysent = $_SESSION['alreadysentmail'];

$_SESSION['enteredcc'] = $_POST['enteredcc'];
$enteredcc = $_SESSION['enteredcc'];

$subject = "Your registration at Songify";

$true = "true";

// confirmation code generator
function confirmationcodegenerator() {
    $characters = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $array = array();
    $universal_set_length = strlen($characters) - 1;
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, $universal_set_length);
        $array[] = $characters[$n];
    }
    return implode($array);
}


echo'
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <link rel="stylesheet" href="/css/register.css">

    <head>
        <title>Register to Songify</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
	<br>
        <aside>

            <img class="asidePic" src="/source_images/main-qimg-1e1a36a42698c414db02aa23bf5ea412.png">

        </aside>

        <section>
            <form action="register.php" method = "post">
                <div class="container">

                    <a href="index.php"><img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png"></a>

                    <h1>Register</h1>

                    <p>Please fill in this form to create an account.</p>
                    <hr>';

                    if(isset($uname)){
                    echo '<input type="text" placeholder="Enter Username" name="usrname" id="uname" value ="';
                    echo $uname;
                    echo '"';
                    }
                    else{
                    echo '<input type="text" placeholder="Enter Username" name="usrname" id="uname"';
                    }

                    echo ' required>';

                    if(isset($emailaddress)){
                    echo '<input type="email" placeholder="Enter Email" name="emailadd" id="email" value ="';
                    echo $emailaddress;
                    echo '"';
                    }
                    elseif(isset($pwfemail)){
                    echo '<input type="email" placeholder="Enter Email" name="emailadd" id="email" value ="';
                    echo $pwfemail;
                    echo '"';
                    }
                    elseif(isset($email)){
                    echo '<input type="email" placeholder="Enter Email" name="emailadd" id="email" value ="';
                    echo $email;
                    echo '"';
                    }
                    else{
                    echo '<input type="email" placeholder="Enter Email" name="emailadd" id="email"';
                    }

                    echo' required>

                    <input type="password" placeholder="Enter Password" name="pass" id="psw" required>

                    <input type="password" placeholder="Repeat Password" name="pass-repeat" id="psw-repeat" required>
                    <hr>

                    <p>By creating an account you agree to our <a href="terms_of_service.php">Terms & Privacy</a>.</p>

                    <button type="submit" name="Submit" class="registerbtn">Register</button>

                </div>

                <div class="container signin">
                    <hr>
                    <p>Already have an account? <a href="login.php">Sign in</a>.</p>
                </div>

            </form>
';
echo'<div class="container">';
if(isset($emailadd)){
  try {
  $stmt = $conn->prepare("SELECT COUNT(*) FROM account WHERE email = ?");
  $stmt->execute([$emailadd]);
  $data1 = $stmt->fetch(PDO::FETCH_NUM);
  }
  catch(PDOException $e)
  {
  echo "Creation failed: " . $e->getMessage();
  }

  try {
  $stmt = $conn->prepare("SELECT COUNT(*) FROM account WHERE username = ?");
  $stmt->execute([$usrname]);
  $data2 = $stmt->fetch(PDO::FETCH_NUM);
  }
  catch(PDOException $e)
  {
  echo "Creation failed: " . $e->getMessage();
  }
}
if(isset($data1)){
  if($data2[0] == 1){
  echo "<p align = 'center'><br> Error: the username '$usrname' has already been taken.</p>";
  $succession = false;
  }elseif ($data1[0] == 1) {
  echo "<p align = 'center'><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error: the email address '$email' was already registered.</p>";
  $succession = false;
}elseif($pass != $rpass){
  echo "<p align = 'center'><br> Error: the two passwords don't match. Please try again.</p>";
  $succession = false;
  }elseif($data1[0] == 0 && $data2[0] == 0) {
			//mailing
			if($alreadysent != "true"){
			$ccode = confirmationcodegenerator();

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
          $mail->addAddress($emailadd, $usrname);     // Add a recipient

          // Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = $subject;
          $mail->Body    = "Dear $usrname, thanks for registering at Songify! In order to complete the registration process, you will need to submit the following code into the form at Songify so we can verify your email account: '$ccode'. King regards, Songify";
          $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

          $mail->send();
      } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
		  }
      echo "<h3>We need to verify your email account. A confirmation code has been sent to the specified email address. Please enter the code below:<h3>";
      //form
      echo'<h3>Enter your confirmation code</h3><form action="register.php" method="post">';

      if(isset($enteredcc)){
            echo'<input type="text" placeholder ="Confirmation code" name="enteredcc" value ="';
            echo $enteredcc;
            echo'" required>';
            echo'<input type="hidden" name="uname" value="';
            echo $usrname;
            echo'">';
            echo'<input type="hidden" name="email" value="';
            echo $emailadd;
            echo'">';
            echo'<input type="hidden" name="emailadd" value="';
            echo $emailadd;
            echo'">';
            echo'<input type="hidden" name="psw" value="';
            echo $pass;
            echo'">';
            echo'<input type="hidden" name="psw-repeat" value="';
            echo $rpass;
            echo'">';
						echo'<input type="hidden" name="confirmcode" value="';
						echo $ccode;
						echo'">';
						echo'<input type="hidden" name="alreadysentmail" value="';
						echo $true;
						echo'">';
						echo'<button type="submit" name="Submit_2" class="registerbtn">Submit</button></form>';

      } else{
            echo'<input type="text" placeholder ="Confirmation code" name="enteredcc" required>';
            echo'<input type="hidden" name="uname" value="';
            echo $usrname;
            echo'">';
            echo'<input type="hidden" name="emailadd" value="';
            echo $emailadd;
            echo'">';
            echo'<input type="hidden" name="email" value="';
            echo $emailadd;
            echo'">';
            echo'<input type="hidden" name="psw" value="';
            echo $pass;
            echo'">';
            echo'<input type="hidden" name="psw-repeat" value="';
            echo $rpass;
            echo'">';
						echo'<input type="hidden" name="confirmcode" value="';
						echo $ccode;
						echo'">';
						echo'<input type="hidden" name="alreadysentmail" value="';
						echo $true;
						echo'">';
						echo'<button type="submit" name="Submit_2" class="registerbtn">Submit</button></form>';
      }

/*
echo $confirmcode;
echo '<br>';
echo $enteredcc;
*/
      //end of form

            //check if confirm code is correct
            if(isset($_POST['Submit_2'])){
            if($enteredcc == $confirmcode){
										echo "That was the correct code! <br>";
                    echo'You will be redirected to the next page...';
                    $emailaddress = $email;
                    echo '<meta http-equiv="refresh" content="1;URL=payment_details.php"/> ';
             }else{
              echo "The entered confirmation code is incorrect. Please try again.";
            }

          }
}
}

echo'</section> </body> </html>';
?>
