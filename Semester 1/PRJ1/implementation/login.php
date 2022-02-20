<?php
session_start();
include_once('dbconnect.php');
error_reporting(E_ALL);
ini_set('display_errors',0);
//css
echo '<html><head>
<title>Log into Songify</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<link rel="stylesheet" href="/css/register.css">';

//store the output of the form

$_SESSION['email_address'] = $_POST['email_address'];
$emailaddress = $_SESSION['email_address'];

$_SESSION['password'] = $_POST['password'];
$password = $_SESSION['password'];

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
        <title>Log into Songify</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
	<br><br><br><br>
        <aside>

            <img class="asidePic" src="source_images/drummer-silhouette.png">

        </aside>

        <section>
            <form action="login.php" method = "post">
                <div class="container">

                    <a href="homepage.php"><img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png"></a>

                    <h1>Log in</h1>

                    <p>Please fill in this form to log in.</p>
                    <hr>

                    <input type="email" placeholder="Email address" name="email_address" value="';
                    echo $emailaddress;
                    echo'" required><br>
                    <input type="password" placeholder="Password" name="password" required><br>

                    <button type="submit" class="registerbtn">Log in</button>

                </div>

                <div class="container signin">
                    <hr>
                    <p>Forgot your password? <a href="passwordforgotten.php">Click here</a>.</p>
';



// Different scenarios for logging in: first = successful, second = half successful third = fully unsuccessful
if(isset($emailaddress)){
try {
$stmt = $conn->prepare("SELECT COUNT(*) FROM account WHERE email = ?");
$stmt->execute([$emailaddress]);
$data1 = $stmt->fetch(PDO::FETCH_NUM);

}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}

try {
echo "<br><br><br>";
$stmt = $conn->prepare("SELECT password FROM account WHERE email = ?");
$stmt->execute([$emailaddress]);
$data2 = $stmt->fetch(PDO::FETCH_NUM);

}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}

if ($data1[0] == 1 && password_verify($password, $data2[0])) {
echo '<meta http-equiv="refresh" content="0;URL=homepage.php"/> ';
}

elseif($data1[0] == 1 && !password_verify($password, $data2[0])){
	echo "That's not the right password for $emailaddress. Please try again.";
}
else {
	echo 'The person with the email address '.$emailaddress.'is not registered. 
  <a href="register.php">Click here</a> to register yourself.
  </div>
  </section>
  </body>
  </html>';
}
}
?>
