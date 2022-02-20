<?php

session_start();
include_once('dbconnect.php');
error_reporting(E_ALL);
ini_set('display_errors',0);

if(isset($_SESSION['email'])){
$emailaddress = $_SESSION['email'];
} elseif(isset($_SESSION['email_address'])){
$emailaddress = $_SESSION['email_address'];
}

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

$password = $_SESSION['password'];
$account_type = $_SESSION['account_type'];

$_SESSION['email_address'] = $emailaddress;
$_SESSION['password'] = $password;

$_SESSION['searched']=$_POST['searched'];
$search = $_SESSION['searched'];

$_SESSION['searchedemail']=$_POST['searchedemail'];
$searchedemail = $_SESSION['searchedemail'];

$_SESSION['playingSong']=$_POST['playingSong'];
$playingSong = $_SESSION['playingSong'];

$_SESSION['NameplayingSong']=$_POST['NameplayingSong'];
$NameplayingSong = $_SESSION['NameplayingSong'];

$_SESSION['ArtistplayingSong']=$_POST['ArtistplayingSong'];
$ArtistplayingSong = $_SESSION['ArtistplayingSong'];

$_SESSION['isTeaser']=$_POST['isTeaser'];
$isTeaser = $_SESSION['isTeaser'];

$_SESSION['newdisplayname']=$_POST['newdisplayname'];
$newdisplayname = $_SESSION['newdisplayname'];

$_SESSION['newbiography']=$_POST['newbiography'];
$newbiography = $_SESSION['newbiography'];
    
try {
$stmt = $conn->prepare("SELECT display_name FROM account WHERE email = ?");
$stmt->execute([$emailaddress]);
$dataD = $stmt->fetch(PDO::FETCH_NUM);
}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}


try {
    $query1 = "SELECT subscription.name FROM public.subscription inner join public.account on subscription.id=account.subscription_id WHERE account.email=?";
    $stmt = $conn->prepare($query1);
    $stmt->execute([$emailaddress]);
    $data1 = $stmt->fetch(PDO::FETCH_NUM);
        
}
catch(PDOException $e)
{
    echo "Creation failed: " . $e->getMessage();
}
    
try {
    $stmt = $conn->prepare("SELECT username FROM account WHERE email = ?");
    $stmt->execute([$emailaddress]);
    $dataU = $stmt->fetch(PDO::FETCH_NUM);
}
catch(PDOException $e)
{
    echo "Creation failed: " . $e->getMessage();
}
$pfpname = preg_replace('/\s+/', '%20', $dataU[0]);
$account_type = $data1[0];

try {
$stmt = $conn->prepare("SELECT description FROM account WHERE email = ?");
$stmt->execute([$emailaddress]);
$dataB = $stmt->fetch(PDO::FETCH_NUM);
}
catch(PDOException $e)
{
echo "Creation failed: " . $e->getMessage();
}
    
try{
    $queryw3 = "select credit from payments where account_username='$pfpname'";
    $dataw3=$conn->query($queryw3);
}
catch(PDOException $e)
{
    echo "Creation failed: " . $e->getMessage();
}
foreach($dataw3 as $tempw3){$credit=$tempw3['credit'];break;}
    
if(isset($_POST['button1'])) {
    echo'buton1 was pressed';
    try {
        echo '$pfpname';
        $query007 = "UPDATE payments SET credit = '$credit' + 10.0 WHERE account_username = '$pfpname'";
        $conn -> query($query007);
        echo '<meta http-equiv="refresh" content="0;URL=profile_page.php"/> ';
    }
    catch(PDOException $e)
    {
        echo "Creation failed: " . $e->getMessage();
    }
}

