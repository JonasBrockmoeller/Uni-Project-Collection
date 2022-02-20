<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',0);
include_once('dbconnect.php');

function circlepfp($filepath, $savepath){
$ext = pathinfo($filepath, PATHINFO_EXTENSION);
$image_s = imagecreatefrompng($filepath);
$width = imagesx($image_s);
$height = imagesy($image_s);
$newwidth = 285;
$newheight = 232;
$image = imagecreatetruecolor($newwidth, $newheight);
imagealphablending($image,true);
imagecopyresampled($image,$image_s,0,0,0,0,$newwidth,$newheight,$width,$height);
// create masking
$mask = imagecreatetruecolor($width, $height);
$mask = imagecreatetruecolor($newwidth, $newheight);
$transparent = imagecolorallocate($mask, 255, 0, 0);
imagecolortransparent($mask, $transparent);
imagefilledellipse($mask, $newwidth/2, $newheight/2, $newwidth, $newheight, $transparent);
$red = imagecolorallocate($mask, 0, 0, 0);
imagecopymerge($image, $mask, 0, 0, 0, 0, $newwidth, $newheight,100);
imagecolortransparent($image, $red);
imagefill($image,0,0, $red);
// output and free memory
header('Content-type: image/png');
imagepng($image, $savepath);
}

$email = $_SESSION['email'];
$uname = $_SESSION['uname'];
$psw = password_hash($_SESSION['psw'], PASSWORD_DEFAULT);
$cardNumber = password_hash($_SESSION['cardNumber'], PASSWORD_DEFAULT);
$cardholder = password_hash($_SESSION['cardholder'], PASSWORD_DEFAULT);
$cardexpm = password_hash($_SESSION['cardexpm'], PASSWORD_DEFAULT);
$cardexpy = password_hash($_SESSION['cardexpy'], PASSWORD_DEFAULT);
$cvv = password_hash($_SESSION['cvv'] , PASSWORD_DEFAULT);
$_SESSION['bio'] = $_POST['bio'];
$bio = $_SESSION['bio'];
$_SESSION['nick'] = $_POST['nick'];
$nick = $_SESSION['nick'];

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
        <title>Finalize profile setup</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
	<br>
        <aside>

            <img class="asidePic" src="/source_images/music_note.png">

        </aside>

        <section>
            <form action="profile_setup.php" method = "post" enctype="multipart/form-data">
                <div class="container">

                    <a href="index.php"><img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png"></a>

                    <h1>Finish setting up your profile (Optional)</h1>

                    <p>Please fill in this form to complete your profile.</p>
                    <hr>
                    <input type="text" placeholder="Enter your nickname" name="nick" id="psw"><br>
                    <input type="text" placeholder="Write a brief bio about yourself" name="bio" id="psw">

                    <h2>Upload a profile picture (.png format)</h2>
                    <input type="file" name="image_png"><br>

                    <hr>

                    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p><br>
                    <p>Please note that if you skip this step you can always change these settings on your profile page.
                    <button type="submit" name="Submit" class="registerbtn">Complete registration</button>

                </div>

                <div class="container signin">
                    <hr>
                    <p>Already have an account? <a href="login.php">Sign in</a>.</p>
                </div>

            </form>
';


