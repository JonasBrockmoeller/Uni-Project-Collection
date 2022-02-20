<?php
//session (re)starts/continues
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
require('dbconnect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/PHPMailer/src/Exception.php';
require '/var/www/html/PHPMailer/src/PHPMailer.php';
require '/var/www/html/PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);
//initializing variables from the form and previous pages
$emailaddress = $_SESSION['email_address'];

$_SESSION['pwf_email_address'] = $_POST['pwf_email_address'];
$email = $_SESSION['pwf_email_address'];

$_SESSION['enteredcc'] = $_POST['enteredcc'];
$enteredcc = $_SESSION['enteredcc'];

$_SESSION['newpassword'] = $_POST['newpassword'];
$newpassword = $_SESSION['newpassword'];

$_SESSION['confirmnewpassword'] = $_POST['confirmnewpassword'];
$confirmnewpassword = $_SESSION['confirmnewpassword'];

$_SESSION['confirmcode'] = $_POST['confirmcode'];
$confirmcode = $_SESSION['confirmcode'];

$_SESSION['alreadysentmail'] = $_POST['alreadysentmail'];
$alreadysent = $_SESSION['alreadysentmail'];

$subject = "Password reset request";

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


//form
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
        <div class="container">

            <a href="index.php"><img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png"></a>

<form action="passwordforgotten.php" method="post">
<h1>Forgot password?</h1>
<h3>Enter your email address:</h3>';
if(isset($emailaddress)){
  echo '<input type="email" placeholder ="Email address" name="pwf_email_address" value="';
  echo $emailaddress;
  echo '" required>';
}elseif(isset($email)){
  echo '<input type="email" placeholder ="Email address" name="pwf_email_address" value="';
  echo $email;
  echo '" required>';
}else{
  echo '<input type="email" placeholder ="Email address" name="pwf_email_address" required>';
}
echo '
  <button type="submit" class="registerbtn">Submit</button>
</form>
';
//end form

//queries

if(isset($email)){
try {
$query1 = $conn->query("SELECT COUNT(*) FROM account WHERE email = '$email'");
$data1 = $query1->fetch();
$query2 = $conn->query("SELECT username FROM account WHERE email = '$email'");
$data2 = $query2->fetch();
$username = $data2[0];
}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
}

if(isset($data1)){
if($data1[0] == 0){
  echo "Error: this email address has not been registered yet.<br>";
  echo 'Not registered yet? <a href ="register.php">Click here.</a>';
}else{
			//mailing
			if($alreadysent != "true"){
			$ccode = confirmationcodegenerator();



			///mail($email, $subject, "Dear $username, you indicated that you did not know your password anymore.
			//In order to reset your password,
			//you will need to submit the following code into the form at Songify: '$ccode'. King regards, Songify", NULL, "-fyiiiiiiziyilmaz@gmail.com");


      echo 'before trycatch';

      try {
          //Server settings
          $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
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
          $mail->addAddress($email, $username);     // Add a recipient

          // Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = $subject;
          $mail->Body    = "Dear $username, you indicated that you did not know your password anymore. In order to reset your password, you will need to submit the following code into the form at Songify: '$ccode'. King regards, Songify";
          $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

          $mail->send();
          echo 'Message has been sent';
      } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }



			echo "<br>Check your email inbox, we've sent you a confirmation code.<br>";
		  }

      //form
      echo'<h3>Enter your confirmation code</h3><form action="passwordforgotten.php" method="post">';

      if(isset($enteredcc)){
            echo'<input type="text" placeholder ="Confirmation code" name="enteredcc" value ="';
            echo $enteredcc;
            echo'" required>';
            echo'<input type="hidden" name="pwf_email_address" value="';
            echo $email;
            echo'">';
						echo'<input type="hidden" name="confirmcode" value="';
						echo $ccode;
						echo'">';
						echo'<input type="hidden" name="alreadysentmail" value="';
						echo $true;
						echo'">';
						echo'<button type="submit" class="registerbtn">Submit</button></form>';

      } else{
            echo'<input type="text" placeholder ="Confirmation code" name="enteredcc" required>';
						echo'<input type="hidden" name="pwf_email_address" value="';
						echo $email;
						echo'">';
						echo'<input type="hidden" name="confirmcode" value="';
						echo $ccode;
						echo'">';
						echo'<input type="hidden" name="alreadysentmail" value="';
						echo $true;
						echo'">';
						echo'<button type="submit" class="registerbtn">Submit</button></form>';
      }
/*
echo $confirmcode;
echo '<br>';
echo $enteredcc;
*/
      //end of form

            //check if confirm code is correct
            if(isset($enteredcc)){
            if($enteredcc == $confirmcode){
										echo "That was the correct code! <br>";
                    echo'<h3>Enter your new password twice</h3><form action = "passwordforgotten.php" method ="post">';

										if(isset($newpassword)){
										echo'<input type="password" placeholder ="New password" name="newpassword" value="';
										echo $newpassword;
										echo '" required>';
										}
										else{
										echo'<input type="password" placeholder ="New password" name="newpassword" required>';
									  }

										echo'<input type="password" placeholder ="Repeat password" name="confirmnewpassword" required>';
										echo'<input type="hidden" name="pwf_email_address" value="';
										echo $email;
										echo'">';
										echo'<input type="hidden" name="confirmcode" value="';
										echo $confirmcode;
										echo'">';
										echo'<input type="hidden" name="alreadysentmail" value="';
										echo $true;
										echo'">';
										echo'<input type="hidden" name="enteredcc" value="';
										echo $enteredcc;
										echo'">';
                    echo'<button type="submit" class="registerbtn">Submit</button>

                    </form>

                    ';
										if(isset($newpassword)){
                      $newpass = password_hash($newpassword, PASSWORD_DEFAULT);
                    //check if passwords match
                    if($newpassword == $confirmnewpassword){
                      try{
                                            $stmt = $conn->prepare('UPDATE account SET password = ? WHERE email = ?');
                                            $stmt->execute([$newpass, $email]);
                                            }
                                            catch(PDOException $e)
                                            {
                                            echo "Creation failed: " . $e->getMessage();
                                            }

                      echo 'Your password has been successfully changed.<br> You will now be redirected to the <a href="login.php">login page</a>...';
											echo '<meta http-equiv="refresh" content="5;URL=login.php"/> ';
                    }else{
                      echo "<br>The two passwords do not match. Please try again.<br>";
                    }

									}

             }else{
              echo "The entered confirmation code is incorrect. Please try again.";
            }

          }

}
}
?>