$filecheck = 'images/profile_pictures/circle_'.$dataU[0].'.png';
echo '<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/profile_page.css">
    </head>
    <header>
        <div>
            <a href="homepage.php">
            <img class="headP" src="/source_images/Capture-removebg-preview-removebg-preview.png">
            <img class="headP" src="/source_images/cap.png">';
            if($account_type != 'visitor' && file_exists($filecheck) == TRUE){
            echo'
						<a href="profile_page.php">
            <img class="headPr" src="/images/profile_pictures/circle_'.$pfpname.'.png">
						<img class="headPr" src="/images/profile_pictures/circle_'.$pfpname.'.png">
						  </a>';}
						elseif($account_type != 'visitor' && file_exists($filecheck) == FALSE){
							echo'
							<a href="profile_page.php">
							<img class="headPr" src="/source_images/profile_icon_blue.png" width="120" height="100">
							<img class="headPr" src="/source_images/profile_icon_blue.png" width="120" height="100">
							  </a>';}
            echo'
            </a>';

            if(isset($emailaddress)){
              echo'<a href="logout.php"><button class="loginButton" style="height:30pt;margin-top:40pt;">Log out</button></a>';
            }
clearstatcache();

if(isset($searchedemail) && !empty($searchedemail)){$searchedemail=$_SESSION['searchedemail'];}
else $searchedemail=$emailaddress;

echo'

        <div class="wrap">
            <h2>Music begins where the possibilities of language end...</h2>

	<form action="search.php" method = "post" enctype="multipart/form-data">
 	<div class="search">

        <input type="text" class="searchTerm" placeholder="Type in name of song, album, artist..." name="searched" id="searched">
		<input type="hidden" name="playingSong" value="'.$playingSong.'">
	<input type="hidden" name="NameplayingSong" value="'.$NameplayingSong.'">
	<input type="hidden" name="ArtistplayingSong" value="'.$ArtistplayingSong.'">
	<input type="hidden" name="isTeaser" value="'.$isTeaser.'">

	<button type="submit" class="searchButton">

          <p>Search</p>
         </button>

         </div>
	</form>
        </div>

        </div>
    </header>

    <body>
        <div id="main-wrapper">
        <aside>
         <!--   <h1>Navigational menu</h1>-->';
            if($account_type != 'visitor')
            {
                echo "<br>Your email: $emailaddress <br>";
                echo '<br>You are currently a: '.$account_type.'<br><br>';
                echo "Your credit currently is: $credit €<br><br>";
            }
                else{
                    echo '<br>You are not registered.<br>';
                    echo "You are currently a: $account_type <br><br>";
                    }


        if($account_type=='listener' || $account_type=='moderator' || $account_type=='premium_listener')echo' <a href="library.php"><button class="button">Library</button></a>';
        if($account_type=='creator' || $account_type=='moderator')echo' <a href="upload_songs.php"><button class="button">Upload</button></a>';
        if($account_type=='creator')echo' <a href="edit_album_playlist.php"><button class="button">Albums</button></a>';
                            
        echo' <form method="post">
                <input type="submit" class="button" name="button1" value="Add 10€ credit"/>
              </form>';
                            
echo '</aside> <div class="container">';

echo'  <h1>Your account details</h1>
  <hr>
  <form action="profile_page.php" method="post" enctype="multipart/form-data">
  <h2>Nickname</h2>
  <p align = "center"><input maxlength="75" type="text" placeholder="Username" name="newdisplayname" value="'.$dataD[0].'" required>

  <h2>Current profile picture:</h2>
  <p align = "center"><img src="images/profile_pictures/'.$pfpname.'.png" width="120" height="100">


  <h2>Change your profile picture (.png format)</h2>
  <p align = "center"><input type="file" name="image_png"><br><br>

  <h2>Bio</h2>
  <p align = "center"><input maxlength="75" type="text" placeholder="Biography..." name="newbiography" value="'.$dataB[0].'" required>
  <br><button type="submit" name="Submit" class="registerbtn">Save & Apply</button>					</form>

  ';




if(isset($_POST['Submit'])){
  $imagetmp = $_FILES["image_png"]["tmp_name"];
  $imagepath = $_FILES["image_png"]["name"];
  $filepath1 = "images/profile_pictures/circle_".$dataU[0].".png";
  $filepath2 = "images/profile_pictures/".$dataU[0].".png";

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

  if(isset($newbiography) && isset($newdisplayname) && $succession == TRUE){
    try {
    $query2 = "UPDATE account SET display_name = ?, description = ? WHERE email = ?";
    $stmt = $conn->prepare($query2);
    $stmt->execute([$newdisplayname, $newbiography, $emailaddress]);
    }
    catch(PDOException $e)
    {
    echo "Creation failed: " . $e->getMessage();
    }
      header('Location: homepage.php?nocache='.rand(10, 99999));
  }

  elseif(!isset($newbiography) && isset($newdisplayname) && $succession == TRUE){
    try {
    $query2 = "UPDATE account SET display_name = ? WHERE email = ?";
    $stmt = $conn->prepare($query2);
    $stmt->execute([$newdisplayname, $emailaddress]);
    }
    catch(PDOException $e)
    {
    echo "Creation failed: " . $e->getMessage();
    }
      header('Location: homepage.php?nocache='.rand(10, 99999));
  }

  elseif(isset($newbiography) && !isset($newdisplayname) && $succession == TRUE){
    try {
    $query2 = "UPDATE account SET display_name = ? WHERE email = ?";
    $stmt = $conn->prepare($query2);
    $stmt->execute([$newdisplayname, $emailaddress]);
    }
    catch(PDOException $e)
    {
    echo "Creation failed: " . $e->getMessage();
    }
      header('Location: homepage.php?nocache='.rand(10, 99999));
  }

  elseif(!isset($newbiography) && !isset($newdisplayname) && $succession == TRUE){
      header('Location: homepage.php?nocache='.rand(10, 99999));
  }

  else{

  }

}




			if($account_type=='listener' || $account_type=='premium_listener' || $account_type=='inactive user'){
				echo'
        </div>
        </div>
         <footer style="">
             <a href="subscriptions.php" class="footb">Subscriptions</a>
             <a href="change_sub.php" class="footb">Become creator</a>
        <a href="about_us.php" class="footb">About us</a>
    </footer>';
			}
			elseif($account_type=='creator'){
				echo'
        </div>
        </div>
         <footer style="">
             <a href="subscriptions.php" class="footb">Subscriptions</a>
        <a href="about_us.php" class="footb">About us</a>
    </footer>';
			}
			else{

			}
	echo'
            </div></section>
    </body>

</html>';
$_SESSION['account_type'] = $account_type;
?>