if(isset($_POST["Submit"]))
{
  if(is_uploaded_file($_FILES["image_png"]["tmp_name"]) == TRUE && !isset($nick) && !isset($bio)){

    $imagetmp = $_FILES["image_png"]["tmp_name"];
    $imagepath = $_FILES["image_png"]["name"];
    $filepath1 = "images/profile_pictures/circle_".$uname.".png";
    $filepath2 = "images/profile_pictures/".$uname.".png";

    move_uploaded_file($imagetmp,$filepath2);


    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $filetype = finfo_file($finfo, $filepath2);
    finfo_close($finfo);
    $exte = pathinfo($imagepath, PATHINFO_EXTENSION);


      if($filetype == 'image/png'){
          circlepfp($filepath2, $filepath1);
          echo"<br>Successfully entered song image.";
          $succession = TRUE;
      }else{
          unlink($filepath2);
          $_SESSION['Errormessage'] = "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error: Entered file's format was ".$filetype.". It should have been image/png. Please try again.<br>";
          $Errormessage = $_SESSION['Errormessage'];

        echo $Errormessage;
        $succession = FALSE;
      }
  if($succession == TRUE){
  if(!empty($_SESSION['cardNumber']) and !empty($_SESSION['cardholder']) and !empty($_SESSION['cardexpm']) and !empty($_SESSION['cvv'])) { //prepared statements
  try {
  $query1 = "INSERT INTO account (username, subscription_id, last_billing_day, email, password) values(?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($query1);
  $stmt->execute([$uname, 2, 1, $email, $psw]);


  $query2="INSERT INTO payments (account_username, cardnumber, CARDHOLDER, exmonth, exyear, cvv, credit) values(?, ?, ?, ?, ?, ?, ?)";
  $stmt1 = $conn->prepare($query2);
  $stmt1->execute([$uname, $cardNumber, $cardholder, $cardexpm, $cardexpy, $cvv, 30]);
  }

  catch(PDOException $e)
  {
  echo "Creation failed: " . $e->getMessage();
  }
  }
  echo'</section> </body> </html>';

    header('Location: homepage.php');
}
}elseif(is_uploaded_file($_FILES["image_png"]["tmp_name"]) == TRUE && isset($nick) && !isset($bio)){

$imagetmp = $_FILES["image_png"]["tmp_name"];
$imagepath = $_FILES["image_png"]["name"];
$filepath1 = "images/profile_pictures/circle_".$uname.".png";
$filepath2 = "images/profile_pictures/".$uname.".png";

move_uploaded_file($imagetmp,$filepath2);


$finfo = finfo_open(FILEINFO_MIME_TYPE);
$filetype = finfo_file($finfo, $filepath2);
finfo_close($finfo);
$exte = pathinfo($imagepath, PATHINFO_EXTENSION);


  if($filetype == 'image/png'){
      circlepfp($filepath2, $filepath1);
      echo"<br>Successfully entered song image.";
      $succession = TRUE;
  }else{
      unlink($filepath2);
      $_SESSION['Errormessage'] = "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error: Entered file's format was ".$filetype.". It should have been image/png. Please try again.<br>";
      $Errormessage = $_SESSION['Errormessage'];

    echo $Errormessage;
    $succession = FALSE;
  }
if($succession == TRUE){
if(!empty($_SESSION['cardNumber']) and !empty($_SESSION['cardholder']) and !empty($_SESSION['cardexpm']) and !empty($_SESSION['cvv'])) { //prepared statements
try {
$query1 = "INSERT INTO account (username, subscription_id, last_billing_day, display_name, email, password) values(?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query1);
$stmt->execute([$uname, 2, 1, $nick, $email, $psw]);


$query2="INSERT INTO payments (account_username, cardnumber, CARDHOLDER, exmonth, exyear, cvv, credit) values(?, ?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($query2);
$stmt1->execute([$uname, $cardNumber, $cardholder, $cardexpm, $cardexpy, $cvv, 30]);
}

catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
}
echo'</section> </body> </html>';

header('Location: homepage.php');
}
}elseif(is_uploaded_file($_FILES["image_png"]["tmp_name"]) == TRUE && isset($nick) && isset($bio)){
$imagetmp = $_FILES["image_png"]["tmp_name"];
$imagepath = $_FILES["image_png"]["name"];
$filepath1 = "images/profile_pictures/circle_".$uname.".png";
$filepath2 = "images/profile_pictures/".$uname.".png";

move_uploaded_file($imagetmp,$filepath2);


$finfo = finfo_open(FILEINFO_MIME_TYPE);
$filetype = finfo_file($finfo, $filepath2);
finfo_close($finfo);
$exte = pathinfo($imagepath, PATHINFO_EXTENSION);


  if($filetype == 'image/png'){
      circlepfp($filepath2, $filepath1);
      echo"<br>Successfully entered song image.";
      $succession = TRUE;
  }else{
      unlink($filepath2);
      $_SESSION['Errormessage'] = "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error: Entered file's format was ".$filetype.". It should have been image/png. Please try again.<br>";
      $Errormessage = $_SESSION['Errormessage'];

    echo $Errormessage;
    $succession = FALSE;
  }
if($succession == TRUE){
if(!empty($_SESSION['cardNumber']) and !empty($_SESSION['cardholder']) and !empty($_SESSION['cardexpm']) and !empty($_SESSION['cvv'])) { //prepared statements
try {
$query1 = "INSERT INTO account (username, subscription_id, last_billing_day, display_name, email, password, description) values(?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query1);
$stmt->execute([$uname, 2, 1, $nick, $email, $psw, $bio]);


$query2="INSERT INTO payments (account_username, cardnumber, CARDHOLDER, exmonth, exyear, cvv, credit) values(?, ?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($query2);
$stmt1->execute([$uname, $cardNumber, $cardholder, $cardexpm, $cardexpy, $cvv, 30]);
}

catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
}
echo'</section> </body> </html>';

header('Location: homepage.php?nocache='.rand(10, 99999));
echo "succeeded";
}
}elseif(is_uploaded_file($_FILES["image_png"]["tmp_name"]) == TRUE && !isset($nick) && isset($bio)){
$imagetmp = $_FILES["image_png"]["tmp_name"];
$imagepath = $_FILES["image_png"]["name"];
$filepath1 = "images/profile_pictures/circle_".$uname.".png";
$filepath2 = "images/profile_pictures/".$uname.".png";

move_uploaded_file($imagetmp,$filepath2);


$finfo = finfo_open(FILEINFO_MIME_TYPE);
$filetype = finfo_file($finfo, $filepath2);
finfo_close($finfo);
$exte = pathinfo($imagepath, PATHINFO_EXTENSION);


  if($filetype == 'image/png'){
      circlepfp($filepath2, $filepath1);
      echo"<br>Successfully entered song image.";
      $succession = TRUE;
  }else{
      unlink($filepath2);
      $_SESSION['Errormessage'] = "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error: Entered file's format was ".$filetype.". It should have been image/png. Please try again.<br>";
      $Errormessage = $_SESSION['Errormessage'];

    echo $Errormessage;
    $succession = FALSE;
  }
if($succession == TRUE){
if(!empty($_SESSION['cardNumber']) and !empty($_SESSION['cardholder']) and !empty($_SESSION['cardexpm']) and !empty($_SESSION['cvv'])) { //prepared statements
try {
$query1 = "INSERT INTO account (username, subscription_id, last_billing_day, email, password, description) values(?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query1);
$stmt->execute([$uname, 2, 1, $email, $psw, $bio]);


$query2="INSERT INTO payments (account_username, cardnumber, CARDHOLDER, exmonth, exyear, cvv, credit) values(?, ?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($query2);
$stmt1->execute([$uname, $cardNumber, $cardholder, $cardexpm, $cardexpy, $cvv, 30]);
}

catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
}
echo'</section> </body> </html>';

header('Location: homepage.php?nocache='.rand(10, 99999));
echo "succeeded";
}
}elseif(is_uploaded_file($_FILES["image_png"]["tmp_name"]) == FALSE && !isset($nick) && !isset($bio)){

if(!empty($_SESSION['cardNumber']) and !empty($_SESSION['cardholder']) and !empty($_SESSION['cardexpm']) and !empty($_SESSION['cvv'])) { //prepared statements
try {
$query1 = "INSERT INTO account (username, subscription_id, last_billing_day, email, password) values(?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query1);
$stmt->execute([$uname, 2, 1, $email, $psw]);


$query2="INSERT INTO payments (account_username, cardnumber, CARDHOLDER, exmonth, exyear, cvv, credit) values(?, ?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($query2);
$stmt1->execute([$uname, $cardNumber, $cardholder, $cardexpm, $cardexpy, $cvv, 30]);
}

catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
}
echo'</section> </body> </html>';

header('Location: homepage.php?nocache='.rand(10, 99999));
echo "succeeded";

}elseif(is_uploaded_file($_FILES["image_png"]["tmp_name"]) == FALSE && isset($nick) && !isset($bio)){

if(!empty($_SESSION['cardNumber']) and !empty($_SESSION['cardholder']) and !empty($_SESSION['cardexpm']) and !empty($_SESSION['cvv'])) { //prepared statements
try {
  $query1 = "INSERT INTO account (username, subscription_id, last_billing_day, display_name, email, password) values(?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($query1);
  $stmt->execute([$uname, 2, 1, $nick, $email, $psw]);


  $query2="INSERT INTO payments (account_username, cardnumber, CARDHOLDER, exmonth, exyear, cvv, credit) values(?, ?, ?, ?, ?, ?, ?)";
  $stmt1 = $conn->prepare($query2);
  $stmt1->execute([$uname, $cardNumber, $cardholder, $cardexpm, $cardexpy, $cvv, 30]);
}

catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
}
echo'</section> </body> </html>';

header('Location: homepage.php?nocache='.rand(10, 99999));
echo "succeeded";

}elseif(is_uploaded_file($_FILES["image_png"]["tmp_name"]) == FALSE && !isset($nick) && isset($bio)){
  echo "5";

if(!empty($_SESSION['cardNumber']) and !empty($_SESSION['cardholder']) and !empty($_SESSION['cardexpm']) and !empty($_SESSION['cvv'])) { //prepared statements
try {
  $query1 = "INSERT INTO account (username, subscription_id, last_billing_day, description, email, password) values(?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($query1);
  $stmt->execute([$uname, 2, 1, $bio, $email, $psw]);


  $query2="INSERT INTO payments (account_username, cardnumber, CARDHOLDER, exmonth, exyear, cvv, credit) values(?, ?, ?, ?, ?, ?, ?)";
  $stmt1 = $conn->prepare($query2);
  $stmt1->execute([$uname, $cardNumber, $cardholder, $cardexpm, $cardexpy, $cvv, 30]);
}

catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
}
echo'</section> </body> </html>';

header('Location: homepage.php?nocache='.rand(10, 99999));
echo "succeeded";

}elseif(is_uploaded_file($_FILES["image_png"]["tmp_name"]) == FALSE && isset($nick) && isset($bio)){
  echo "6";

if(!empty($_SESSION['cardNumber']) and !empty($_SESSION['cardholder']) and !empty($_SESSION['cardexpm']) and !empty($_SESSION['cvv'])) { //prepared statements
try {
  $query1 = "INSERT INTO account (username, subscription_id, last_billing_day, display_name, email, password, description) values(?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($query1);
  $stmt->execute([$uname, 2, 1, $nick, $email, $psw, $bio]);


$query2="INSERT INTO payments (account_username, cardnumber, CARDHOLDER, exmonth, exyear, cvv, credit) values(?, ?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($query2);
$stmt1->execute([$uname, $cardNumber, $cardholder, $cardexpm, $cardexpy, $cvv, 30]);
}

catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
}
echo'</section> </body> </html>';

header('Location: homepage.php?nocache='.rand(10, 99999));
echo "succeeded";

}
  echo'</section> </body> </html>';


}
?>
